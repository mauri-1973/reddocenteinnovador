@extends('home')

@section('title')
{{ trans('multi-new.0291')}}
@endsection

@section('extra-css')

@endsection

@section('index')
<div class="content">
<!-- Vertical Layout -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-stats">
            <div class="">
                <h3>{{ trans('multi-new.0291')}}</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dt-mant-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>{{ trans('multi-new.0292')}}</th>
                                <!-- <th>Email</th> -->
                                <th>{{ trans('multi-new.0095')}}</th>
                                <!-- <th>Url</th> -->
                                <!-- <th>Method</th> -->
                                <th>IP</th>
                                <th>{{ trans('multi-new.0293')}}</th>
                                <th>{{ trans('multi-new.0294')}}</th>
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
<!-- #END# Vertical Layout -->

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
                ajax: "{{ route('login-activities') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'subject', name: 'subject' },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'ip', name: 'ip' },
                    { data: 'agent', name: 'agent' }, 
                    { data: 'fecha', name: 'fecha', render: function ( data, type, row ) 
                        {
                            
                            return `${row.fecha}<br>${row.fecha1}`;
                        } 
                    },
                ],
                columnDefs: [
                    {
                        targets: 0,         // El índice de la columna que quieres ocultar. Empieza en 0.
                        visible: false,     // Oculta la columna
                        searchable: false   // Opcional: para que no se busque en esa columna
                    }
                ],
                
                responsive: true,      

                "order": [[ 0, "desc" ]],

                "language": {

                    "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"

                }
        });       
    });
    
</script>
@endsection