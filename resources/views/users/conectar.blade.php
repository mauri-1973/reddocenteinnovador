@extends('home')

@section('title')
{{ Auth::user()->name }}
@endsection

@section('extra-css')

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" rel="stylesheet">

@endsection

@section('index')
<div class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="">
                    <h3>{{ trans('multi-leng.formerror244')}}</h3>

                    
                </div>
                <div class="card-body">
                    <table id="dt-mant-table" class="table table-bordered display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ trans('lang.nombreuser')}}</th>
                                <th>{{ trans('lang.apellidouser')}}</th>
                                <th>Email</th>
                                <th>{{ trans('lang.moviluser')}}</th>
                                <th>{{ trans('multi-leng.formerror233')}}</th>
                                <th>Avatar</th>
                                <th>Tags</th>
                                <th>Action</th>
                                <th>Oculto</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="staticBackdropforo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelforo" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="staticBackdropLabelforo">{{ trans('multi-leng.admcat')}}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body" id="modalbodyforo">

                ...

            </div>

            <div class="modal-footer" id="footerbodyforo">

                

            </div>

        </div>

    </div>

</div>
@endsection

@section('extra-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js"></script>
<script type="text/javascript">
    
    $(document).ready(function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });


        $('#dt-mant-table').DataTable({
            processing : true,
            serverSide : true,
            dom        : 'frtip',
            fixedHeader: true,
            order      : [[ 1, "asc" ]],
            ajax: "{{ route('conectar-usuarios-registrado') }}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'surname', name: 'surname' },
                { data: 'email', name: 'email' },
                { data: 'mobile', name: 'mobile' },
                { data: 'profesion', name: 'profesion' }, 
                { data: 'avatar', render: function ( data, type, row ) {
                    
                        
                        return `<img 
                            style="width:100px;height:auto;" 
                            id="logouser${row.id}" 
                            src="{{asset('storage/profile-pic')}}/${row.avatar}" 
                            alt="${row.name}" 
                            class="avatar border-gray"
                            onerror="this.onerror=null;this.src='{{ asset('storage/profile-pic/sinregistro.png') }}';" 
                        />`;
                    } 
                },
                {   data: 'tags',
                    render: function(data, type, row) {
                        if (Array.isArray(data)) {
                            // Usamos badge bg-primary y un pequeño margen-end
                            return data.map(function(tag) {
                                return '<span class="badge bg-primary p-2 me-1">#' + tag.tagnom + '</span>';
                            }).join(' ');
                        }
                        if (typeof data === "string" && data[0] === '[') {
                            try {
                                var tagsArr = JSON.parse(data);
                                return tagsArr.map(function(tag) {
                                    return '<span class="badge bg-primary p-2 me-1">#' + tag.tagnom + '</span>';
                                }).join(' ');
                            } catch (e) {
                                return '';
                            }
                        }
                        return '';
                    } 
                },
                { data: 'id', render: function ( data, type, row ) {
                    
                        let html = `<button type="button" class="btn btn-success btn-sm btn-block mb-1 sendmail" onclick="mostform('`+row.name+' '+row.surname+`', '${row.email}', '${row.encrypted_id}' )"  style="width:200px;"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; {{ trans('multi-leng.formerror254')}}</button>`;
                        var mobileStr = (row.mobile || '').toString();
                        if (mobileStr !== '') {
                        html += `<a href="tel:+56${mobileStr}" role="button" class="btn btn-primary btn-sm btn-block mb-1" style="width:200px;"><i class="fa fa-phone" aria-hidden="true"></i>
                        &nbsp;Llamar</a>`;
                        }
                        // Solo si es tipo string y cumple la condición
                        if (mobileStr.length >= 9 && mobileStr[mobileStr.length - 9] == '9') {
                        html += `<a href="https://api.whatsapp.com/send?phone=56${mobileStr}&text=Hola%20,te%20contacto%20desde%20Red%20Docente%20Innovador%20para%20contactar%20por%20este%20canal." target="_blank" role="button" class="btn btn-sm btn-block mb-1" style="width:200px;background-color:#27d268"><i class="fa fa-whatsapp" aria-hidden="true"></i>&nbsp;Whatsapp</a>`;
                        }
                        return html;
                        
                    } 
                },
                
                {
                    data: 'tags_flat'
                }
            ],
            columnDefs : [
                            {
                                "targets": [ 8 ],
                                "visible": false,
                                "searchable": true
                            },
                            {
                                "targets": [ 7 ],
                                "visible": true,
                                "searchable": false
                            },
            ],
            
            responsive: true,

            "language": {

                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"

            }
        });
    });

    function mostform(nombre, email, id)
    {
        $( "#staticBackdropLabelforo" ).html("{{ trans('multi-leng.formerror239')}}"+nombre);

        $( "#modalbodyforo" ).html(`<form class="formdelcat" id="formdelcat" name="formdelcat" method="POST" action="{{ url('') }}/enviar-email-conectar-usuarios-registrados" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="idhacia" name="idhacia" value="`+id+`">
                                    <div class="form-group">
                                        <label for="name"><b>{{ trans('multi-leng.formerror81')}}</b></label>
                                        <input type="text" class="form-control" id="name" value="`+nombre+`" name="name" aria-describedby="nameHelp" minlength="2" maxlength="50" size="50" placeholder="{{ __('multi-leng.namesubcat') }}" required readonly>
                                        <small id="nameHelp" class="form-text text-danger" style="display:none;"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="emai"><b>{{ trans('multi-leng.formerror81')}}</b></label>
                                        <input type="text" class="form-control" id="email" value="`+email+`" name="email" aria-describedby="emailHelp" minlength="2" maxlength="50" size="50" placeholder="{{ __('multi-leng.namesubcat') }}" required readonly>
                                        <small id="emailHelp" class="form-text text-danger" style="display:none;"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="tag5"><b>{{ trans('multi-leng.formerror240')}}</b><small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.formerror242') }}" data-html="true"></i></label> 
                                        <input type="text" class="form-control" id="asunto" name="asunto" minlength="2" maxlength="50" size="50" placeholder="{{ trans('multi-leng.formerror240')}}" aria-describedby="asuntoHelp">
                                        <small id="asuntoHelp" class="form-text text-danger" style="display:none;"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="summernote"><b>{{ trans('multi-leng.formerror241')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small></label>
                                        <textarea class="form-control" id="summernote" name="summernote" aria-describedby="summernoteHelp"></textarea>
                                        <small id="summernoteHelp" class="form-text text-danger" style="display:none;">{{ __('multi-leng.formerror243') }}</small>
                                    </div>
                                    <button type="submit" class="btn btn-danger">{{ trans('lang.enviar')}}</button>
                                    </form>`);

        $( "#footerbodyforo" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');

        $( "#staticBackdropforo" ).modal('show');
    }

    $('#staticBackdropforo').on('show.bs.modal', function (event) {

        $(function () {

            $('[data-toggle="tooltip"]').tooltip()

        });

        $('#summernote').summernote({
            dialogsInBody: true,
            placeholder: '{{ trans('multi-leng.formerror241')}}',
            tabsize: 2,
            fontNames: ['Arial', 'Arial Black', 'Calibri', 'Comic Sans MS', 'Courier New', 'Elephant', 'Georgia', 'Impact', 'Tahoma', 'Times New Roman'],
            fontNamesIgnoreCheck: ['Arial', 'Arial Black', 'Calibri', 'Comic Sans MS', 'Courier New', 'Elephant', 'Impact', 'Tahoma', 'Times New Roman'],
            height: 400,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['operation', ['undo', 'redo']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });

        $("#formdelcat").submit(function(e){

            $("#asuntoHelp").css("display", "none");
            $("#summernoteHelp").css("display", "none");
            var error = "";

            if($.trim($("#asunto").val()).length < 2)

            {

                error += "{{ __('multi-leng.formerror242') }}<br>";

                $("#asuntoHelp").html(error);

                $("#asuntoHelp").css("display", "block");

            }

            if($.trim($("#summernote").val()).length < 2)

            {

                error += "{{ __('multi-leng.formerror243') }}<br>";

                $("#summernoteHelp").html(error);

                $("#summernoteHelp").css("display", "block");

            }

            if(error != "")

            {

                return false;

            }

            else

            {

                return true;

            }

            

        });

    });
    
</script>
@endsection
