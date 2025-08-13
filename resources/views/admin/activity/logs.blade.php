@extends('home')

@section('title')
 Login Activities
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
                <h3>User Login Activities</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dt-mant-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Ingreso</th>
                                <!-- <th>Email</th> -->
                                <th>Nombre</th>
                                <!-- <th>Url</th> -->
                                <!-- <th>Method</th> -->
                                <th>IP</th>
                                <th>Dispositivo</th>
                                <th>Fecha de Ingreso</th>
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
                
                responsive: true,      

                "order": [[ 0, "asc" ]],

                "language": {

                    "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"

                }
        });       
    });
    
</script>
@endsection