@extends('home')



@section('title')

{{ Auth::user()->name }}

@endsection



@section('extra-css')

<style>

    #nocat

    {

       color: red;

    }

</style>

@endsection





@section('index')

<div class="content">

    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="card">

                <div class="">

                    
                    @role('blog')

                    <h3>{{ trans('multi-leng.a291')}}</h3>

                    <button onclick="addcat();" class="btn btn-success btn-sm">{{ trans('multi-leng.a292')}}</button>

                    @endrole
                    
                </div>

                <div class="card-body">

                    <table id="dt-mant-table" class="table table-bordered display responsive nowrap" style="width:100%">

                        <thead>

                            <tr>
                                @role('blog')
                                <th>{{ trans('multi-leng.a286') }}</th>

                                <th>{{ trans('multi-leng.a287') }}</th>

                                <th>{{ trans('multi-leng.fechcrecat')}}</th>

                                <th>{{ trans('multi-leng.formerror112')}}</th>

                                <th>{{ trans('multi-leng.formerror113')}}</th>

                                <th>{{ trans('multi-leng.formerror114')}}</th>

                                <th>{{ trans('multi-leng.formerror22')}}</th>
                                @endrole
                                

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

<!-- Modal -->

<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="staticBackdropLabel">{{ trans('multi-leng.admcat')}}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body" id="modalbody">

                ...

            </div>

            <div class="modal-footer" id="footerbody">

                

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

<input type="hidden" id="status" name="status">

@endsection



@section('extra-script')

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
            responsive: true,
            @role('blog')

                ajax: "{{ route('acciones.foro.publico.blog') }}",

            @endrole
            
                columns: [
                { data: 'nombre', name: 'nombre' },
                { data: 'nameforum', name: 'nameforum' },
                { data: 'fecha', name: 'fecha' },
                { data: 'uspen', name: 'uspen', render: function ( data, type, row ) {
                        
                    return `<button onclick="searchus('${row.idencrypt}', 0);" class="btn btn-success btn-sm btn-block">{{ trans('multi-leng.formerror125')}} </button>`;

                    } 
                },
                { data: 'usact', name: 'usact', render: function ( data, type, row ) {
                        
                    return `<button onclick="searchus('${row.idencrypt}', 1);" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.formerror125')}} </button>`;

                    } 

                }, 
                { data: 'useli', name: 'useli', render: function ( data, type, row ) {
                        
                    return `<button onclick="searchus('${row.idencrypt}', 2);" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.formerror125')}} </button>`;

                    }

                }, 
                { data: 'idencrypt', name: 'idencrypt', render: function ( data, type, row ) {

                    @role('blog')

                    return `<a href="{{ url('acceder-forum-usuarios-activos-foro-publico-blog') }}/${data}" class="btn btn-dark btn-sm btn-block mb-1">{{ trans('multi-leng.formerror120') }}</a>

                    <button onclick="editcat('${row.nameforum}', '${data}' )" class="btn btn-info btn-sm btn-block mb-1">{{ trans('multi-leng.a293') }}</button>

                    <button onclick="elicat('${row.nameforum}', '${data}' )" class="btn btn-danger btn-sm btn-block mb-1">{{ trans('multi-leng.a294') }}</button>`;

                    @endrole
                        
                   
                } 
            },
            ],
            
            "language": {

                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"

            }

        });

        const divs = document.querySelectorAll('.editcat');

        divs.forEach(el => el.addEventListener('click', event => {
            console.log("ok");
        }));
        

    });
    
    function editcat(nombre, id)
    {
        $( "#staticBackdropLabel" ).html("{{ trans('lang.editar')}} {{ trans('multi-leng.a287') }}: "+nombre);

        $( "#modalbody" ).html(`<form id="formadd" method="POST" action="{{ route('ingreso.foro.publico.blog') }}" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label for="namecat"><b>{{ trans('multi-leng.a287')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a289') }}" data-html="true"></i></label>
                <input type="text" class="form-control" id="namecat" name="namecat" aria-describedby="nameHelp" minlength="2" maxlength="50" size="50" placeholder="{{ __('multi-leng.a287') }}" value="${nombre}" required>
                <small id="nameHelp" class="form-text text-danger" style="display:none;">{{ __('multi-leng.a289') }}</small>
            </div>
            <input type="hidden" name="type" name="type" value="edi">
            <input type="hidden" id="idfor" name="idfor" value="${id}">
            <button type="submit" class="btn btn-warning">{{ trans('lang.editar')}}</button></form>
        `);

        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');

        $( "#staticBackdrop" ).modal('show');
    }

    function elicat(nombre, id)
    {
        $( "#staticBackdropLabel" ).html("{{ trans('lang.eliminar')}} {{ trans('multi-leng.a287') }}: "+nombre);
        $( "#modalbody" ).html(`<form id="formadd" method="POST" action="{{ route('ingreso.foro.publico.blog') }}" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label for="namecat"><b>{{ trans('multi-leng.a287')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a289') }}" data-html="true"></i></label>
                <input type="text" class="form-control" id="namecat" name="namecat" aria-describedby="nameHelp" minlength="2" maxlength="50" size="50" value="${nombre}" placeholder="{{ __('multi-leng.a287') }}" required disabled>
                <small id="nameHelp" class="form-text text-danger" style="display:none;">{{ __('multi-leng.a289') }}</small>
            </div>
            <input type="hidden" name="type" name="type" value="del">
            <input type="hidden" id="idfor" name="idfor" value="${id}">
            <button type="submit" class="btn btn-danger">{{ trans('lang.eliminar')}}</button></form>
        `);

        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');

        $( "#staticBackdrop" ).modal('show');
    }

    function addcat()

    {
        var html = "";

        $( "#staticBackdropLabel" ).html("{{ trans('multi-leng.a288')}}");

        $( "#modalbody" ).html(`<form id="formadd" method="POST" action="{{ route('ingreso.foro.publico.blog') }}" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label for="namecat"><b>{{ trans('multi-leng.a287')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a289') }}" data-html="true"></i></label>
                <input type="text" class="form-control" id="namecat" name="namecat" aria-describedby="nameHelp" minlength="2" maxlength="50" size="50" placeholder="{{ __('multi-leng.a287') }}" required>
                <small id="nameHelp" class="form-text text-danger" style="display:none;">{{ __('multi-leng.a289') }}</small>
            </div>
            <input type="hidden" name="type" name="type" value="add">
            <button type="submit" class="btn btn-success">{{ trans('lang.enviar')}}</button></form>
        `);

        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');

        $( "#staticBackdrop" ).modal('show');

        

    }

    
    

    $('#staticBackdrop').on('show.bs.modal', function (event) {

        $(function () {

            $('[data-toggle="tooltip"]').tooltip()

        });

        $("#formadd").submit(function(e){

            $("#nameHelp").css("display", "none");

            var error = "";
            
            //var validate = validarnombre($.trim($("#namecat").val()).toUpperCase(), $("#selectcat").val());

            if($.trim($("#namecat").val()).length < 2)

            {

                error += "{{ __('multi-leng.formerror1') }}<br>";
                $("#nameHelp").html("{{ __('multi-leng.formerror1') }}");
                $("#nameHelp").css("display", "block");

            }

            if(error != "")

            {

                return false;

            }

            else

            {

                $("#namecat").val($.trim($("#namecat").val()));

                return true;

            }

        });
        $("#formedit").submit(function(e){

            $("#nameHelp").css("display", "none");

            var error = "";

            var validate = validarnombre($.trim($("#namecat").val()).toUpperCase(), $("#selectcat").val());

        if($.trim($("#namecat").val()).length < 2)

        {

            error += "{{ __('multi-leng.formerror1') }}<br>";
            $("#nameHelp").html("{{ __('multi-leng.formerror1') }}");
            $("#nameHelp").css("display", "block");

        }

        if($("#selectcat").val() == "")

        {

            error += "{{ __('multi-leng.formerror116') }}<br>";
            $("#nameHelp").html("{{ __('multi-leng.formerror116') }}");
            $("#selectHelp").css("display", "block");

        }

        if($("#status").val() == 0)

        {

            $("#nameHelp").html("{{ __('multi-leng.formerror3') }}");
            $("#nameHelp").css("display", "block");

        }

        if($("#status").val() == 2)

        {

            error += "{{ __('multi-leng.formerror3') }}<br>";
            $("#nameHelp").html("{{ __('multi-leng.formerror3') }}");
            $("#nameHelp").css("display", "block");

        }

        if(error != "")

        {

            return false;

        }

        else

        {

            $("#namecat").val($.trim($("#namecat").val()).toUpperCase());

            return true;

        }

        });

    });

    

    function searchus(idcar, tipo)
    {
        
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')     

            }

        });

        $.ajax({

            url: '{{route("ingreso.foro.publico.blog")}}',

            type: 'POST',

            async: false,

            dataType: 'json',

            data: {idcat: idcar, tipo: tipo},

            success: function(data) {

                if(data.tipo == 0)
                {
                    if(data.count == 0)
                    {
                        $( "#staticBackdropLabel" ).html("{{ __('multi-leng.formerror121') }}");

                        $( "#modalbody" ).html("<strong>{{ __('multi-leng.formerror122') }}</strong>");

                        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');

                        $( "#staticBackdrop" ).modal('show');
                    }
                    else
                    {
                        window.location.href = '{{ url("listado-usuarios-estado-ingreso-foro-publico-blog") }}/'+idcar+'/'+tipo;
                    }
                }
                if(data.tipo == 1)
                {
                    if(data.count == 0)
                    {
                        $( "#staticBackdropLabel" ).html("{{ __('multi-leng.formerror121') }}");

                        $( "#modalbody" ).html("<strong>{{ __('multi-leng.formerror123') }}</strong>");

                        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');

                        $( "#staticBackdrop" ).modal('show');
                        
                    }
                    else
                    {
                        window.location.href = '{{ url("listado-usuarios-estado-ingreso-foro-publico-blog") }}/'+idcar+'/'+tipo;
                    }
                }
                if(data.tipo == 2)
                {
                    if(data.count == 0)
                    {
                        $( "#staticBackdropLabel" ).html("{{ __('multi-leng.formerror121') }}");

                        $( "#modalbody" ).html("<strong>{{ __('multi-leng.formerror124') }}</strong>");

                        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');

                        $( "#staticBackdrop" ).modal('show');
                    }
                    else
                    {
                        window.location.href = '{{ url("listado-usuarios-estado-ingreso-foro-publico-blog") }}/'+idcar+'/'+tipo;
                    }
                }
                if(data.tipo == 3)
                {
                    if(data.count == 0)
                    {
                        $( "#staticBackdropLabel" ).html("{{ __('multi-leng.formerror121') }}");

                        $( "#modalbody" ).html("<strong>{{ __('multi-leng.formerror126') }}</strong>");

                        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');

                        $( "#staticBackdrop" ).modal('show');
                    }
                    else
                    {

                    }
                }

            },

            error:function(x,xs,xt){

                //console.log(JSON.stringify(x));

                console.log("error validarnombre");

            }

        });
        
    } 

    $('#staticBackdropforo').on('show.bs.modal', function (event) {

        $(function () {

            $('[data-toggle="tooltip"]').tooltip()

        });

        $("#formadd").submit(function(e){

            $("#nameHelp").css("display", "none");
            $("#selectHelp").css("display", "none");

            var error = "";
            
            var validate = validarnombre($.trim($("#namecat").val()).toUpperCase(), $("#selectcat").val());

            if($.trim($("#namecat").val()).length < 2)

            {

                error += "{{ __('multi-leng.formerror1') }}<br>";
                $("#nameHelp").html("{{ __('multi-leng.formerror1') }}");
                $("#nameHelp").css("display", "block");

            }

            if($("#selectcat").val() == "")

            {

                error += "{{ __('multi-leng.formerror116') }}<br>";
                $("#nameHelp").html("{{ __('multi-leng.formerror116') }}");
                $("#selectHelp").css("display", "block");

            }

            if($("#status").val() == 0)

            {

                $("#nameHelp").html("{{ __('multi-leng.formerror3') }}");
                $("#nameHelp").css("display", "block");

            }

            if($("#status").val() == 2)

            {

                error += "{{ __('multi-leng.formerror3') }}<br>";
                $("#nameHelp").html("{{ __('multi-leng.formerror3') }}");
                $("#nameHelp").css("display", "block");

            }

            if(error != "")

            {

                return false;

            }

            else

            {

                $("#namecat").val($.trim($("#namecat").val()).toUpperCase());

                return true;

            }

            

        });

        $('#dt-mant-table-modal').DataTable({

            //"dom": 'lfrtip'

            "dom": 'frtip', 

            fixedHeader: true,

            responsive: true,      

            "order": [[ 0, "asc" ]],

            "language": {

                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"

            }

        });
        
        $(".accionesmodal").on('click', function(event){
            $(this).data("idcar");
            $(this).data("tipo");
            $(this).data("idus");
            $(this).data("accion");
            //$( "#staticBackdropforo" ).modal('hide');
            $('#dt-mant-table-modal').DataTable().clear();
            $('#dt-mant-table-modal').DataTable().destroy();
            $('#tbodymodal').html("");
            searchus($(this).data("idcar"), $(this).data("tipo"));
            event.stopPropagation();
            event.stopImmediatePropagation();
            //(... rest of your JS code)
        });
        
        

    });

    function validarnombre(nombre, categoria)

    {

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')     

            }

        });

        $.ajax({

            url: '{{route("validar-nombre-categoria-forums")}}',

            type: 'POST',

            async: false,

            dataType: 'json',

            data: {name: nombre, selectcat: categoria},

            success: function(data) {

                $("#status").val(data.status);

            },

            error:function(x,xs,xt){

                //console.log(JSON.stringify(x));

                console.log("error validarnombre")

                $("#status").val(0);

            }

        });

    }

</script>

@endsection

