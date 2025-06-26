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

                </div>
                <div class="card-body">
                            
                    <table id="dt-mant-table" class="table table-bordered display responsive nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th>{{ trans('multi-leng.formerror29')}}</th>
                            <th>{{ trans('multi-leng.a33')}}</th>
                            <th># {{ trans('inst.178')}}</th>
                            <th>{{ trans('multi-leng.formerror22')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($array as $po => $sli)
                            <tr>
                                <th scope="col">
                                    
                                    {{ $array[$po]['title'] }}
                                
                                </th>
                                <td>
                                    @if($array[$po]['status'] == "activo")
                                        {{ trans('inst.180')}}
                                    @endif
                                    @if($array[$po]['status'] == "seleccionados")
                                        {{ trans('inst.181')}}
                                    @endif
                                </td>
                                
                                <td scope="col">

                                {{ $array[$po]['post'] }}
                                    
                                </td>
                                <td>
                                    @if($array[$po]['post'] > 0)
                                    <a class="btn btn-primary btn-sm btn-block" href="{{ route('ver.postulaciones.concurso.coordinador', Crypt::encrypt( $array[$po]['id'] ) ) }}" role="button">{{ trans('inst.182')}}</a>
                                    @else
                                        {{ trans('inst.183')}}
                                    @endif
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
            "order": [[ 0, "desc" ]],
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
    });
    
</script>
@endsection