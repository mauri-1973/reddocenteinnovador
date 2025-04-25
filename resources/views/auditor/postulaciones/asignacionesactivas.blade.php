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
                    <h3>Nombre Concurso: <strong>{{ $nombrecom }}</strong></h3>
                    @if(Auth::user()->hasRole('auditor')  )
                    <a href="{{ route('buscar-concursos-seleccionados-auditor') }}" class="btn btn-success btn-sm">{{ trans('lang.volver')}}</a>
                    @endif
                </div>

                

                @if($idaudit == "sinasignaciones")
                <div class="card-body text-center">
                    <h2><strong>No registra asignaciones activas para este concurso.</strong></h2>
                @else
                <div class="card-body">
                    <table id="dt-mant-table" class="table table-bordered display responsive nowrap" style="width:100%">

                        <thead>

                            <tr>

                                <th>Nombre Postulante</th>

                                <th>Nombre Proyecto</th>

                                <th>Fecha Inicio Acta</th>

                                <th>Fecha Cierre Acta</th>

                                <th>{{ trans("multi-leng.formerror22")}}</th>

                            </tr>

                        </thead>

                        <tbody>
                        
                        @foreach($array1 as $row => $sli)

                            <tr>
                            
                                <td>{{ $array1[$row]['nombre'] }}</td>

                                <td>{{ $array1[$row]['titproy'] }}</td>

                                <td>{{ $array1[$row]['fecha_ini'] }}</td>

                                <td>{{ $array1[$row]['fecha_ter'] }}</td>

                                <td>

                                    <div style="display:flex;">

                                    <a href="{{url('ver-formulario-docente-concurso-finalizado-actas', $array1[$row]['idansw']) }}" class="btn btn-success btn-sm btn-block">Ver Actas</a>

                                    </div>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>
                @endif
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

