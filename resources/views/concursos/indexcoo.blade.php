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
                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('revisor'))
                    <h3>{{ trans('multi-leng.a2')}}</h3>
                    @if(count($categories) == 0)
                    <h5 style="color:red;">{{ trans('multi-leng.a18')}}</h5><a class="btn btn-primary" href="{{url('')}}/agregar-nuevas-categorias-concursos" role="button">{{ trans('multi-leng.formerror224')}}</a>
                    @else
                    <a href="{{ route('agregar-nuevo-concurso-administrador', $formulario) }}" class="btn btn-success btn-sm">{{ trans('multi-leng.a4')}}</a>
                    @endif
                @endif
                </div>
                <div class="card-body">
                            
                    <table id="dt-mant-table" class="table table-bordered display responsive nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('multi-leng.formerror29')}}</th>
                            <th>{{ trans('multi-leng.formerror28')}}</th>
                            <th>{{ trans('multi-leng.a33')}}</th>
                            <th>Bases</th>
                            <th>{{ trans('multi-leng.formerror26')}}</th>
                            <th>{{ trans('multi-leng.formerror25')}}</th>
                            <th>{{ trans('multi-leng.a16')}}</th>
                            <th>{{ trans('multi-leng.a17')}}</th>
                            
                            <th>{{ trans('multi-leng.formerror22')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>&nbsp;# {{ $post->idcomp }}</td>
                                <td>
                                    &nbsp;
                                    @if($post->title == "" || $post->title == null)
                                        Sin Título
                                    @else
                                        {{ $post->title }}
                                    @endif
                                    
                                </td>
                                <td>
                                    &nbsp;
                                    @if($post->applicants == "" || $post->applicants == null)
                                        0
                                    @else
                                        {{ (int)$post->applicants }}
                                    @endif
                                    
                                </td>
                                <td class="text-center">
                                    &nbsp;
                                    @if( strtotime(date('d-m-Y H:i:s', strtotime($post->date_on))) <= strtotime( date('d-m-Y H:i:s') ) &&  strtotime(date('d-m-Y H:i:s', strtotime($post->date_off))) >= strtotime( date('d-m-Y H:i:s') ))
                                        Postulaciones Abiertas
                                    @else
                                        Postulaciones Cerradas
                                    @endif
                                    
                                </td>
                                <td>
                                    &nbsp;
                                    @if($post->namecat == "" || $post->namecat  == null)
                                        Sin Categoría
                                    @else
                                        {{ $post->namecat }}
                                    @endif
                                </td>
                                <td>
                                    &nbsp;
                                    @if($post->body == "" || $post->body  == null)
                                        Sin Contenido
                                    @else
                                        {{ Str::limit(strip_tags($post->body), 40) }}
                                    @endif
                                    
                                </td>
                                <td>
                                    &nbsp;
                                    {{ optional($post)->nameus.' '.optional($post)->surnameus }}
                                </td>
                                <td>
                                    &nbsp;
                                    @if($post->date_on == "" || $post->date_on  == null)
                                        Sin Definir
                                    @else
                                        {{  date('d-m-Y', strtotime($post->date_on)) }}
                                    @endif
                                </td>
                                <td>
                                    &nbsp;
                                    @if($post->date_off == "" || $post->date_off  == null)
                                        Sin Definir
                                    @else
                                        {{  date('d-m-Y', strtotime($post->date_off)) }}
                                    @endif
                                </td>
                                
                                <td>
                                    <a href="{{ route('ver.vista.concurso.usuarios.coordinadores', Crypt::encrypt($post->idcomp) ) }}" class="btn btn-success btn-sm btn-block mb-1">
                                    {{ trans('lang.perver')}}
                                    </a>
                                    
                                </td>
                            </tr>
                        @empty
                            
                        @endforelse
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
            "order": [[ 2, "desc" ]],
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
    });
    
</script>
@endsection