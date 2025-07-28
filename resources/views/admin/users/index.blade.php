@extends('home')

@section('title')
{{ Auth::user()->name }}
@endsection

@section('extra-css')

@endsection

@section('index')
<div class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="">
                    <h3>{{ trans('multi-leng.userdetal')}} ({{ trans('multi-leng.multi1')}})</h3>

                    <a href="{{ route('mostrar-formulario-tipo-usuario', ['tipo' => 'administradores']) }}" class="btn btn-success btn-sm">{{ trans('multi-leng.addnewuser')}}</a>
                    
                </div>
                <div class="card-body">
                    <table id="dt-mant-table" class="table table-bordered display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ trans("multi-leng.nomuser")}}</th>

                                <th>{{ trans("multi-leng.suruser")}}</th>

                                <th>Email</th>

                                <th>{{ trans("multi-leng.a270")}}</th>

                                <th>{{ trans("multi-leng.a271")}}</th>

                                <th>Avatar</th>

                                <th>{{ trans("multi-leng.formerror22")}}</th>
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
@endsection

@section('extra-script')
<script type="text/javascript">
    
    $(document).ready(function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $('#dt-mant-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'frtip', 
                fixedHeader: true,
                ajax: "{{ route('agregar-usuarios-administradores') }}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'surname', name: 'surname' },
                    { data: 'email', name: 'email' },
                    { data: 'mobile', name: 'mobile' },
                    { data: 'cargo_us', name: 'cargo_us' }, 
                    { data: 'avatar', render: function ( data, type, row ) 
                        {
                            
                            return `<img 
                            style="width:100px;height:auto;" 
                            id="logouser${row.id}" 
                            src="{{asset('storage/profile-pic')}}/${row.avatar}" 
                            alt="${row.name}" 
                            class="avatar border-gray"
                            onerror="this.onerror=null;this.src='{{ asset('storage/profile-pic/sinregistro.png') }}'" 
                        />`;
                        } 
                    },
                    { data: 'id', name: '{{ trans("multi-leng.formerror22")}}', render: function ( data, type, row ) {
                            var val = '';
                            if(parseInt(row.id) ==! parseInt( row.userid ) )
                            {
                                
                                val = `<button class="btn btn-danger btn-sm btn-block mb-1" type="submit">{{ trans('lang.eliminar')}}</button>`;
                            }
                        
                            return `

                                <a href="{{url('') }}/users/`+row.id+`/edit" class="btn btn-warning btn-sm btn-block mb-1">{{ trans('lang.editar') }}</a>

                                <form id="delete_form${row.id}" method="POST" action="{{ route('users.destroy', Crypt::encrypt(1) ) }}" onclick="return confirm('{{ trans("multi-leng.areyousur")}}')">

                                @csrf

                                    <input name="_method" type="hidden" value="DELETE">

                                    <input name="tipo" type="hidden" value="adm">
                                    
                                    <input name="idencript" type="hidden" value="`+row.encrypted_id+`">
                                    
                                ${val}
                                </form>`;
                        } 
                    }
                ],
                columnDefs : [
                                {
                                    "targets": [ 6 ],
                                    "visible": true,
                                    "searchable": false
                                },
                ],
                
                responsive: true,      

                "order": [[ 0, "asc" ]],

                "language": {

                    "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"

                }
        });       
    });
    
</script>
@endsection
