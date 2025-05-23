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
                <div class="col-md-12">
                    <div class="card mb-4 bg-white shadow-sm">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <a href="{{ route('imprimr.formulario.docente.fase.dos', $idpostulacion) }}" role="button" id="imprimir" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a204')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    @role('revisor')
                                        <a href="{{ route('ver-postulaciones-concursos-registrados', $idconcurso ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                    @endrole
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <a href="{{ route('ver.nuevo.formulario.docente.segunda.etapa.admin', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block" disabled>{{ trans('inst.147')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
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
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-white">
                                        <h4 class="text-dark">{{ trans('multi-leng.a205') }} <strong class="statusval">{{ $text }}</strong></h4>
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
                                            <h5 class="text-dark">{{ trans('inst.127')}}</h5>
                                        </div>
                                    <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="preg0" class="textlabel text-dark"><b>{{ trans('inst.128')}}</b></label>
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
                                            <label for="preg3et4" class="textlabel text-dark"><b>{{ trans('inst.129')}}</b></label>
                                            <label for="preg3et4" class="textlabel text-dark"><b>{{ trans('inst.130')}}</b></label>
                                            <label for="preg3et4" class="textlabel text-dark"><b>{{ trans('inst.131')}}</b></label>
                                            
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tablaper">
                                                <caption class="text-dark">{{ trans('multi-leng.a117')}} &nbsp;</caption>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                        <th scope="col">Total ($)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodytablaper">
                                                    @foreach($tablaper as $tabla)
                                                    <tr>
                                                        
                                                        <th scope="col">{{ $tabla->descri }}</th>
                                                        <td class="text-center">{{ $tabla->valor1 }}</td>
                                                        <td class="text-center">{{ $tabla->valor2 }}</td>
                                                        <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                    
                                                    
                                                </tbody>
                                                <tfoot id="tfoottablaper">
                                                    <tr>
                                                        <th colspan="3" scope="col">ITEM {{ trans('multi-leng.a121')}} </th>
                                                        <th scope="col" class="text-center">$ {{ $sumper }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br>
                                            <label for="obspreg20" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg20" name="obspreg20" rows="15" maxlength="500">{{ $finalstus->obspreg20 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda20" class="help-block"></p>
                                            </span>

                                        <hr class="pt-3 mt-5" style="border-top: 2px solid #000;">
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tablacom">
                                                <caption class="text-dark">{{ trans('multi-leng.a118')}} &nbsp;</caption>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ trans('multi-leng.a259')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                        <th scope="col">Total ($)</th>
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
                                                        
                                                    </tr>
                                                    @endforeach
                                                    
                                                    
                                                </tbody>
                                                <tfoot id="tfoottablacom">
                                                    <tr>
                                                        <th colspan="4" scope="col">ITEM {{ trans('multi-leng.a121')}} </th>
                                                        <th scope="col" class="text-center">$ {{ $sumcom }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br>
                                            <label for="obspreg21" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg21" name="obspreg21" rows="15" maxlength="500">{{ $finalstus->obspreg21 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda21" class="help-block"></p>
                                            </span>
                                        <hr class="pt-3 mt-5" style="border-top: 2px solid #000;">
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tablafun">
                                                <caption class="text-dark">{{ trans('multi-leng.a119')}} &nbsp;</caption>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                        <th scope="col">Total ($)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodytablafun">
                                                    @foreach($tablafun as $tabla)
                                                    <tr>
                                                        
                                                        <th scope="col">{{ $tabla->descri }}</th>
                                                        <td class="text-center">{{ $tabla->valor1 }}</td>
                                                        <td class="text-center">{{ $tabla->valor2 }}</td>
                                                        <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                    
                                                    
                                                </tbody>
                                                <tfoot id="tfoottablafun">
                                                    <tr>
                                                        <th colspan="3" scope="col">ITEM {{ trans('multi-leng.a121')}} </th>
                                                        <th scope="col" class="text-center">$ {{ $sumfun }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br>
                                            <label for="obspreg22" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg22" name="obspreg22" rows="15" maxlength="500">{{ $finalstus->obspreg22 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda22" class="help-block"></p>
                                            </span>
                                        <hr class="pt-3 mt-5" style="border-top: 2px solid #000;">
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tablaotr">
                                                <caption class="text-dark">{{ trans('multi-leng.a120')}} &nbsp;</caption>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                        <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                        <th scope="col">Total ($)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodytablaotr">
                                                    @foreach($tablaotr as $tabla)
                                                    <tr>
                                                        
                                                        <th scope="col">{{ $tabla->descri }}</th>
                                                        <td class="text-center">{{ $tabla->valor1 }}</td>
                                                        <td class="text-center">{{ $tabla->valor2 }}</td>
                                                        <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                    
                                                    
                                                </tbody>
                                                <tfoot id="tfoottablaotr">
                                                    <tr>
                                                        <th colspan="3" scope="col">ITEM {{ trans('multi-leng.a121')}} </th>
                                                        <th scope="col" class="text-center">$ {{ $sumotr }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br>
                                            <label for="obspreg23" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg23" name="obspreg23" rows="15" maxlength="500">{{ $finalstus->obspreg23 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda23" class="help-block"></p>
                                            </span>
                                        <hr class="pt-3 mt-5" style="border-top: 2px solid #000;">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="textlabel text-dark"><b>{{ trans('inst.132')}}</b></label>
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tablajust">
                                                <caption class="text-dark">{{ trans('inst.133')}} &nbsp;</caption>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Item</th>
                                                        <th scope="col">{{ trans('inst.133')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="bodytablajust">
                                                    @foreach($tablajust as $tabla)
                                                    <tr>
                                                        
                                                        <th scope="col" class="text-justify">{{ $tabla->name }}</th>
                                                        <td class="text-justify">{{ $tabla->descri }}</td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <br>
                                            <label for="obspreg24" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg24" name="obspreg24" rows="15" maxlength="500">{{ $finalstus->obspreg24 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda24" class="help-block"></p>
                                            </span>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <br>
                                            <label for="obspreg25" class="textlabel text-dark"><b>{{ __('inst.140') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg25" name="obspreg25" rows="15" maxlength="500">{{ $finalstus->obspreg25 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda25" class="help-block"></p>
                                            </span>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('ver.nuevo.formulario.revisor.tercera.etapa', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a104')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('imprimr.formulario.docente.fase.dos', $idpostulacion) }}" role="button" id="imprimir" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a204')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('ver-postulaciones-concursos-registrados', $idconcurso  ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <button id="finalizar" class="btn btn-success btn-sm btn-block">{{ trans('inst.141')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
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
                                        <h4 class="text-dark">{{ trans('multi-leng.a205') }} <strong class="statusval">{{ $text }}</strong></h4>
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
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="staticBackdropLabel">{{ trans('multi-leng.admcat')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
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
<form id="formfin" action='{{ route("actualizar.observaciones.postulacion.revisor.fase.dos") }}' method="post" style="display:none;">
    <input type="hidden" id="tipo" name="tipo" value="finalizar">
    <input type="hidden" id="idpost" name="idpost" value="{{ $idpostulacion }}">
    <input type="hidden" id="idconc" name="idconc" value="{{ $idconcurso }}">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
</form>

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
        $('#obspreg20').trigger('keyup');
        $('#obspreg21').trigger('keyup');
        $('#obspreg22').trigger('keyup');
        $('#obspreg23').trigger('keyup');
        $('#obspreg24').trigger('keyup'); 
        $('#obspreg25').trigger('keyup');
        
    });
    $('#finalizar').click(function () {
         
        $('#staticBackdropLabel').html("{{ trans('inst.141') }}");
        $('#modalbody').html("<p><strong>{{ trans('inst.142') }}</strong></p>");
        $('#footerbody').html(`<button type="button" id="btnfinalizar" class="btn btn-warning">{{ trans('inst.141') }}</button><button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('lang.cancelar') }}</button>
        `);
        
        $('#staticBackdrop').modal('show');
    });
    
    $('#staticBackdrop').on('shown.bs.modal', function () {
        $('#btnfinalizar').click(function () {

            $('#formfin').submit();

        });
    });
    $('#obspreg20').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda20').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda20').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda20').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda20').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg20", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg21').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda21').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda21').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda21').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda21').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg21", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg22').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda22').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda22').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda22').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda22').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg22", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg23').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda23').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda23').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda23').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda23').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg23", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg24').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda24').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda24').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda24').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda24').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg24", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg25').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda25').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda25').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda25').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda25').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg25", "correctionsprocesodos", "actualizar");

        }
    });
    function actualizardatos(val, col, tabla, tipo)
    {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = new FormData();
        formData.append("value", val);
        formData.append("col", col);
        formData.append("tabla", tabla);
        formData.append("tipo", tipo);
        formData.append("idet", '{{ $idpostulacion }}' );
        $.ajax({
            type: "POST",
            url: '{{ route("actualizar.observaciones.postulacion.revisor.fase.dos") }}',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(respu)
            {
                if(tipo == "finalizar" && respu.status == "ok")
                {
                    $('#staticBackdrop').modal('hide');
                }
                console.log(respu);
                
            }
        });
    }
   
</script>
@endsection
