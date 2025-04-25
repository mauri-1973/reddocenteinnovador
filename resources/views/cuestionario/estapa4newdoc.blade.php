@extends('home')

@section('title')
{{ Auth::user()->name }}
@endsection

@section('extra-css')
<style>
    img.note-float-left
    {
        margin:20px;
    }
    img.note-float-right
    {
        margin:20px;
    }
    #nocat
    {
       color: red;
    }
    .textlabel{
        font-size:18px !important;
        color:#fff;
    }
    .form-control
    {
        font-size:18px !important;
    }
    .form-control1
    {
        font-size:14px !important;
    }
    .textarea1 {
        min-height:270px !important;height:100%;width:100%;
    }
    .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 3px 7px !important;
    vertical-align: middle;
    }
    caption{
        color:#fff;
        caption-side: top;
        font-size:16px;
    }
</style>
@endsection
@section('index')
<div class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            
            <div class="row justify-content-center mt-4">
                <div class="alert bg-white" role="alert" id="alert">
                    <h4 class="alert-heading text-dark">{{ trans('multi-leng.formerror46')}}:</h4>
                    <p style="font-size:16px;" class="text-dark">{{ trans('multi-leng.a177')}}</p>
                    <hr>
                    <p style="font-size:16px;" class="mb-0 text-dark">{{ trans('multi-leng.a178')}}</p>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4 bg-white shadow-sm">
                        <div class="card-body">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-white">
                                        <h4 class="text-dark">{{ trans('multi-leng.a196') }} <strong class="statusval">{{ ($status == 1) ? trans('multi-leng.a197') : trans('multi-leng.a198') }}</strong></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4 bg-white shadow-sm">
                        <div class="card-body">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="author text-white mb-5">
                                            <h3 class="text-dark">{{ trans('multi-leng.a42')}}</h3>
                                        </div>
                                        <div class="author text-white mb-3">
                                            <h5 class="text-dark">7.- RECURSOS SOLICITADOS</h5>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="preg0" class="textlabel text-dark"><b>7.1.- DESGLOSE GENERAL</b></label>
                                            <table class="table table-bordered table-sm" id="tablainicio" style="background-color:#fff;">
                                                <thead>
                                                    <tr>
                                                        <th scope="row">Ítem</th>
                                                        <th scope="row">Total ($)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th class="input-sm" scope="row">
                                                            {{ trans('multi-leng.a117')}}
                                                        </th>
                                                        <td class="input-sm">
                                                            <input class="form-control form-control1 input-sm tab1" data-col="valor1"  id="valor1et4s" name="valor1et4s" type="text" maxlength="8" value="{{ $sumper }}" disabled>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">
                                                            {{ trans('multi-leng.a118')}}
                                                        </th>
                                                        <td>
                                                            <input class="form-control form-control1 input-sm tab1" data-col="valor2"  id="valor2et4" name="valor2et4" type="text" maxlength="8" value="{{ $sumcom }}" disabled>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">
                                                            {{ trans('multi-leng.a119')}}
                                                        </th>
                                                        <td>
                                                            <input class="form-control form-control1 input-sm tab1" data-col="valor3"  id="valor3et4" name="valor3et4" type="text" maxlength="8" value="{{ $sumfun }}" disabled>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">
                                                            {{ trans('multi-leng.a120')}}
                                                        </th>
                                                        <td>
                                                            <input class="form-control form-control1 input-sm tab1" data-col="valor4"  id="valor4et4" name="valor4et4" type="text" maxlength="8" value="{{ $sumotr }}" disabled>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">
                                                            {{ trans('multi-leng.a121') }}
                                                        </th>
                                                        <td>
                                                            <input class="form-control form-control1 input-sm" id="valor5et4" name="valor5ets" type="text" value="{{ $sumper + $sumcom + $sumfun + $sumotr }}" disabled>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="preg3et4" class="textlabel text-dark"><b>7.2.- DETALLE DE LOS RECURSOS SOLICITADOS</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a185') }}" data-html="true"></i>&nbsp; <small style="color:#000;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <label for="preg3et4" class="textlabel text-dark"><b>Especifique en detalle el tipo, cantidad y valor unitario de los recursos que solicita dentro de cada ítem, justificando su adquisición. La justificación es particularmente importante para la evaluación del proyecto. Tome en cuenta que deben ser eficientes y sostenibles.</b></label>
                                            <label for="preg3et4" class="textlabel text-dark"><b>(*) Cree cuantas líneas necesita no es necesario indicar nombres basta con poner por ejemplo Profesional informático, Profesional diseño Instruccional, Impresora, Tablet, etc.</b></label>
                                            
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tablaper">
                                                <caption class="text-dark">{{ trans('multi-leng.a117')}} &nbsp;<button type="button" onclick="completaritem(1, 0, '', 0, 0,  '{{ trans('multi-leng.a117')}}')" class="btn btn-success btn-sm" id="additembtn" style="font-size:12px;">{{ trans('multi-leng.formerror227')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button></caption>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                        <th scope="col">Total ($)</th>
                                                        <th>{{ trans('multi-leng.formerror22')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodytablaper">
                                                    @foreach($tablaper as $tabla)
                                                    <tr>
                                                        
                                                        <th scope="col">{{ $tabla->descri }}</th>
                                                        <td class="text-center">{{ $tabla->valor1 }}</td>
                                                        <td class="text-center">{{ $tabla->valor2 }}</td>
                                                        <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                        <td>
                                                            <button type='button' class='btn btn-warning btn-sm btn-block mb-1' onclick="completaritem(2, {{ $tabla->iddetres }}, '{{ $tabla->descri }}', {{ $tabla->valor1  }}, {{ $tabla->valor2 }}, '{{ trans('multi-leng.a117')}}' )">{{__('lang.editar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            <button type='button' class='btn btn-danger btn-sm btn-block mb-1' onclick="completaritem(3, {{ $tabla->iddetres }}, '{{ $tabla->descri }}', {{ $tabla->valor1  }}, {{ $tabla->valor2 }}, '{{ trans('multi-leng.a117')}}' )">{{__('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        </td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                    
                                                    
                                                </tbody>
                                                <tfoot id="tfoottablaper">
                                                    <tr>
                                                        <th colspan="3" scope="col">ITEM {{ trans('multi-leng.a121')}} </th>
                                                        <th scope="col" class="text-center">$ {{ $sumper }}</th>
                                                        <td>
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <hr class="pt-3 mt-5" style="border-top: 2px solid #000;">
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tablacom">
                                                <caption class="text-dark">{{ trans('multi-leng.a118')}} &nbsp;<button type="button" onclick="completaritemcom(1, 0, '', 0, 0,  '{{ trans('multi-leng.a118')}}', '')" class="btn btn-success btn-sm" id="additembtncom" style="font-size:12px;">{{ trans('multi-leng.formerror227')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button></caption>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ trans('multi-leng.a259')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                        <th scope="col">Total ($)</th>
                                                        <th>{{ trans('multi-leng.formerror22')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodytablacom">
                                                    @foreach($tablacom as $tabla)
                                                    <tr>
                                                        
                                                        <th scope="col">{{ $tabla->descri }}</th>
                                                        <th scope="col" class="text-justify">{{ $tabla->descriplarga }}</th>
                                                        <td class="text-center">{{ $tabla->valor1 }}</td>
                                                        <td class="text-center">{{ $tabla->valor2 }}</td>
                                                        <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                        <td>
                                                            <button type='button' class='btn btn-warning btn-sm btn-block mb-1' onclick="completaritemcom(2, {{ $tabla->iddetres }}, '{{ $tabla->descri }}', {{ $tabla->valor1  }}, {{ $tabla->valor2 }}, '{{ trans('multi-leng.a118')}}', '{{  str_replace("\r\n", '(*-*-*)', $tabla->descriplarga) }}' )">{{__('lang.editar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            <button type='button' class='btn btn-danger btn-sm btn-block mb-1' onclick="completaritemcom(3, {{ $tabla->iddetres }}, '{{ $tabla->descri }}', {{ $tabla->valor1  }}, {{ $tabla->valor2 }}, '{{ trans('multi-leng.a118')}}', '{{ $tabla->descriplarga }}' )">{{__('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        </td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                    
                                                    
                                                </tbody>
                                                <tfoot id="tfoottablacom">
                                                    <tr>
                                                        <th colspan="4" scope="col">ITEM {{ trans('multi-leng.a121')}} </th>
                                                        <th scope="col" class="text-center">$ {{ $sumcom }}</th>
                                                        <td>
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <hr class="pt-3 mt-5" style="border-top: 2px solid #000;">
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tablafun">
                                                <caption class="text-dark">{{ trans('multi-leng.a119')}} &nbsp;<button type="button" onclick="completaritemfun(1, 0, '', 0, 0,  '{{ trans('multi-leng.a119')}}')" class="btn btn-success btn-sm" id="additembtnfun" style="font-size:12px;">{{ trans('multi-leng.formerror227')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button></caption>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                        <th scope="col">Total ($)</th>
                                                        <th>{{ trans('multi-leng.formerror22')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodytablafun">
                                                    @foreach($tablafun as $tabla)
                                                    <tr>
                                                        
                                                        <th scope="col">{{ $tabla->descri }}</th>
                                                        <td class="text-center">{{ $tabla->valor1 }}</td>
                                                        <td class="text-center">{{ $tabla->valor2 }}</td>
                                                        <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                        <td>
                                                            <button type='button' class='btn btn-warning btn-sm btn-block mb-1' onclick="completaritemfun(2, {{ $tabla->iddetres }}, '{{ $tabla->descri }}', {{ $tabla->valor1  }}, {{ $tabla->valor2 }}, '{{ trans('multi-leng.a119')}}' )">{{__('lang.editar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            <button type='button' class='btn btn-danger btn-sm btn-block mb-1' onclick="completaritemfun(3, {{ $tabla->iddetres }}, '{{ $tabla->descri }}', {{ $tabla->valor1  }}, {{ $tabla->valor2 }}, '{{ trans('multi-leng.a119')}}' )">{{__('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        </td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                    
                                                    
                                                </tbody>
                                                <tfoot id="tfoottablafun">
                                                    <tr>
                                                        <th colspan="3" scope="col">ITEM {{ trans('multi-leng.a121')}} </th>
                                                        <th scope="col" class="text-center">$ {{ $sumfun }}</th>
                                                        <td>
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <hr class="pt-3 mt-5" style="border-top: 2px solid #000;">
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tablaotr">
                                                <caption class="text-dark">{{ trans('multi-leng.a120')}} &nbsp;<button type="button" onclick="completaritemotr(1, 0, '', 0, 0,  '{{ trans('multi-leng.a120')}}')" class="btn btn-success btn-sm" id="additembtnotr" style="font-size:12px;">{{ trans('multi-leng.formerror227')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button></caption>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                        <th scope="col">Total ($)</th>
                                                        <th>{{ trans('multi-leng.formerror22')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodytablaotr">
                                                    @foreach($tablaotr as $tabla)
                                                    <tr>
                                                        
                                                        <th scope="col">{{ $tabla->descri }}</th>
                                                        <td class="text-center">{{ $tabla->valor1 }}</td>
                                                        <td class="text-center">{{ $tabla->valor2 }}</td>
                                                        <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                        <td>
                                                            <button type='button' class='btn btn-warning btn-sm btn-block mb-1' onclick="completaritemotr(2, {{ $tabla->iddetres }}, '{{ $tabla->descri }}', {{ $tabla->valor1  }}, {{ $tabla->valor2 }}, '{{ trans('multi-leng.a120')}}' )">{{__('lang.editar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            <button type='button' class='btn btn-danger btn-sm btn-block mb-1' onclick="completaritemotr(3, {{ $tabla->iddetres }}, '{{ $tabla->descri }}', {{ $tabla->valor1  }}, {{ $tabla->valor2 }}, '{{ trans('multi-leng.a120')}}' )">{{__('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        </td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                    
                                                    
                                                </tbody>
                                                <tfoot id="tfoottablaotr">
                                                    <tr>
                                                        <th colspan="3" scope="col">ITEM {{ trans('multi-leng.a121')}} </th>
                                                        <th scope="col" class="text-center">$ {{ $sumotr }}</th>
                                                        <td>
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <hr class="pt-3 mt-5" style="border-top: 2px solid #000;">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="textlabel text-dark"><b>7.2.- JUSTIFICACIÓN DE RECURSOS CLAVES (no se pueden cambiar) para el correcto funcionamiento del proyecto</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a126') }}" data-html="true"></i>&nbsp; <small style="color:#000;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tablajust">
                                                <caption class="text-dark">Justificación &nbsp;<button type="button" onclick="completaritemjust(1, '', '', 0, 0,  'Justificación')" class="btn btn-success btn-sm" id="additembtnjust" style="font-size:12px;">{{ trans('multi-leng.formerror227')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button></caption>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Item</th>
                                                        <th scope="col">Justificación</th>
                                                        <th>{{ trans('multi-leng.formerror22')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodytablajust">
                                                    @foreach($tablajust as $tabla)
                                                    <tr>
                                                        
                                                        <th scope="col" class="text-justify">{{ $tabla->name }}</th>
                                                        <td class="text-justify">{{ $tabla->descri }}</td>
                                                        <td>
                                                            <button type='button' class='btn btn-warning btn-sm btn-block mb-1' onclick="completaritemjust(2, {{ $tabla->iddetres }}, '{{ $tabla->name }}', '{{ $tabla->descri  }}', '', 'Justificación' )">{{__('lang.editar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            <button type='button' class='btn btn-danger btn-sm btn-block mb-1' onclick="completaritemjust(3, {{ $tabla->iddetres }}, '{{ $tabla->name }}', '{{ $tabla->descri  }}', '', 'Justificación' )">{{__('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        </td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('ver.nuevo.formulario.docente.tercera.etapa', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a104')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <button id="validardatos" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a87')}} {{ trans('multi-leng.a157')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <button id="finalizarpost" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.a127')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('buscar.concursos.registrados.docentes.fase.dos' ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-t-2 border-gray-600">
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4 bg-white shadow-sm">
                        <div class="card-body">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-white">
                                        <h4 class="text-dark">{{ trans('multi-leng.a196') }} <strong class="statusval">{{ ($status == 1) ? trans('multi-leng.a197') : trans('multi-leng.a198') }}</strong></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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

<input type="hidden" id="idconc" name="idconc" value="{{ $idconcurso }}">
<input type="hidden" id="idpost" name="idpost" value="{{ $idpostulacion }}">
<input type="hidden" id="idansw" name="idansw" value="{{ $idansw }}">
<input type="hidden" id="valorinicial1" name="valorinicial1" value="{{ $sumper }}">
<input type="hidden" id="valorinicial2" name="valorinicial2" value="{{ $sumcom }}">
<input type="hidden" id="valorinicial3" name="valorinicial3" value="{{ $sumfun }}">
<input type="hidden" id="valorinicial4" name="valorinicial4" value="{{ $sumotr }}">

@endsection

@section('extra-script')
<script type="text/javascript">
    
    $(document).ready(function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $('#tablaper').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,      
            "order": false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tablacom').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,      
            "order": false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tablafun').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,      
            "order": false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tablaotr').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,      
            "order": false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tablajust').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,      
            "order": false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tabla2').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,      
            "order": false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        function ocultar() {
            $('#alert').css('display', 'none');
        }
        setTimeout(ocultar, 13000);
        $('#alert').focus();
        
    });
    $('#mensaje_ayuda1c').text('1500 {{ trans('multi-leng.a58')}}');
    $('#preg3et4').keyup(function (e) {
        var max = 1500;
        var len = $(this).val().length;
        if (len >= max) 
        {
            $('#mensaje_ayuda1c').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda1c').addClass('text-danger');                  
        } 
        else 
        {
            var ch2 = max - len;
            $('#mensaje_ayuda1c').text(ch2 + ' {{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda1c').removeClass('text-danger');
            actualizardatos($(this).val(), 0, 0, "answ", 0, 0, e, null);         
        }
    });

    function completaritem(item, id, des, val1, val2, title)
    {
        if(item == 1)
        {
            $('#staticBackdropLabel').html(`{{ trans('multi-leng.formerror227')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" autofocus>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}">
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}">
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailind" class="btn btn-primary btn-sm btn-block" type="button">{{ trans('multi-leng.formerror227')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else if(item == 2)
        {
            $('#staticBackdropLabel').html(`{{ trans('lang.editar')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" autofocus>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}">
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}">
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailind" class="btn btn-primary btn-sm btn-block" type="button">{{ trans('lang.editar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else if(item == 3)
        { 
            $('#staticBackdropLabel').html(`{{ trans('lang.eliminar')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" disabled>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}" disabled>
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}" disabled>
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailind" class="btn btn-danger btn-sm btn-block" type="button">{{ trans('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        
    }
    function completaritemcom(item, id, des, val1, val2, title, descriplarga)
    {
        descriplarga = descriplarga.split('(*-*-*)').join('\r\n');
        if(item == 1)
        {
            $('#staticBackdropLabel').html(`{{ trans('multi-leng.formerror227')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a259')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" autofocus>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a260') }}" data-html="true"></i></label>
                                            <textarea class="form-control input-lg textarea1" placeholder="{{ __('multi-leng.a260') }}" id="descriplarga" name="descriplarga" rows="15" maxlength="1500">${descriplarga}</textarea>
                                            <small id="mensaje4" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}">
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}">
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindcom" class="btn btn-primary btn-sm btn-block" type="button">{{ trans('multi-leng.formerror227')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else if(item == 2)
        {
            $('#staticBackdropLabel').html(`{{ trans('lang.editar')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a259')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" autofocus>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a260') }}" data-html="true"></i></label>
                                            <textarea class="form-control input-lg textarea1" placeholder="{{ __('multi-leng.a260') }}" id="descriplarga" name="descriplarga" rows="15" maxlength="1500">${descriplarga}</textarea>
                                            <small id="mensaje4" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}">
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}">
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindcom" class="btn btn-primary btn-sm btn-block" type="button">{{ trans('lang.editar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else if(item == 3)
        { 
            $('#staticBackdropLabel').html(`{{ trans('lang.eliminar')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" disabled>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a260') }}" data-html="true"></i></label>
                                            <textarea class="form-control input-lg textarea1" placeholder="{{ __('multi-leng.a260') }}" id="descriplarga" name="descriplarga" rows="15" maxlength="1500" disabled>${descriplarga}</textarea>
                                            <small id="mensaje4" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}" disabled>
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}" disabled>
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindcom" class="btn btn-danger btn-sm btn-block" type="button">{{ trans('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        
    }
    function completaritemfun(item, id, des, val1, val2, title)
    {
        if(item == 1)
        {
            $('#staticBackdropLabel').html(`{{ trans('multi-leng.formerror227')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" autofocus>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}">
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}">
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindfun" class="btn btn-primary btn-sm btn-block" type="button">{{ trans('multi-leng.formerror227')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else if(item == 2)
        {
            $('#staticBackdropLabel').html(`{{ trans('lang.editar')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" autofocus>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}">
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}">
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindfun" class="btn btn-primary btn-sm btn-block" type="button">{{ trans('lang.editar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else if(item == 3)
        { 
            $('#staticBackdropLabel').html(`{{ trans('lang.eliminar')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" disabled>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}" disabled>
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}" disabled>
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindfun" class="btn btn-danger btn-sm btn-block" type="button">{{ trans('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        
    }
    function completaritemotr(item, id, des, val1, val2, title)
    {
        if(item == 1)
        {
            $('#staticBackdropLabel').html(`{{ trans('multi-leng.formerror227')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" autofocus>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}">
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}">
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindotr" class="btn btn-primary btn-sm btn-block" type="button">{{ trans('multi-leng.formerror227')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else if(item == 2)
        {
            $('#staticBackdropLabel').html(`{{ trans('lang.editar')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" autofocus>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}">
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}">
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindotr" class="btn btn-primary btn-sm btn-block" type="button">{{ trans('lang.editar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else if(item == 3)
        { 
            $('#staticBackdropLabel').html(`{{ trans('lang.eliminar')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" disabled>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="cant" name="cant" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val1}" disabled>
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a128') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" id="unit" name="unit" minlength="1" placeholder="0" maxlength="8" onkeypress="return valideKeycel(event);" value="${val2}" disabled>
                                            <small id="mensaje3" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindotr" class="btn btn-danger btn-sm btn-block" type="button">{{ trans('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        
    }
    function completaritemjust(item, id, des, val1, val2, title)
    {
        
        if(item == 1)
        {
            $('#staticBackdropLabel').html(`{{ trans('multi-leng.formerror227')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>Item</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="" autofocus>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>Justificación</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Mínimo 2 caracteres, máximo 1500 caracteres" data-html="true"></i></label>
                                            <textarea class="form-control input-lg textarea1" placeholder="Agregue la Justificación al Item ingresado." id="descriplarga" name="descriplarga" rows="15" maxlength="1500"></textarea>
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindjust" class="btn btn-primary btn-sm btn-block" type="button">{{ trans('multi-leng.formerror227')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else if(item == 2)
        {
            descriplarga = val1.split('(*-*-*)').join('\r\n');
            $('#staticBackdropLabel').html(`{{ trans('lang.editar')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" autofocus>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>Justificación</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Mínimo 2 caracteres, máximo 1500 caracteres" data-html="true"></i></label>
                                            <textarea class="form-control input-lg textarea1" placeholder="Agregue la Justificación al Item ingresado." id="descriplarga" name="descriplarga" rows="15" maxlength="1500">${descriplarga}</textarea>
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindjust" class="btn btn-primary btn-sm btn-block" type="button">{{ trans('lang.editar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else if(item == 3)
        { 
            descriplarga = val1.split('(*-*-*)').join('\r\n');
            $('#staticBackdropLabel').html(`{{ trans('lang.eliminar')}} ${title}`); 
            $('#modalbody').html(`<form>
                                        <input type="hidden" id="item" name="item" value="${item}">
                                        <input type="hidden" id="idtab" name="idtab" value="${id}">
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i></label>
                                            <input type="text" class="form-control" name="desc" id="desc" placeholder="xxxxxxx xxxxxxxx xxxxxxx" minlength="2" maxlength="70" value="${des}" disabled>
                                            <small id="mensaje1" style="color:red"></small>
                                        </div>
                                        <div class="mb-3 form-group">
                                            <label class="form-label"><b>Justificación</b>&nbsp;&nbsp;<i style="color:#004238;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Mínimo 2 caracteres, máximo 1500 caracteres" data-html="true"></i></label>
                                            <textarea class="form-control input-lg textarea1" placeholder="Agregue la Justificación al Item ingresado." id="descriplarga" name="descriplarga" rows="15" maxlength="1500" disabled>${descriplarga}</textarea>
                                            <small id="mensaje2" style="color:red"></small>
                                        </div>
                                        <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                <button id="adddetailindjust" class="btn btn-danger btn-sm btn-block" type="button">{{ trans('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        
    }

    function valideKeycel(evt)
    {
        var code = (evt.which) ? evt.which : evt.keyCode;

        if(code==8) 
        {
            return true;
        }
        else if(code>=48 && code<=57) 
        { 
            return true;
        } 
        else
        {
            return false;
        }
    }

    $("#staticBackdrop").on('show.bs.modal', function() { 
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        

        $(document).on('click','#adddetailind',function(e){
            let error = "";
            let cant, unit, desc;
            desc = $.trim($("#desc").val());
            cant = parseInt($("#cant").val());
            $("#cant").val(parseInt($("#cant").val()));
            unit = parseInt($("#unit").val());
            $("#unit").val(parseInt($("#unit").val()));

            $("#mensaje1").html('');
            $("#mensaje2").html('');
            $("#mensaje3").html('');
            let val1, val2, val3, val4, totacu, idtab;
            if(desc.length < 2)
            {
                error += "{{ __('multi-leng.a182') }}<br>";
                $("#mensaje1").html('{{ __('multi-leng.a89') }}');
            }
            if(cant <= 0)
            {
                error += "{{ __('multi-leng.a183') }}<br>";
                $("#mensaje2").html('{{ __('multi-leng.a89') }}');
            }
            if(unit <= 0)
            {
                error += "{{ __('multi-leng.a184') }}<br>";
                $("#mensaje3").html('{{ __('multi-leng.a89') }}');
            }
            if(error != '')
            {
                return false;
            }
            else
            {
                console.log("btn 1");
                $("#additembtn").prop("disabled", true);
                $("#adddetailind").prop("disabled", true);
                actualizardatos(desc, cant, unit, "additems", $("#idtab").val(), $("#item").val(), e, null);
                e.stopPropagation();
                e.preventDefault();
                console.log("btn 2");
                
            }
        });
        $(document).on('click','#adddetailindcom',function(e){
            let error = "";
            
            let cant, unit, desc;
            desc = $.trim($("#desc").val());
            desclarga = $.trim($("#descriplarga").val());
            cant = parseInt($("#cant").val());
            $("#cant").val(parseInt($("#cant").val()));
            unit = parseInt($("#unit").val());
            $("#unit").val(parseInt($("#unit").val()));
            
            $("#mensaje1").html('');
            $("#mensaje2").html('');
            $("#mensaje3").html('');
            $("#mensaje4").html('');
            let val1, val2, val3, val4, totacu, idtab;
            if(desc.length < 2)
            {
                error += "{{ __('multi-leng.a261') }}<br>";
                $("#mensaje1").html('{{ __('multi-leng.a261') }}');
            }
            
            if(desclarga.length < 2)
            {
                error += "{{ __('multi-leng.a182') }}<br>";
                $("#mensaje4").html('{{ __('multi-leng.a182') }}');
            }
            if(cant <= 0)
            {
                error += "{{ __('multi-leng.a183') }}<br>";
                $("#mensaje2").html('{{ __('multi-leng.a183') }}');
            }
            if(unit <= 0)
            {
                error += "{{ __('multi-leng.a184') }}<br>";
                $("#mensaje3").html('{{ __('multi-leng.a184') }}');
            }
            if(error != '')
            {
                return false;
            }
            else
            {
               
                $("#additembtncom").prop("disabled", true);
                $("#adddetailindcom").prop("disabled", true);
                actualizardatos(desc, cant, unit, "additemscom", $("#idtab").val(), $("#item").val(), e, desclarga);
                e.stopPropagation();
                e.preventDefault();
            }
        });
        $(document).on('click','#adddetailindfun',function(e){
            let error = "";
            let cant, unit, desc;
            desc = $.trim($("#desc").val());
            cant = parseInt($("#cant").val());
            $("#cant").val(parseInt($("#cant").val()));
            unit = parseInt($("#unit").val());
            $("#unit").val(parseInt($("#unit").val()));

            $("#mensaje1").html('');
            $("#mensaje2").html('');
            $("#mensaje3").html('');
            let val1, val2, val3, val4, totacu, idtab;
            if(desc.length < 2)
            {
                error += "{{ __('multi-leng.a182') }}<br>";
                $("#mensaje1").html('{{ __('multi-leng.a89') }}');
            }
            if(cant <= 0)
            {
                error += "{{ __('multi-leng.a183') }}<br>";
                $("#mensaje2").html('{{ __('multi-leng.a89') }}');
            }
            if(unit <= 0)
            {
                error += "{{ __('multi-leng.a184') }}<br>";
                $("#mensaje3").html('{{ __('multi-leng.a89') }}');
            }
            if(error != '')
            {
                return false;
            }
            else
            {
                $("#additembtnfun").prop("disabled", true);
                $("#adddetailindfun").prop("disabled", true);
                actualizardatos(desc, cant, unit, "additemsfun", $("#idtab").val(), $("#item").val(), e, null);
                e.stopPropagation();
                e.preventDefault();
            }
        });
        $(document).on('click','#adddetailindotr',function(e){
            let error = "";
            let cant, unit, desc;
            desc = $.trim($("#desc").val());
            cant = parseInt($("#cant").val());
            $("#cant").val(parseInt($("#cant").val()));
            unit = parseInt($("#unit").val());
            $("#unit").val(parseInt($("#unit").val()));

            $("#mensaje1").html('');
            $("#mensaje2").html('');
            $("#mensaje3").html('');
            let val1, val2, val3, val4, totacu, idtab;
            if(desc.length < 2)
            {
                error += "{{ __('multi-leng.a182') }}<br>";
                $("#mensaje1").html('{{ __('multi-leng.a89') }}');
            }
            if(cant <= 0)
            {
                error += "{{ __('multi-leng.a183') }}<br>";
                $("#mensaje2").html('{{ __('multi-leng.a89') }}');
            }
            if(unit <= 0)
            {
                error += "{{ __('multi-leng.a184') }}<br>";
                $("#mensaje3").html('{{ __('multi-leng.a89') }}');
            }
            if(error != '')
            {
                return false;
            }
            else
            {
                $("#additembtnotr").prop("disabled", true);
                $("#adddetailindotr").prop("disabled", true);
                actualizardatos(desc, cant, unit, "additemsotr", $("#idtab").val(), $("#item").val(), e, null);
                e.stopPropagation();
                e.preventDefault();
            }
        });
        $(document).on('click','#adddetailindjust',function(e){
            let error = "";
            let desc, descriplarga;
            desc = $.trim($("#desc").val());
            descriplarga = $.trim($("#descriplarga").val());

            $("#mensaje1").html('');
            $("#mensaje2").html('');
            let val1, val2, val3, val4, totacu, idtab;
            if(desc.length < 2)
            {
                error += "{{ __('multi-leng.a182') }}<br>";
                $("#mensaje1").html('Ingrese el Item');
            }
            if(descriplarga.length < 2)
            {
                error += "{{ __('multi-leng.a182') }}<br>";
                $("#mensaje2").html('Ingrese la Justificación');
            }
            if(error != '')
            {
                return false;
            }
            else
            {
                $("#additembtnjust").prop("disabled", true);
                $("#adddetailindjust").prop("disabled", true);
                actualizardatos(desc, descriplarga, 0, "additemsjust", $("#idtab").val(), $("#item").val(), e, null);
                e.stopPropagation();
                e.preventDefault();
            }
        });
        
    });
    function actualizardatos(val, col, type, tipo, data, data1, event, adicional)
    {
        
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
        });
        var formData = new FormData();
        formData.append("idansw", $("#idansw").val());
        formData.append("idpost", $("#idpost").val());
        formData.append("value", val);
        formData.append("col", col);
        formData.append("type", type);
        formData.append("tipo", tipo);
        formData.append("data", data);
        formData.append("data1", data1);
        formData.append("adicional", adicional);
        $.ajax({
            type: "POST",
            url: '{{ route("actualizar.nuevo.formulario.postulacion-docente.etapa.cuatro") }}',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(respu)
            {
                console.log("btn 3");
                event.stopPropagation();
                event.preventDefault();
                if(type == "final")
                {
                    console.log("btn 4");
                    $('#finalizarpost').prop('disabled', false);
                    if(respu.status == 1)
                    {
                        window.location.href = "{{url('/')}}/ver-nuevo-formulario-docente-primera-etapa/"+respu.id;
                    }
                    else if(respu.status == 0)
                    {
                        console.log("btn 5");
                        $('.statusval').html('{{ trans('multi-leng.a197')}}');
                        $('#staticBackdropLabel').html('{{ trans('multi-leng.a164')}}');
                        $('#modalbody').html(`<strong>{{ trans('multi-leng.a169')}}</strong><br><br>${respu.error}<br><strong>{{ trans('multi-leng.a170') }}</strong>`);
                        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
                        $('#staticBackdrop').modal('show');
                    }
                    else
                    {
                        console.log("btn 6");
                    }
                    
                }
                else
                {
                    console.log("btn 7");
                    location.reload();
                }
                
            }
        });
    }
    $(document).on('click','#validardatos',function(e){
        let error = "";

        
        if($.trim($("#valor5et4").val()).length == 0 || parseInt($("#valor5et4").val()) == 0 )
        {
            error += "<strong>{{ trans('multi-leng.a159')}}</strong><br>";
        }
        
        if(error != "")
        {
            $('#staticBackdropLabel').html('{{ trans('multi-leng.a164')}}');
            $('#modalbody').html(`{{ trans('multi-leng.a162')}} <br>${error}`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else
        {
            $('#validardatos').prop('disabled', true);
            actualizardatos(1, 0, "val", 0, 0, 0, e, null);
            e.stopPropagation();
            e.preventDefault();
        }
        
    });
    $(document).on('click','#finalizarpost',function(e){

        actualizardatos(0, 0, "final", 0, 0, 0, e, null);
        $('#finalizarpost').prop('disabled', true);
        e.stopPropagation();
        e.preventDefault();
        
    });
    
</script>
@endsection
