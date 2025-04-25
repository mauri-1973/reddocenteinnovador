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

                    <h3>Concursos con postulaciones seleccionadas</h3>

                </div>

                <div class="card-body">

                    <table id="dt-mant-table" class="table table-bordered display responsive nowrap" style="width:100%">

                        <thead>

                            <tr>

                                <th>{{ trans("multi-new.0048")}}</th>

                                <th>{{ trans("multi-new.0049")}}</th>

                                <th>{{ trans("multi-new.0050")}}</th>

                                <th>{{ trans("multi-new.0051")}}</th>

                                <th>{{ trans("multi-leng.formerror22")}}</th>

                            </tr>

                        </thead>

                        <tbody>
                            @foreach($array1 as $row)

                            <tr>
                           
                                <td>{{ $row->title }}</td>

                                <td>{{ $row->namecat }}</td>

                                <td>{{ $row->name.' '.$row->surname }}</td>

                                <td>{{ date('d-m-Y H:i:s', strtotime($row->created_at)) }}</td>

                                <td>

                                    <div style="display:flex;">

                                    <a href="{{url('ver-asignaciones-auditor-id-postulacion', Crypt::encrypt($row->idcomp) ) }}" class="btn btn-success btn-sm btn-block">Ver Asignaciones</a>

                                    </div>

                                </td>

                            </tr>

                            @endforeach
                            

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

<input type="hidden" id="status" name="status">

@endsection



@section('extra-script')

<script type="text/javascript">

    

    $(document).ready(function() {

        $(function () {

            $('[data-toggle="tooltip"]').tooltip()

        });

        $('#dt-mant-table').DataTable({

            //"dom": 'lfrtip'

            "dom": 'frtip', 

            fixedHeader: true,

            responsive: true,      

            "order": [[ 0, "asc" ]],

            "language": {

                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"

            }

        });

    });

    

</script>

@endsection

