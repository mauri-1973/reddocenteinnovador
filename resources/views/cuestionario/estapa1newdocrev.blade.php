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
        font-size:16px !important;
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
                @if($rubrica == 0)
                <div class="col-md-12">
                    <div class="card mb-4 bg-white shadow-sm">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <a href="{{ route('imprimr.formulario.docente.fase.dos', $idpostulacion) }}" role="button" id="imprimir" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a204')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <a href="{{ route('ver.postulaciones.activas.docentes.fase.dos' ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <a href="#" class="btn btn-primary btn-sm btn-block" disabled>{{ trans('inst.139')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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
                <div class="col-md-12 mb-1">
                    <div class="card mb-4 bg-white shadow-sm">
                        <div class="card-body">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="author text-dark mb-3">
                                            <h5>1.- Antecedentes Generales</h5>
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="titulo" class="textlabel text-dark"><b>1.1.- Título del Proyecto</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.caracteresname') }}" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="titulo" name="titulo" type="text" minlength="2" maxlength="70" value="{{ $finalstus->titulo }}" placeholder="{{ trans('multi-leng.a150')}}" disabled>
                                            <br>
                                            <label for="obspreg1" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg1" name="obspreg1" rows="15" maxlength="250" disabled>{{ $obs->obspreg1 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda1" class="help-block"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="fechaingreso" class="textlabel text-dark"><b>1.2.- Fecha</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la fecha de presentación del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="fechaingreso" name="fechaingreso" type="date" minlength="8" maxlength="10" value="{{ $finalstus->fecha }}" placeholder="Ingrese la Fecha, formato dd/mm/yyyy" disabled>
                                            <br>
                                            <label for="obspreg2" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg2" name="obspreg2" rows="15" maxlength="250" disabled>{{ $obs->obspreg2 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda2" class="help-block"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="facultades" class="textlabel text-dark"><b>1.3.- Facultad Lider</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la Facultad a la que pertenece el lider del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <br>
                                            <label for="facultades" class="textlabel text-dark"><b>Facultades Participantes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la(s) Facultad(es) a la que pertenece(n) el(los) paticipante(es) del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese la Facultad a la que pertenece el lider y los participantes del proyecto" id="facultades" name="facultades" rows="15" maxlength="250" disabled>{{ $finalstus->facultades }}</textarea>
                                            <br>
                                            <label for="obspreg3" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg3" name="obspreg3" rows="15" maxlength="250" disabled>{{ $obs->obspreg3 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda3" class="help-block"></p>
                                            </span>
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="carreras" class="textlabel text-dark"><b>1.4.- Carrera Lider</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la Carrera a la que pertenece el lider del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <br>
                                            <label for="carreras" class="textlabel text-dark"><b>Carreras Participantes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la(s) Carrera(s) a la que pertenece(n) el(los) paticipante(es) del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese la Carrera a la que pertenece el lider y los participantes del proyecto" id="carreras" name="carreras" rows="15" maxlength="250" disabled>{{ $finalstus->carreras }}</textarea>
                                            <br>
                                            <label for="obspreg4" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg4" name="obspreg4" rows="15" maxlength="250" disabled>{{ $obs->obspreg4 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda4" class="help-block"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="sedes" class="textlabel text-dark"><b>1.5.- Sede Lider</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la Sede a la que pertenece el lider del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <br>
                                            <label for="sedes" class="textlabel text-dark"><b>Sedes Participantes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la(s) Sede(s) a la que pertenece(n) el(los) paticipante(es) del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese la Sede a la que pertenece el lider y los participantes del proyecto" id="sedes" name="sedes" rows="15" maxlength="500" disabled>{{ $finalstus->sedes }}</textarea>
                                            <br>
                                            <label for="obspreg5" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg5" name="obspreg5" rows="15" maxlength="250" disabled>{{ $obs->obspreg5 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda5" class="help-block"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="nombredoc" class="textlabel text-dark"><b>1.6.- Nombre del (la) docente Director (a) del Proyecto</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el Nombre del (la) docente Director (a) del Proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="nombredoc" name="nombredoc" type="text" minlength="2" maxlength="70" value="{{ $finalstus->nombredoc }}" placeholder="Ingrese el Nombre del (la) docente Director (a) del Proyecto" disabled>
                                            <br>
                                            <label for="obspreg6" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg6" name="obspreg6" rows="15" maxlength="250" disabled>{{ $obs->obspreg6 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda6" class="help-block"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="directoralt" class="textlabel text-dark"><b>1.7.- Nombre del Director Alterno</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el Nombre del Director Alterno" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="directoralt" name="directoralt" type="text" minlength="2" maxlength="70" value="{{ $finalstus->directoralt }}" placeholder="Ingrese el Nombre del Director Alterno" disabled>
                                            <br>
                                            <label for="obspreg7" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg7" name="obspreg7" rows="15" maxlength="250" disabled>{{ $obs->obspreg7 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda7" class="help-block"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="equipodoc" class="textlabel text-dark"><b>1.8.- Equipo Docente</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el equipo docente inserto al proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese el equipo docente, incluido al proyecto" id="equipodoc" name="equipodoc" rows="15" maxlength="250" disabled>{{ $finalstus->equipodoc }}</textarea>
                                            <br>
                                            <label for="obspreg8" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg8" name="obspreg8" rows="15" maxlength="250" disabled>{{ $obs->obspreg8 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda8" class="help-block"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">
                                        
                                        <div class="author text-dark mb-3">
                                            <h5>2.- Cobertura</h5>
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="numeropar" class="textlabel text-dark"><b>2.1.- Número de Participantes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el número de participantes del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="numeropar" name="numeropar" type="text" minlength="1" maxlength="2" value="{{ $finalstus->numeropar }}" placeholder="Ingrese el número de participantes del proyecto" onkeypress="return valideKey(event);" disabled>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda9" class="help-block text-dark"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="numdoc" class="textlabel text-dark"><b>2.2.- Número de Docentes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el número de docentes que participan en el proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="numdoc" name="numdoc" type="text" minlength="1" maxlength="2" value="{{ $finalstus->numdoc }}" placeholder="Ingrese el número de docentes" onkeypress="return valideKey(event);" disabled>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda9" class="help-block text-dark"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="numest" class="textlabel text-dark"><b>2.3.- Número de Estudiantes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el número de estudiantes que participan en el proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="numest" name="numest" type="text" minlength="1" maxlength="2" value="{{ $finalstus->numest }}" placeholder="Ingrese el número de estudiantes" onkeypress="return valideKey(event);" disabled>
                                            <br>
                                            <label for="obspreg9" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg9" name="obspreg9" rows="15" maxlength="250" disabled>{{ $obs->obspreg9 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda9" class="help-block"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="{{ route('imprimr.formulario.docente.fase.dos', $idpostulacion) }}" role="button" id="imprimir" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a204')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="{{ route('ver.postulaciones.activas.docentes.fase.dos' ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="{{ route('ver.nuevo.formulario.docente.segunda.etapa', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a88')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border-top: 3px solid #fff;">
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
<script type="text/javascript">
    
    $(document).ready(function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    });
    
</script>
@endsection
