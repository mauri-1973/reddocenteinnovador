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
        font-size:12px !important;
    }
    .textarea1 {
        min-height:270px !important;height:100%;width:100%;
    }
    .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 3px 7px !important;
    vertical-align: middle;
    }
    .dataTables_filter input {
    color: white;
    background-color: black;
    }
    .dataTables_wrapper .dataTables_info {
        color: #fff; !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: white !important;
        border: 1px solid #fff!important;
        background-color: #fff!important;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fff), color-stop(100%, #fff))!important;
        background: -webkit-linear-gradient(top, #fff 0%, #fff 100%)!important;
        background: -moz-linear-gradient(top, #fff 0%, #fff 100%)!important;
        background: -ms-linear-gradient(top, #fff 0%, #fff 100%)!important;
        background: -o-linear-gradient(top, #fff 0%, #fff 100%)!important;
        background: linear-gradient(to bottom, #fff 0%, #fff 100%)!important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: white !important;
        border: 1px solid #fff!important;
        background-color: #fff!important;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fff), color-stop(100%, #fff))!important;
        background: -webkit-linear-gradient(top, #fff 0%, #fff 100%)!important;
        background: -moz-linear-gradient(top, #fff 0%, #fff 100%)!important;
        background: -ms-linear-gradient(top, #fff 0%, #fff 100%)!important;
        background: -o-linear-gradient(top, #fff 0%, #fff 100%)!important;
        background: linear-gradient(to bottom, #fff 0%, #fff 100%)!important;
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
                                            <h5 class="text-dark">{{ trans('inst.112') }} </h5>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="indicadores" class="textlabel text-dark"><b>{{ trans('inst.113') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ trans('inst.114') }}" id="indicadores" name="indicadores" rows="30" disabled>{{ $finalstus->pregunta6 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda1b" class="help-block" style="color:#000;"></p>
                                            </span>
                                            <label for="obs1" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obs1" name="obs1" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg15 }}</textarea> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="resultados" class="textlabel text-dark"><b>{{ trans('inst.115') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ trans('inst.116') }}" id="resultados" name="resultados" rows="30" disabled>{{ $finalstus->pregunta7 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda2b" class="help-block" style="color:#000;"></p>
                                            </span>
                                            <label for="obs2" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obs2" name="obs2" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg16 }}</textarea> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="impacto" class="textlabel text-dark"><b>{{ trans('inst.117') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ trans('inst.118') }}" id="impacto" name="impacto" rows="30" disabled>{{ $finalstus->pregunta8 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda3b" class="help-block" style="color:#000;"></p>
                                            </span>
                                            <label for="obs3" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obs3" name="obs3" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg17 }}</textarea> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="institucional" class="textlabel text-dark"><b>{{ trans('inst.119') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ trans('inst.120') }}" id="institucional" name="institucional" rows="30" disabled>{{ $finalstus->pregunta9 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda4b" class="help-block" style="color:#000;"></p>
                                            </span>
                                            <label for="obs4" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obs4" name="obs4" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg18 }}</textarea> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="author text-white mb-3">
                                            <br>
                                            <h5 class="text-dark">{{ trans('inst.121') }} </h5>
                                            <br>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="institucional" class="textlabel text-dark"><b>{{ trans('inst.122') }}</b></label>
                                            
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tabla2">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('inst.123') }}</th>
                                                        <th>{{ trans('inst.124') }}</th>
                                                        <th>{{ trans('inst.125') }}</th>
                                                        <th>{{ trans('inst.126') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodytable2">
                                                    @foreach($array as $row)
                                                    <tr>
                                                        <th class="text-justify">{{ $row->titulo }}</th>
                                                        <th>{{ date('d-m-Y', strtotime($row->fechainicio)) }}</th>
                                                        <th>{{ date('d-m-Y', strtotime($row->fechatermino)) }}</th>
                                                        <th class="text-justify">{{ $row->descripcion }}</th>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <label for="obs5" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obs5" name="obs5" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg19 }}</textarea> 
                                            
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <div class="container-fluid">
                                                <div class="row">
                                                        
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('ver.nuevo.formulario.docente.segunda.etapa.admin', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a104')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('imprimr.formulario.docente.fase.dos', $idpostulacion) }}" role="button" id="imprimir" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a204')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    @role('admin')
                                                        <a href="{{ route('ver-postulaciones-concursos-registrados-administrador', $idconcurso ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    @endrole
                                                    @role('docente')
                                                        <a href="{{ route('ver.postulaciones.activas.docentes.fase.dos') }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    @endrole
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('ver.nuevo.formulario.docente.cuarta.etapa.admin', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a88')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
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
<input type="hidden" id="idetapa" name="idetapa" value="{{ Crypt::encrypt($finalstus->id) }}">


@endsection

@section('extra-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script type="text/javascript">
    
    $(document).ready(function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $('#tabla2').DataTable({
            //"dom": 'lfrtip'
            "dom": 'frtip', 
            fixedHeader: true,
            responsive: true,      
            "order": [[ 1, "desc" ]],
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
    $('#mensaje_ayuda1b').text('400 palabras');
    $('#mensaje_ayuda2b').text('400 palabras');
    $('#mensaje_ayuda3b').text('400 palabras');
    $('#mensaje_ayuda4b').text('400 palabras');
    $('#indicadores').keyup(function () {
        var max = 400;
        const texto = this.value.trim(); // Eliminar espacios en blanco al inicio y al final
        const palabras = texto.length > 0 ? texto.split(/\s+/) : [];
        if (palabras.filter(Boolean).length > max) {
            this.value = palabras.slice(0, max).join(' ');
            $('#mensaje_ayuda1b').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda1b').addClass('text-danger');                  
        } 
        else {
            var ch2 = max - palabras.filter(Boolean).length;
            $('#mensaje_ayuda1b').text(ch2 + ' palabras restantes');
            $('#mensaje_ayuda1b').removeClass('text-danger');
            actualizardatos($(this).val(), "pregunta6", "etapa3", 0, 0, 0);

        }
    });
    $('#resultados').keyup(function () {
        var max = 400;
        const texto = this.value.trim(); // Eliminar espacios en blanco al inicio y al final
        const palabras = texto.length > 0 ? texto.split(/\s+/) : [];
        if (palabras.filter(Boolean).length > max) {
            this.value = palabras.slice(0, max).join(' ');
            $('#mensaje_ayuda2b').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda2b').addClass('text-danger');                  
        } 
        else {
            var ch2 = max - palabras.filter(Boolean).length;
            $('#mensaje_ayuda2b').text(ch2 + ' palabras restantes');
            $('#mensaje_ayuda2b').removeClass('text-danger');
            actualizardatos($(this).val(), "pregunta7", "etapa3", 0, 0, 0);

        }
    });
    $('#impacto').keyup(function () {
        var max = 400;
        const texto = this.value.trim(); // Eliminar espacios en blanco al inicio y al final
        const palabras = texto.length > 0 ? texto.split(/\s+/) : [];
        if (palabras.filter(Boolean).length > max) {
            this.value = palabras.slice(0, max).join(' ');
            $('#mensaje_ayuda3b').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda3b').addClass('text-danger');                  
        } 
        else {
            var ch2 = max - palabras.filter(Boolean).length;
            $('#mensaje_ayuda3b').text(ch2 + ' palabras restantes');
            $('#mensaje_ayuda3b').removeClass('text-danger');
            actualizardatos($(this).val(), "pregunta8", "etapa3", 0, 0, 0);

        }
    });
    $('#institucional').keyup(function () {
        var max = 400;
        const texto = this.value.trim(); // Eliminar espacios en blanco al inicio y al final
        const palabras = texto.length > 0 ? texto.split(/\s+/) : [];
        if (palabras.filter(Boolean).length > max) {
            this.value = palabras.slice(0, max).join(' ');
            $('#mensaje_ayuda4b').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda4b').addClass('text-danger');                  
        } 
        else {
            var ch2 = max - palabras.filter(Boolean).length;
            $('#mensaje_ayuda4b').text(ch2 + ' palabras restantes');
            $('#mensaje_ayuda4b').removeClass('text-danger');
            actualizardatos($(this).val(), "pregunta9", "etapa3", 0, 0, 0);

        }
    });
    function agregarhito(tipo, id, titulo, fecini, fecter, desc)
    {
        if(tipo == 'agregar')
        {
            $( "#staticBackdropLabel" ).html("Agregar Hito Carta GANTT");
            $( "#modalbody" ).html(`<div class="form-group">
                                    <label for="nomhito">
                                        <b>HITO</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el nombre al hito" data-html="true"></i>
                                    </label>
                                    <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese el nombre al hito" id="nomhito" name="nomhito" rows="30" >${titulo}</textarea>
                                    <small id="errornomhito" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <label for="fechainicio">
                                        <b>Fecha de Inicio</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la fecha de inicio al hito" data-html="true"></i>
                                    </label>
                                    <input type="date" class="form-control" name="fechainicio" id="fechainicio" value="${fecini}">
                                    <small id="errorfechainicio" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <label for="fechatermino">
                                        <b>Fecha de Término</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la fecha de término al hito" data-html="true"></i>
                                    </label>
                                    <input type="date" class="form-control" name="fechatermino" id="fechatermino" value="${fecter}">
                                    <small id="errorfechatermino" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">
                                        <b>{{ trans('multi-leng.formerror26')}}</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la descripción del hito ingresado" data-html="true"></i>
                                    </label>
                                    <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese la descripción al hito" id="descripcion" name="descripcion" rows="30" >${desc}</textarea>
                                    <small id="errordescripcion" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success btn-sm" id="editarhito">Agregar Hito</button>
                                    <input type="hidden" id="idgantt" name="idgantt" value="${id}">
                                    <input type="hidden" id="tipogantt" name="tipogantt" value="gantt">
                                </div>`);
        }
        if(tipo == 'editar')
        {
            $( "#staticBackdropLabel" ).html("Editar Hito Carta GANTT");
            $( "#modalbody" ).html(`<div class="form-group">
                                    <label for="nomhito">
                                        <b>HITO</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el nombre al hito" data-html="true"></i>
                                    </label>
                                    <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese el nombre al hito" id="nomhito" name="nomhito" rows="30" >${titulo}</textarea>
                                    <small id="errornomhito" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <label for="fechainicio">
                                        <b>Fecha de Inicio</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la fecha de inicio al hito" data-html="true"></i>
                                    </label>
                                    <input type="date" class="form-control" name="fechainicio" id="fechainicio" value="${fecini}">
                                    <small id="errorfechainicio" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <label for="fechatermino">
                                        <b>Fecha de Término</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la fecha de término al hito" data-html="true"></i>
                                    </label>
                                    <input type="date" class="form-control" name="fechatermino" id="fechatermino" value="${fecter}">
                                    <small id="errorfechatermino" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">
                                        <b>{{ trans('multi-leng.formerror26')}}</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la descripción del hito ingresado" data-html="true"></i>
                                    </label>
                                    <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese la descripción al hito" id="descripcion" name="descripcion" rows="30" >${desc}</textarea>
                                    <small id="errordescripcion" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-warning btn-sm" id="editarhito">Editar Hito</button>
                                    <input type="hidden" id="idgantt" name="idgantt" value="${id}">
                                    <input type="hidden" id="tipogantt" name="tipogantt" value="editargantt">
                                </div>`);
        }
        if(tipo == 'eliminar')
        {
            $( "#staticBackdropLabel" ).html("Eliminar Hito Carta GANTT");
            $( "#modalbody" ).html(`<div class="form-group">
                                    <label for="nomhito">
                                        <b>HITO</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el nombre al hito" data-html="true"></i>
                                    </label>
                                    <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese el nombre al hito" id="nomhito" name="nomhito" rows="30" disabled>${titulo}</textarea>
                                    <small id="errornomhito" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <label for="fechainicio">
                                        <b>Fecha de Inicio</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la fecha de inicio al hito" data-html="true"></i>
                                    </label>
                                    <input type="date" class="form-control" name="fechainicio" id="fechainicio" value="${fecini}" disabled>
                                    <small id="errorfechainicio" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <label for="fechatermino">
                                        <b>Fecha de Término</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la fecha de término al hito" data-html="true"></i>
                                    </label>
                                    <input type="date" class="form-control" name="fechatermino" id="fechatermino" value="${fecter}" disabled>
                                    <small id="errorfechatermino" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">
                                        <b>{{ trans('multi-leng.formerror26')}}</b> 
                                        <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;
                                        <i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la descripción del hito ingresado" data-html="true"></i>
                                    </label>
                                    <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese la descripción al hito" id="descripcion" name="descripcion" rows="30" disabled>${desc}</textarea>
                                    <small id="errordescripcion" style="color:red"></small>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger btn-sm" id="eliminarhito">Eliminar Hito</button>
                                    <input type="hidden" id="idgantt" name="idgantt" value="${id}">
                                    <input type="hidden" id="tipogantt" name="tipogantt" value="eliminargantt">
                                </div>`);
        }
        
        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
        $( "#staticBackdrop" ).modal('show');
        
    }
    function addcat()
    {
        $( "#staticBackdropLabel" ).html("{{ trans('multi-leng.a24')}}");
        $( "#modalbody" ).html('<div class="form-group"><label for="namecat"><b>{{ trans('multi-leng.formerror26')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __("multi-leng.a36") }}" data-html="true"></i></label><input type="text" class="form-control" name="textdocs" id="textdocs" maxlength="20"><small id="errortextfile" style="color:red"></small></div><div class="form-group"><label for="namecat"><b>{{ trans('multi-leng.a23')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __("multi-leng.a114") }}" data-html="true"></i></label><input type="file" class="form-control" name="docs" id="docs" accept=".png, .jpg, .jpeg, .pdf, .xlsx"><small id="errorfile" style="color:red"></small></div>');
        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
        $( "#staticBackdrop" ).modal('show');
        
    }

    $("#staticBackdrop").on('show.bs.modal', function() { 
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $("#agregarhito").click(function(event){
            
            $(this).prop( 'disabled', true );
            var error = "";
            $("#errornomhito").html('');
            $("#errorfechainicio").html('');
            $("#errorfechatermino").html('');
            $("#errordescripcion").html('');
            if($.trim($("#nomhito").val()).length < 2)
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errornomhito").html('Ingrese el nombre del hito');
            }
            if($.trim($("#fechainicio").val()).length == 0)
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errorfechainicio").html('Ingrese la fecha de inicio del hito');
            }
            if($.trim($("#fechatermino").val()).length == 0)
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errorfechatermino").html('Ingrese la fecha de termino del hito');
            }
            const fechaMoment = moment($("#fechainicio").val(), 'YYYY-MM-DD', true);
            if (!fechaMoment.isValid()) 
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errorfechainicio").html('Ingrese la fecha de inicio válida del hito');
            }
            const fechaMoment1 = moment($("#fechatermino").val(), 'YYYY-MM-DD', true);
            if (!fechaMoment1.isValid()) 
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errorfechatermino").html('Ingrese la fecha de término válida del hito');
            }
            if($.trim($("#descripcion").val()).length < 2)
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errordescripcion").html('Ingrese la descripción del hito');
            }

            if(error != "")
            {
                
                event.preventDefault();
                return false;
            }
            else
            {
                $(this).prop( 'disabled', false );
                actualizardatos($.trim($("#nomhito").val()), $.trim($("#fechainicio").val()), $.trim($("#fechatermino").val()), "gantt", $.trim($("#descripcion").val()), '');
            }
            
        });
        $("#editarhito").click(function(event){
            
            $(this).prop( 'disabled', true );
            var error = "";
            $("#errornomhito").html('');
            $("#errorfechainicio").html('');
            $("#errorfechatermino").html('');
            $("#errordescripcion").html('');
            if($.trim($("#nomhito").val()).length < 2)
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errornomhito").html('Ingrese el nombre del hito');
            }
            if($.trim($("#fechainicio").val()).length == 0)
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errorfechainicio").html('Ingrese la fecha de inicio del hito');
            }
            if($.trim($("#fechatermino").val()).length == 0)
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errorfechatermino").html('Ingrese la fecha de termino del hito');
            }
            const fechaMoment = moment($("#fechainicio").val(), 'YYYY-MM-DD', true);
            if (!fechaMoment.isValid()) 
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errorfechainicio").html('Ingrese la fecha de inicio válida del hito');
            }
            const fechaMoment1 = moment($("#fechatermino").val(), 'YYYY-MM-DD', true);
            if (!fechaMoment1.isValid()) 
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errorfechatermino").html('Ingrese la fecha de término válida del hito');
            }
            if($.trim($("#descripcion").val()).length < 2)
            {
                $(this).prop( 'disabled', false );
                error += "{{ __('multi-leng.formerror39') }}<br>";
                $("#errordescripcion").html('Ingrese la descripción del hito');
            }

            if(error != "")
            {
                
                event.preventDefault();
                return false;
            }
            else
            {
                $(this).prop( 'disabled', true );
                actualizardatos(`${$.trim($("#nomhito").val())}`, `${$.trim($("#fechainicio").val())}`, `${$.trim($("#fechatermino").val())}`, `${$.trim($("#tipogantt").val())}`, `${$.trim($("#descripcion").val())}`, `${$("#idgantt").val()}`);
            }
            
        });
        $("#eliminarhito").click(function(event){
            
            $(this).prop( 'disabled', true );
            actualizardatos(`${$.trim($("#nomhito").val())}`, `${$.trim($("#fechainicio").val())}`, `${$.trim($("#fechatermino").val())}`, "eliminargantt", `${$.trim($("#descripcion").val())}`, `${$("#idgantt").val()}`);
            
        });
    });
    
    
    function senddelete(id, name)
    {
        $( "#staticBackdropLabel" ).html("{{ trans('lang.eliminar')}}");
        $( "#modalbody" ).html(`<div class="form-group"><label for="namecat"><b>{{ trans('multi-leng.formerror9')}}</b></label><input type="text" class="form-control" name="deldocs" id="deldocs" value="${name}" readonly><button type="button" class="btn btn-danger btn-sm" onclick="validardelete(${id}, '${name}')">{{ trans('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button></div>`);
        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
        $( "#staticBackdrop" ).modal('show');
    }
    function validardelete(id, nombre)
    {
        actualizardatos(id, nombre, "delete", 0, 0, 0);
    }

    function actualizardatos(val, col, type, tipo, data, data1)
    {
        var table = new DataTable('#tabla2');
        var html = "";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = new FormData();
        formData.append("idconc", $("#idconc").val());
        formData.append("idpost", $("#idpost").val());
        formData.append("idetapa", $("#idetapa").val());
        formData.append("value", val);
        formData.append("col", col); 
        formData.append("type", type);
        formData.append("tipo", tipo);
        formData.append("data", data);
        formData.append("data1", data1);
        $.ajax({
            type: "POST",
            url: '{{route("actualizar.formulario.postulacion.docente.etapa.uno.nuevo.formulario")}}',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(respu)
            {
                if(tipo == "validar3")
                {
                    window.location.reload();
                }
                if(tipo == "editargantt")
                {
                    table.destroy();
                    $( "#tbodytable2" ).html('');
                    for (let key in respu.array) 
                    {
                        html += `<tr>
                                    <th class="text-justify">${respu.array[key].titulo}</th>
                                    <th>${respu.array[key].fechatablaini}</th>
                                    <th>${respu.array[key].fechatablater}</th>
                                    <th class="text-justify">${respu.array[key].descripcion}</th>
                                    <th>
                                        <button type="button" class="btn btn-warning btn-sm btn-block mb-1" onclick='agregarhito("editar", "${respu.array[key].id}", "${respu.array[key].titulo}", "${respu.array[key].fechainicio}", "${respu.array[key].fechatermino}", "${respu.array[key].descripcion}");'>Editar Hito</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick='agregarhito("eliminar", "${respu.array[key].id}", "${respu.array[key].titulo}", "${respu.array[key].fechainicio}", "${respu.array[key].fechatermino}", "${respu.array[key].descripcion}");'>Eliminar Hito</button>
                                    </th>
                                </tr>`;
                    }
                    $( "#tbodytable2" ).html(`${html}`);
                    $('#tabla2').DataTable({
                        //"dom": 'lfrtip'
                        "dom": 'frtip', 
                        fixedHeader: true,
                        responsive: true,      
                        "order": [[ 1, "desc" ]],
                        "language": {
                            "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                        }
                    });
                    $( "#staticBackdrop" ).modal('hide');
                }
                if(tipo == "eliminargantt")
                {
                    window.location.reload();
                }
                if(tipo == "gantt")
                {
                    table.destroy();
                    $( "#tbodytable2" ).html('');
                    for (let key in respu.array) 
                    {
                        html += `<tr>
                                    <th class="text-justify">${respu.array[key].titulo}</th>
                                    <th>${respu.array[key].fechatablaini}</th>
                                    <th>${respu.array[key].fechatablater}</th>
                                    <th class="text-justify">${respu.array[key].descripcion}</th>
                                    <th>
                                        <button type="button" class="btn btn-warning btn-sm btn-block mb-1" onclick='agregarhito("editar", "${respu.array[key].id}", "${respu.array[key].titulo}", "${respu.array[key].fechainicio}", "${respu.array[key].fechatermino}", "${respu.array[key].descripcion}");'>Editar Hito</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick='agregarhito("eliminar", "${respu.array[key].id}", "${respu.array[key].titulo}", "${respu.array[key].fechainicio}", "${respu.array[key].fechatermino}", "${respu.array[key].descripcion}");'>Eliminar Hito</button>
                                    </th>
                                </tr>`;
                    }
                    $( "#tbodytable2" ).html(`${html}`);
                    $('#tabla2').DataTable({
                        //"dom": 'lfrtip'
                        "dom": 'frtip', 
                        fixedHeader: true,
                        responsive: true,      
                        "order": [[ 1, "desc" ]],
                        "language": {
                            "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                        }
                    });
                    $( "#staticBackdrop" ).modal('hide');
                }
                
            }
        });
    }
    $(document).on('click','#validardatos',function(e){
        
        let error = "";

        if($.trim($("#indicadores").val()).length <= 2)
        {
            error += "<strong>Igrese los Indicadores</strong><br>";
        }
        if($.trim($("#resultados").val()).length <= 2)
        {
            error += "<strong>Ingrese los Resultados</strong><br>";
        }
        if($.trim($("#impacto").val()).length <= 2)
        {
            error += "<strong>Ingrese el Impacto</strong><br>";
        }
        if($.trim($("#institucional").val()).length <= 2)
        {
            error += "<strong>Ingrese el Impacto</strong><br>";
        }
        if($('#tbodytable2 tr').length == 0)
        {
            error += "<strong>Ingrese las actividades de la Carta Gantt</strong><br>";
        }
        if(error != "")
        {
            $('#staticBackdropLabel').html('{{ trans('multi-leng.a163')}}');
            $('#modalbody').html(`{{ trans('multi-leng.a161')}} <br>${error}`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else
        {
           
            actualizardatos(1, 0, "validar3", "validar3", 0, $('#tbodytable2 tr').length);
        }
        
    });
    
</script>
@endsection
