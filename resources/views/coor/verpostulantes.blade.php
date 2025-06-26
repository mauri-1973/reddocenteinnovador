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
                    @role('coordinador')
                    <a href="{{ route('ver.asignaciones.activas.coordinador') }}" class="btn btn-success btn-sm">
                        {{ trans('lang.volver')}}
                    </a>
                @endrole
                </div>
                <div class="card-body">
                            
                    <table id="dt-mant-table" class="table table-bordered display responsive nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th>{{ trans('inst.184')}}</th>
                            <th>{{ trans('inst.185')}}</th>
                            <th># {{ trans('inst.186')}}</th>
                            <th>{{ trans('multi-leng.formerror22')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($post as $po => $sli)
                            <tr>
                                <th scope="col">
                                    
                                    {{ $post[$po]['nameus'] . '' .  $post[$po]['surnameus'] }}
                                
                                </th>
                                <td>
                                    @if($post[$po]['status'] == "conobservaciones")
                                        {{ trans('inst.188')}}
                                    @endif
                                    @if($post[$po]['status'] == "inicial")
                                        {{ trans('inst.189')}}
                                    @endif
                                    @if($post[$po]['status'] == "seleccionado")
                                        {{ trans('inst.190')}}
                                    @endif
                                    @if($post[$po]['status'] == "enrevision")
                                        {{ trans('inst.191')}}
                                    @endif
                                    @if($post[$po]['status'] == "rechazado")
                                        {{ trans('inst.192')}}
                                    @endif
                                    @if($post[$po]['status'] == "revisada")
                                        {{ trans('inst.193')}}
                                    @endif
                                </td>
                                
                                <td scope="col">

                                    {{ date("d-m-Y", strtotime($post[$po]['created_at'])) }}
                                    
                                </td>
                                <td>
                                    
                                    <a class="btn btn-success btn-sm btn-block" href="{{ route('detalle.postulacion.docente.coordinador',['idpost' => $post[$po]['idpost'], 'idconc' => Crypt::encrypt( $post[$po]['idconc'] ) ]  ) }}" role="button">{{ trans('inst.182')}}</a>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div class="">
                    @role('coordinador')
                    <a href="{{ route('ver.asignaciones.activas.coordinador') }}" class="btn btn-success btn-sm">
                        {{ trans('lang.volver')}}
                    </a>
                @endrole
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
            "order": [[ 0, "desc" ]],
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
    });
    
</script>
@endsection