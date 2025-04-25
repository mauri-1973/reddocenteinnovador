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
    .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
        background-color:red;
    }
    
</style>
@endsection


@section('index')
<div class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="">
                <h3>{{ trans('multi-leng.a211')}}</h3>
                @if(Auth::user()->hasRole('revisor')  )
                <a href="{{ route('buscar-concursos-registrados-revisor') }}" class="btn btn-success btn-sm">{{ trans('lang.volver')}}</a>
                @endif
                @if(Auth::user()->hasRole('admin'))
                    
                    <a href="{{ route('buscar-concursos-registrados-administradores') }}" class="btn btn-success btn-sm">{{ trans('lang.volver')}}</a>
                    @if($statusconc == 'activo')
                        <button class="btn btn-primary btn-sm" onclick="finalizarconc('{{ $idconc }}')">{{ trans('multi-new.0012')}}</button>
                    @else
                        <button class="btn btn-primary btn-sm" onclick="finalizarconc('{{ $idconc }}')" disabled>{{ trans('multi-new.0012')}}</button>
                    @endif   
                @endif
                </div>
                <div class="card-body">
                            
                    <table id="dt-mant-table" class="table table-bordered display responsive nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            @if($statusconc == 'activo')
                            <th scope="col">{{ trans('multi-new.0013')}}</th>
                            @endif
                            <th scope="col">{{ trans('multi-leng.a208')}}</th>
                            <th scope="col">{{ trans('multi-new.0014')}}</th>
                            <th>Bases</th>
                            <th>{{ trans('multi-leng.a209')}}</th>
                            <th>{{ trans('multi-leng.a210')}}</th>
                            <th>{{ trans('multi-leng.a211')}}</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($array1 as $arr)
                            @if($arr['status'] != 'seleccionado')
                            <tr>
                                <th scope="row">
                                    &nbsp;
                                </th>
                                @if($statusconc == 'activo')     
                                <th scope="row" class="text-center">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input customCheckBox" name="customCheckBox" id="customCheckBox{{$arr['idpost']}}" value="{{$arr['idpost']}}">
                                        <label class="custom-control-label" for="customCheckBox{{$arr['idpost']}}">&nbsp;</label>
                                    </div>
                                </th>
                                @endif
                                <th scope="row">
                                    {{ $arr['titlecat']}}
                                </th>
                                <th scope="row" class="text-center">
                                    {{ $arr['puntajemax']}}
                                </th>
                                <td >
                                    {{ $arr['namecat']}}
                                </td>
                                <th scope="row">
                                    {{ $arr['user']}}
                                </th>
                                <td >
                                    @if($arr['status'] == 'inicial')
                                        {{ trans('multi-leng.a40') }}
                                    @endif
                                    @if($arr['status'] == 'enrevision')
                                        {{ trans('multi-new.0015')}}
                                    @endif
                                    @if($arr['status'] == 'rechazado')
                                        {{ trans('multi-new.0016')}}
                                    @endif
                                    @if($arr['status'] == 'aprobado')
                                        {{ trans('multi-new.0017')}}
                                    @endif
                                    @if($arr['status'] == 'conobservaciones')
                                    {{ trans('multi-new.0018')}}
                                    @endif
                                </td>
                                <td>
                                    @foreach($arr['answ'] as $an => $slice)
                                    
                                    @if($an == 0 && $arr['status'] == 'inicial')
                                    <a href="{{ route('ver-informacion-ingresada-docente', ['tipo' => 'inicial', 'idpost' => $arr['idpost'], 'idansw' => Crypt::encrypt($arr['answ'][$an]['idansw'])]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-new.0019')}}</a>
                                    @endif
                                    @if($an == 0 && $arr['status'] == 'rechazado')
                                    <a href="{{ route('ver-informacion-ingresada-docente', ['tipo' => 'rechazado', 'idpost' => $arr['idpost'], 'idansw' => Crypt::encrypt($arr['answ'][$an]['idansw'])]) }}" class="btn btn-success btn-sm btn-block">{{ trans('multi-new.0020')}}</a>
                                    @endif
                                    @if($an == 0 && $arr['status'] == 'aprobado')
                                    <a href="{{ route('ver-informacion-ingresada-docente', ['tipo' => 'aprobado', 'idpost' => $arr['idpost'], 'idansw' => Crypt::encrypt($arr['answ'][$an]['idansw'])]) }}" class="btn btn-success btn-sm btn-block">{{ trans('multi-new.0020')}}</a>
                                    @endif
                                    @if($an == 0 && $arr['status'] == 'conobservaciones')
                                    <a href="{{ route('ver-informacion-ingresada-docente', ['tipo' => 'conobservaciones', 'idpost' => $arr['idpost'], 'idansw' => Crypt::encrypt($arr['answ'][$an]['idansw'])]) }}" class="btn btn-success btn-sm btn-block">{{ trans('multi-new.0019')}}</a>
                                    @endif
                                    @if($an > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Link
                                                    </th>
                                                    <th>
                                                        {{ trans('multi-new.0021')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('ver-informacion-ingresada-docente', ['tipo' => 'historial', 'idpost' => $arr['idpost'], 'idansw' => Crypt::encrypt($arr['answ'][$an]['idansw'])]) }}" class="btn btn-warning btn-sm btn-block mt-1">{{ trans('multi-new.0022')}}</a>
                                                    </td>
                                                    <td>
                                                    {{ $arr['answ'][$an]['puntaje'] }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </diV>
                                    @endif

                                    @endforeach
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        
                        </tbody>
                    </table>
                </div>
               
                @if(Auth::user()->hasRole('admin'))
                <div class="card-body">
                    <h3>{{ trans('multi-new.0023')}}</h3>
                    @if($statusconc == 'seleccionados')
                        <button class="btn btn-primary btn-sm" onclick="notificaciones('{{ $idconc }}', '{{ Crypt::encrypt(0) }}', 'general')">{{ trans('multi-new.0033')}}</button>
                    @endif
                    
                    <table id="dt-mant-table-sel-not" class="table table-bordered display responsive nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">{{ trans('multi-new.0035')}}</th>
                            <th scope="col">{{ trans('multi-new.0037')}}</th>
                            <th>{{ trans('multi-new.0036')}}</th>
                        </tr>
                        </thead>
                        <tbody id="bodynot">
                        @if($not->count() > 0)
                            @foreach($not as $n)
                            <tr>
                                <th scope="row" class="text-left">
                                    {{ $n->mensaje }}
                                </th>
                                <th scope="row" class="text-center">
                                    {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $n->created_at)->format('d-m-Y H:i:s') }}
                                </th>
                                <th scope="row">
                                <button class="btn btn-success btn-sm btn-block mb-1" onclick="notificaciones('{{ Crypt::encrypt($n->id_con.'-'.$n->id) }}', '{{ $n->mensaje }}', 'editar')">Editar</button>
                                <button class="btn btn-danger btn-sm btn-block" onclick="notificaciones('{{ Crypt::encrypt($n->id_con.'-'.$n->id) }}', '{{ $n->mensaje }}', 'eliminar')">Eliminar</button>
                                </th>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-body">     
                    <table id="dt-mant-table-sel" class="table table-bordered display responsive nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            @if($statusconc == 'activo')
                            <th scope="col">{{ trans('multi-new.0024')}}</th>
                            @endif
                            <th scope="col">{{ trans('multi-leng.a208')}}</th>
                            <th scope="col">{{ trans('multi-new.0014')}}</th>
                            <th>Bases</th>
                            <th>{{ trans('multi-leng.a209')}}</th>
                            <th>{{ trans('multi-leng.a210')}}</th>
                            <th>{{ trans('multi-leng.a211')}}</th>
                            <th>{{ trans('multi-new.0001')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($array1 as $arr)
                            @if($arr['status'] == 'seleccionado')
                            <tr>
                                <th scope="row">
                                    &nbsp;
                                </th> 
                                @if($statusconc == 'activo')   
                                <th scope="row" class="text-center">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input customCheckBox" name="customCheckBox"  id="customCheckBox{{$arr['idpost']}}" value="{{$arr['idpost']}}" checked>
                                        <label class="custom-control-label" for="customCheckBox{{$arr['idpost']}}">&nbsp;</label>
                                    </div>
                                </th>
                                @endif
                                <th scope="row">
                                    {{ $arr['titlecat']}}
                                </th>
                                <th scope="row" class="text-center">
                                    {{ $arr['puntajemax']}}
                                </th>
                                <td >
                                    {{ $arr['namecat']}}
                                </td>
                                <th scope="row">
                                    {{ $arr['user']}}
                                </th>
                                <td >
                                    @if($arr['status'] == 'seleccionado')
                                        {{ trans('multi-new.0032')}}
                                    @endif
                                </td>
                                <td>
                                    @foreach($arr['answ'] as $an => $slice)
                                    
                                    @if($an == 0 && $arr['status'] == 'inicial')
                                    <a href="{{ route('ver-informacion-ingresada-docente', ['tipo' => 'inicial', 'idpost' => $arr['idpost'], 'idansw' => Crypt::encrypt($arr['answ'][$an]['idansw'])]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-new.0019')}}</a>
                                    @endif
                                    @if($an == 0 && $arr['status'] == 'rechazado')
                                    <a href="{{ route('ver-informacion-ingresada-docente', ['tipo' => 'rechazado', 'idpost' => $arr['idpost'], 'idansw' => Crypt::encrypt($arr['answ'][$an]['idansw'])]) }}" class="btn btn-success btn-sm btn-block">{{ trans('multi-new.0020')}}</a>
                                    @endif
                                    @if($an == 0 && $arr['status'] == 'aprobado')
                                    <a href="{{ route('ver-informacion-ingresada-docente', ['tipo' => 'aprobado', 'idpost' => $arr['idpost'], 'idansw' => Crypt::encrypt($arr['answ'][$an]['idansw'])]) }}" class="btn btn-success btn-sm btn-block">{{ trans('multi-new.0020')}}</a>
                                    @endif
                                    @if($an == 0 && $arr['status'] == 'conobservaciones')
                                    <a href="{{ route('ver-informacion-ingresada-docente', ['tipo' => 'conobservaciones', 'idpost' => $arr['idpost'], 'idansw' => Crypt::encrypt($arr['answ'][$an]['idansw'])]) }}" class="btn btn-success btn-sm btn-block">{{ trans('multi-new.0019')}} </a>
                                    @endif
                                    @if($an > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Link
                                                    </th>
                                                    <th>
                                                        {{ trans('multi-new.0021')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('ver-informacion-ingresada-docente', ['tipo' => 'historial', 'idpost' => $arr['idpost'], 'idansw' => Crypt::encrypt($arr['answ'][$an]['idansw'])]) }}" class="btn btn-success btn-sm btn-block mt-1">{{ trans('multi-new.0025')}}</a>
                                                    </td>
                                                    <td>
                                                    {{ $arr['answ'][$an]['puntaje'] }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </diV>
                                    @endif

                                    @endforeach
                                </td>
                                <td>
                                    
                                    
                                    @if($useraudit->count() == 0)

                                        Debe asignar auditores

                                    @else
                                        
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Nombre
                                                        </th>
                                                        <th>
                                                            Asignado
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($arr['auditores'] as $an => $slice)
                                                    <tr>
                                                        <td style="width:40%;">
                                                            {{ $arr['auditores'][$an]['nombre'] }}
                                                        </td>
                                                        <td>
                                                            <div class="container">
                                                                @if($arr['idpost'] == $arr['auditores'][$an]['idpost'] && $arr['auditores'][$an]['seleccionado'] == 'ninguno')
                                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                    <label class="btn btn-outline-primary btn-sm custom-control custom-radio pl-5">
                                                                        <input type="radio" name="options{{ $an }}" id="option1{{ $an }}"  class="custom-control-input" onchange="handleClick('{{ Crypt::encrypt($arr['auditores'][$an]['iduser']) }}', '{{ Crypt::encrypt($arr['auditores'][$an]['idpost']) }}', 'si');">
                                                                        <span class="custom-control-label pt-1">Sí</span>
                                                                    </label>
                                                                    <label class="btn btn-outline-primary btn-sm custom-control custom-radio pl-5">
                                                                        <input type="radio" name="options{{ $an }}" id="option2{{ $an }}" class="custom-control-input" onchange="handleClick('{{ Crypt::encrypt($arr['auditores'][$an]['iduser']) }}', '{{ Crypt::encrypt($arr['auditores'][$an]['idpost']) }}', 'no');">
                                                                        <span class="custom-control-label pt-1">No</span>
                                                                    </label>
                                                                </div>
                                                                @endif
                                                                @if($arr['idpost'] == $arr['auditores'][$an]['idpost'] && $arr['auditores'][$an]['seleccionado'] == 'si')
                                                                    @if($arr['auditores'][$an]['statusaudit'] == "si")
                                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                        <label class="btn btn-outline-primary btn-sm active custom-control custom-radio pl-5">
                                                                            <input type="radio" name="options{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}" id="option1{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}"  class="custom-control-input" onchange="handleClick('{{ Crypt::encrypt($arr['auditores'][$an]['iduser']) }}', '{{ Crypt::encrypt($arr['auditores'][$an]['idpost']) }}', 'si');" checked>
                                                                            <span class="custom-control-label pt-1">Sí</span>
                                                                        </label>
                                                                        <label class="btn btn-outline-primary btn-sm custom-control custom-radio pl-5">
                                                                            <input type="radio" name="options{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}" id="option2{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}" class="custom-control-input" onchange="handleClick('{{ Crypt::encrypt($arr['auditores'][$an]['iduser']) }}', '{{ Crypt::encrypt($arr['auditores'][$an]['idpost']) }}', 'no');">
                                                                            <span class="custom-control-label pt-1">No</span>
                                                                        </label>
                                                                    </div>
                                                                    @else
                                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                        <label class="btn btn-outline-primary btn-sm custom-control custom-radio pl-5">
                                                                            <input type="radio" name="options{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}" id="option1{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}"  class="custom-control-input" onchange="handleClick('{{ Crypt::encrypt($arr['auditores'][$an]['iduser']) }}', '{{ Crypt::encrypt($arr['auditores'][$an]['idpost']) }}', 'si');">
                                                                            <span class="custom-control-label pt-1">Sí</span>
                                                                        </label>
                                                                        <label class="btn btn-outline-primary btn-sm active custom-control custom-radio pl-5">
                                                                            <input type="radio" name="options{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}" id="option2{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}" class="custom-control-input" onchange="handleClick('{{ Crypt::encrypt($arr['auditores'][$an]['iduser']) }}', '{{ Crypt::encrypt($arr['auditores'][$an]['idpost']) }}', 'no');" checked>
                                                                            <span class="custom-control-label pt-1">No</span>
                                                                        </label>
                                                                    </div>
                                                                    @endif
                                                                @endif
                                                                @if($arr['idpost'] == $arr['auditores'][$an]['idpost'] && $arr['auditores'][$an]['seleccionado'] == 'no')
                                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                    <label class="btn btn-outline-primary btn-sm custom-control custom-radio pl-5">
                                                                        <input type="radio" name="options{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}" id="option1{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}"  class="custom-control-input" onchange="handleClick('{{ Crypt::encrypt($arr['auditores'][$an]['iduser']) }}', '{{ Crypt::encrypt($arr['auditores'][$an]['idpost']) }}', 'si');">
                                                                        <span class="custom-control-label pt-1">Sí</span>
                                                                    </label>
                                                                    <label class="btn btn-outline-primary btn-sm active custom-control custom-radio pl-5">
                                                                        <input type="radio" name="options{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}" id="option2{{ $arr['auditores'][$an]['iduser'].$arr['auditores'][$an]['idpost'] }}" class="custom-control-input" onchange="handleClick('{{ Crypt::encrypt($arr['auditores'][$an]['iduser']) }}', '{{ Crypt::encrypt($arr['auditores'][$an]['idpost']) }}', 'no');" checked>
                                                                        <span class="custom-control-label pt-1">No</span>
                                                                    </label>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </diV>
                                        
                                    @endif

                                    
                                </td>
                            </tr>
                            @endif
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
<div class="modal fade" id="staticBackdropgen" aria-labelledby="staticBackdropLabelgen" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabelgen">{{ trans('multi-new.0026')}}</h5>
        
      </div>
      <div class="modal-body" id="modalbodygen">
         
      </div>
      <div class="modal-footer" id="footerbodygen">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('multi-new.0027')}}</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="staticBackdropnot" aria-labelledby="staticBackdropLabelnot" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabelnot">{{ trans('multi-new.0026')}}</h5>
        
      </div>
      <div class="modal-body" id="modalbodynot">
         
      </div>
      <div class="modal-footer" id="footerbodynot">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('multi-new.0027')}}</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">{{ trans('multi-new.0026')}}</h5>
        
      </div>
      <div class="modal-body" id="modalbody">
         
      </div>
      <div class="modal-footer" id="footerbody">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('multi-new.0027')}}</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="staticBackdroperror" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelerror" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabelerror">{{ trans('multi-new.0028')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalbodyerror">
         <p>{{ trans('multi-new.0029')}}</p>
      </div>
      <div class="modal-footer" id="footerbodyerror">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('multi-new.0027')}}</button>
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
        const table = $('#dt-mant-table').DataTable({
            //"dom": 'lfrtip'
            "dom": 'frtip', 
            "pageLength": 20,
            fixedHeader: true,
            responsive: true, 
            @if(Auth::user()->hasRole('admin') && $statusconc == 'activo')     
            "order": [[ 3, "desc" ]],
            @else
            "order": [[ 2, "desc" ]],
            @endif
            @if(Auth::user()->hasRole('revisor'))     
            "order": [[ 2, "desc" ]],
            @endif
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }, 
        });
        table.on('order.dt search.dt', function () {
        let i = 1;
 
        table
            .cells(null, 0, { search: 'applied', order: 'applied' })
            .every(function (cell) {
                this.data(i++);
            });
        })
        .draw();
        const tablesel = $('#dt-mant-table-sel').DataTable({
            //"dom": 'lfrtip'
            "dom": 'frtip', 
            "pageLength": 20,
            fixedHeader: true,
            responsive: true, 
                @if(Auth::user()->hasRole('admin') && $statusconc == 'activo')     
                "order": [[ 3, "desc" ]],
                @else
                "order": [[ 2, "desc" ]],
                @endif
                @if(Auth::user()->hasRole('revisor'))     
                "order": [[ 2, "desc" ]],
                @endif 
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }, 
        });
        tablesel.on('order.dt search.dt', function () {
        let i = 1;
 
        tablesel
            .cells(null, 0, { search: 'applied', order: 'applied' })
            .every(function (cell) {
                this.data(i++);
            });
        })
        .draw();
        const tableselnot = $('#dt-mant-table-sel-not').DataTable({
            //"dom": 'lfrtip'
            "dom": 'frtip', 
            "pageLength": 10,
            fixedHeader: true,
            responsive: true, 
            "order": [[ 1, "desc" ]],    
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }, 
        });
    });

    $('input[type=checkbox]').change(function () {
        if(this.checked) {
            actualizardatos(this.value, 'seleccionado');
        }
        else
        {
            actualizardatos(this.value, 'noseleccionado');
        }
    });
    function actualizardatos(id, status)
    {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = new FormData();
        formData.append("id", id);
        formData.append("status", status);
        $.ajax({
            type: "POST",
            url: '{{route("actualizar.formulario.postulacion.seleccionados.fase.dos")}}',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(respu)
            {
              if(respu.status == "ok" && status == "seleccionado")
              {
                
                $('#modalbody').html('<p>{{ trans("multi-new.0030")}}</p>');
                $('#staticBackdrop').modal('show');
                
              }
              else if(respu.status == "ok" && status == "noseleccionado")
              {
                
                $('#modalbody').html('<p>{{ trans("multi-new.0031")}}</p>');
                $('#staticBackdrop').modal('show');
                
              }
              else if(respu.status == "ok" && status == "concurso")
              {
                
                $('#modalbody').html('<p>{{ trans("multi-new.0031")}}</p>');
                $('#staticBackdrop').modal('show');
                
              }
              else if(respu.status == "error" && status == "concurso")
              {
                
                $('#modalbody').html('<p>Este concurso, ya se encuentra cerrado, para seleccionar postulaciones</p>');
                $('#staticBackdrop').modal('show');
                
              }
              else if(respu.status == "error1")
              {
                
                $('#modalbody').html(`<p>${respu.mensaje}</p>`);
                $('#staticBackdrop').modal('show');
                
              }
              else
              {
                $('#staticBackdroperror').modal('show');
              }
              
              
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $('#staticBackdroperror').modal('show');
            }
        });
    }
    var myModalEl = document.getElementById('staticBackdrop');
    $('#staticBackdrop').on('hidden.bs.modal', function (e) {
        console.log('staticBackdrop');
        location.reload(true);
    });
    function finalizarconc(id)
    {
        var checked = $(":checkbox").filter(':checked').length;
        console.log('checked', checked);
        switch (true) 
        {
            case (checked == 0):
                   
                $('#staticBackdropLabelerror').html('Estimado Administrador');
                $('#modalbodyerror').html('<p>Este concurso será finalizado, sin postulaciones seleccionadas, Está seguro de continuar?.</p>');
                $('#footerbodyerror').html(`<button type="button" class="btn btn-danger" onclick="continuar('${id}')">Continuar</button><button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('multi-new.0027')}}</button>`);
                $('#staticBackdroperror').modal('show');

            break; 
        
            default:
                $('#staticBackdropLabelerror').html('Estimado Administrador');
                $('#modalbodyerror').html('<p>Este concurso será finalizado, con '+checked+' postulaciones seleccionadas, Está seguro de continuar?.</p>');
                $('#footerbodyerror').html(`<button type="button" class="btn btn-danger" onclick="continuar('${id}')">Continuar</button><button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('multi-new.0027')}}</button>`);
                $('#staticBackdroperror').modal('show');
                
            break;
        }
        
    }
    function continuar(id)
    {
        $('#staticBackdroperror').modal('hide');
        actualizardatos(id, "concurso");
    }
    function notificaciones(idcon, idus, tipo)
    {
        if(tipo == "general")
        {
            $('#staticBackdropLabelnot').html("{{ trans('multi-new.0033')}}");
            $('#modalbodynot').html(`<p>{{ trans("multi-new.0034") }}</p><form>
            <div class="form-group">
                <label for="not">{{ trans("multi-new.0038") }}&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="{{ trans("multi-new.0041") }})"></i><small style="color:red;font-size:8px;">&nbsp;(* {{ trans("multi-new.0040") }})</small></label>
                <textarea class="form-control" id="not" name="not" rows="3" maxlength="1000"></textarea>
                <small id="errorform" style="color:red;font-size:10px;display:none;"></small>
                <input id="idconc" name="idconc" value="${idcon}" type="hidden"> 
                <input id="idus" name="idus" value="${idus}" type="hidden"> 
                <input id="tipo" name="tipo" value="${tipo}" type="hidden"> 
            </div>
            <button type="button" class="btn btn-primary" id="addnot">{{ trans("multi-new.0038") }}</button>
            </form>`);
        }
        if(tipo == "eliminar")
        {
            $('#staticBackdropLabelnot').html("{{ trans('lang.eliminar') }} {{ trans('multi-new.0033')}}");
            $('#modalbodynot').html(`<p>{{ trans("multi-new.0043") }}</p><form>
            <div class="form-group">
                <label for="not"><i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="{{ trans("multi-new.0041") }})"></i><small style="color:red;font-size:8px;">&nbsp;(* {{ trans("multi-new.0040") }})</small></label>
                <textarea class="form-control" id="not" name="not" rows="3" maxlength="1000" disabled>${idus}</textarea>
                <small id="errorform" style="color:red;font-size:10px;display:none;"></small>
                <input id="idconc" name="idconc" value="${idcon}" type="hidden"> 
                <input id="idus" name="idus" value="${idus}" type="hidden"> 
                <input id="tipo" name="tipo" value="${tipo}" type="hidden"> 
            </div>
            <button type="button" class="btn btn-danger" id="addnot">{{ trans("multi-new.0045") }}</button>
            </form>`);
        }
        if(tipo == "editar")
        {
            $('#staticBackdropLabelnot').html("{{ trans('lang.editar') }} {{ trans('multi-new.0033')}}");
            $('#modalbodynot').html(`<p>{{ trans("multi-new.0044") }}</p><form>
            <div class="form-group">
                <label for="not">{{ trans("multi-new.0038") }}&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="{{ trans("multi-new.0041") }})"></i><small style="color:red;font-size:8px;">&nbsp;(* {{ trans("multi-new.0040") }})</small></label>
                <textarea class="form-control" id="not" name="not" rows="3" maxlength="1000">${idus}</textarea>
                <small id="errorform" style="color:red;font-size:10px;display:none;"></small>
                <input id="idconc" name="idconc" value="${idcon}" type="hidden"> 
                <input id="idus" name="idus" value="${idus}" type="hidden"> 
                <input id="tipo" name="tipo" value="${tipo}" type="hidden"> 
            </div>
            <button type="button" class="btn btn-success" id="addnot">{{ trans("multi-new.0046") }}</button>
            </form>`);
        }
        
        
        $('#staticBackdropnot').modal('show');
    }
    $('#staticBackdropnot').on('show.bs.modal', function (event) {
        
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $( "#addnot" ).on( "click", function() {

            $('#errorform').html('');
            $('#errorform').css('display', 'none');
            let error = "";
            if($('#not').val().length <= 2 || $('#not').val().length > 1000)
            {
                error = '{{ trans("multi-new.0042") }}';
            }
            if(error != '')
            {
                $('#errorform').html(error);
                $('#errorform').css('display', 'block');
                return false;
            }
            else
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var formData = new FormData();
                formData.append("idconc", $('#idconc').val());
                formData.append("id", $('#idus').val());
                formData.append("status", $('#tipo').val());
                formData.append("mens", $('#not').val());
                $.ajax({
                    type: "POST",
                    url: '{{route("actualizar.formulario.postulacion.seleccionados.fase.dos")}}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "JSON",
                    success: function(respu)
                    {
                        if(respu.status == "ok")
                        {
                            
                            var html = "";
                            $('#bodynot').html('');
                            Object.entries(respu.not).forEach(([key, value]) => {
                                
                                html += `<tr>
                                       <th scope="row" class="text-left">
                                            ${respu.not[key]['mens']}
                                        </th>
                                        <th scope="row" class="text-center">
                                            ${respu.not[key]['fecha']}
                                        </th>
                                        <th scope="row">
                                            <button class="btn btn-success btn-sm btn-block mb-1" onclick="notificaciones('${respu.not[key]['id_con']}', '${respu.not[key]['mens']}', 'editar')">Editar</button>
                                            <button class="btn btn-danger btn-sm btn-block" onclick="notificaciones('${respu.not[key]['id_con']}', '${respu.not[key]['mens']}', 'eliminar')">Eliminar</button>
                                        </th>
                                    </tr>`;
                            });
                            const tableselnotnew1 = $('#dt-mant-table-sel-not').dataTable();
                            tableselnotnew1.fnDestroy();
                            console.log("tabla destruida");
                            $('#bodynot').html(html);
                            const tableselnotnew = $('#dt-mant-table-sel-not').DataTable({
                                //"dom": 'lfrtip'
                                "dom": 'frtip', 
                                "pageLength": 10,
                                fixedHeader: true,
                                responsive: true, 
                                "order": [[ 1, "desc" ]],
                                "language": {
                                    "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                                }, 
                            });
                            $('#staticBackdropLabelnot').html("{{ trans('multi-new.0033')}}");
                            $('#modalbodynot').html(`<p>Se ingresó correctamente la notificación general</p>`);
                        }
                        else
                        {
                            $('#staticBackdropLabelnot').html("{{ trans('multi-new.0033')}}");
                            $('#modalbodynot').html(`<p>No pudimos ingresar la notificación general</p>`);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                        $('#staticBackdroperror').modal('show');
                    }
                });
            }
        } );
    });
    function handleClick(val1, val2, val3)
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = new FormData();
        formData.append("iduser", val1);
        formData.append("idpost", val2);
        formData.append("status", val3);
        $.ajax({
            type: "POST",
            url: '{{url("/")}}/actualizar-estado-auditor-proyecto-seleccionado',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(respu)
            {
                $('#staticBackdropLabelgen').html('Asignación de Auditor');
                switch (true) {
                    case (respu.iduser == "instanciaactas"):

                        $('#modalbodygen').html('Tenemos un error al instanciar el actas, asociada a este proyecto.');
                        
                    break;
                    case (respu.iduser == "masdeunaacta"):

                        $('#modalbodygen').html('Tenemos un error de mas de un acta, asociada a este proyecto.');
                        
                    break;
                    case (respu.iduser == "addauditor"):

                        if(val3 == "si")
                        {
                            $('#modalbodygen').html('Se asocio correctamente al auditor, quedando vinculado a la auditoría del proyecto.');
                        }
                        else
                        {
                            $('#modalbodygen').html('Se asocio correctamente al auditor, quedando excluido a la auditoría del proyecto.');
                        }
                        
                    break;
                    case (respu.iduser == "erroraddauditor"):

                        $('#modalbodygen').html('Tenemos un error al agregar este auditor al proyecto.');
                    
                    break;
                    case (respu.iduser == "updateauditor"):

                        if(val3 == "si")
                        {
                            $('#modalbodygen').html('Se actualizó correctamente al auditor, quedando vinculado a la auditoría del proyecto.');
                        }
                        else
                        {
                            $('#modalbodygen').html('Se actualizó correctamente al auditor, quedando excluido a la auditoría del proyecto.');
                        }
                    
                    break;
                    case (respu.iduser == "errorupdateauditor"):

                        $('#modalbodygen').html('Tenemos un error al actualizar este auditor al proyecto.');
                        
                    break;
                    case (respu.iduser == "erroridauditor"):

                        $('#modalbodygen').html('Tenemos un error al actualizar este auditor al proyecto. A');
                        
                    break;
                    case (respu.iduser == "nosecreaacta"):

                        $('#modalbodygen').html('Tenemos un error al crear un acta  al proyecto.');
                    
                    break;
                    default:

                        $('#modalbodygen').html('Tenemos un error al proceder con su solicitud.');

                    break;
                }
                
                $('#staticBackdropgen').modal('show');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $('#staticBackdroperror').modal('show');
            }
        });
    }
    
</script>
@endsection