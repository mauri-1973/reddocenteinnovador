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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 alert alert-white bg-white" {{ trans('multi-leng.a177')}}" role="alert" id="alert">
                    <h4 class="alert-heading text-dark">{{ trans('multi-leng.formerror46')}}:</h4>
                    <p class="text-dark" style="font-size:16px;">{{ trans('multi-leng.a177')}}</p>
                    <hr>
                    <p style="font-size:16px;" class="mb-0 text-dark">{{ trans('multi-leng.a178')}}</p>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card mb-4 bg-white shadow-sm">
                        <div class="card-body">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-dark">
                                        <h4>{{ trans('multi-leng.a201') }} <strong class="statusval text-dark">{{ ($finalstus->statuset1 == 1) ? trans('multi-leng.a197') : trans('multi-leng.a198') }}</strong></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1">
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
                                            <input class="form-control input-lg text-dark" id="titulo" name="titulo" type="text" minlength="2" maxlength="70" value="{{ $finalstus->titulo }}" placeholder="{{ trans('multi-leng.a150')}}" required>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda1" class="help-block"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="fechaingreso" class="textlabel text-dark"><b>1.2.- Fecha</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la fecha de presentación del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="fechaingreso" name="fechaingreso" type="date" minlength="8" maxlength="10" value="{{ $finalstus->fecha }}" placeholder="Ingrese la Fecha, formato dd/mm/yyyy" required>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda2" class="help-block text-dark"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="facultades" class="textlabel text-dark"><b>1.3.- Facultad Lider</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la Facultad a la que pertenece el lider del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <br>
                                            <label for="facultades" class="textlabel text-dark"><b>Facultades Participantes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la(s) Facultad(es) a la que pertenece(n) el(los) paticipante(es) del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese la Facultad a la que pertenece el lider y los participantes del proyecto" id="facultades" name="facultades" rows="15" maxlength="250">{{ $finalstus->facultades }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda3" class="help-block text-dark"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="carreras" class="textlabel text-dark"><b>1.4.- Carrera Lider</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la Carrera a la que pertenece el lider del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <br>
                                            <label for="carreras" class="textlabel text-dark"><b>Carreras Participantes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la(s) Carrera(s) a la que pertenece(n) el(los) paticipante(es) del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese la Carrera a la que pertenece el lider y los participantes del proyecto" id="carreras" name="carreras" rows="15" maxlength="250">{{ $finalstus->carreras }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda4" class="help-block text-dark"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="sedes" class="textlabel text-dark"><b>1.5.- Sede Lider</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la Sede a la que pertenece el lider del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <br>
                                            <label for="sedes" class="textlabel text-dark"><b>Sedes Participantes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese la(s) Sede(s) a la que pertenece(n) el(los) paticipante(es) del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese la Sede a la que pertenece el lider y los participantes del proyecto" id="sedes" name="sedes" rows="15" maxlength="500">{{ $finalstus->sedes }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda5" class="help-block text-dark"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="nombredoc" class="textlabel text-dark"><b>1.6.- Nombre del (la) docente Director (a) del Proyecto</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el Nombre del (la) docente Director (a) del Proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="nombredoc" name="nombredoc" type="text" minlength="2" maxlength="70" value="{{ $finalstus->nombredoc }}" placeholder="Ingrese el Nombre del (la) docente Director (a) del Proyecto" required>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda6" class="help-block text-dark"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="directoralt" class="textlabel text-dark"><b>1.7.- Nombre del Director Alterno</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el Nombre del Director Alterno" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="directoralt" name="directoralt" type="text" minlength="2" maxlength="70" value="{{ $finalstus->directoralt }}" placeholder="Ingrese el Nombre del Director Alterno" required>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda7" class="help-block text-dark"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="equipodoc" class="textlabel text-dark"><b>1.8.- Equipo Docente</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el equipo docente inserto al proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese el equipo docente, incluido al proyecto" id="equipodoc" name="equipodoc" rows="15" maxlength="250">{{ $finalstus->equipodoc }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda8" class="help-block text-dark"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        
                                        <div class="author text-dark mb-3">
                                            <h5>2.- Cobertura</h5>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="numeropar" class="textlabel text-dark"><b>2.1.- Número de Participantes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el número de participantes del proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="numeropar" name="numeropar" type="text" minlength="1" maxlength="2" value="{{ $finalstus->numeropar }}" placeholder="Ingrese el número de participantes del proyecto" onkeypress="return valideKey(event);" required>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda9" class="help-block text-dark"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="numdoc" class="textlabel text-dark"><b>2.2.- Número de Docentes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el número de docentes que participan en el proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="numdoc" name="numdoc" type="text" minlength="1" maxlength="2" value="{{ $finalstus->numdoc }}" placeholder="Ingrese el número de docentes" onkeypress="return valideKey(event);" required>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda9" class="help-block text-dark"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="numest" class="textlabel text-dark"><b>2.3.- Número de Estudiantes</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el número de estudiantes que participan en el proyecto" data-html="true"></i>&nbsp; <small style="color:black;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <input class="form-control input-lg text-dark" id="numest" name="numest" type="text" minlength="1" maxlength="2" value="{{ $finalstus->numest }}" placeholder="Ingrese el número de estudiantes" onkeypress="return valideKey(event);" required>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda10" class="help-block text-dark"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <div class="container-fluid">
                                                <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                            <button type="button" id="validardatos" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a87')}} {{ trans('multi-leng.a134')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el número de estudiantes que participan en el proyecto" data-html="true"></i></button>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                            <a href="{{ route('buscar.concursos.registrados.docentes.fase.dos' ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el número de estudiantes que participan en el proyecto" data-html="true"></i></a>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                            <a href="{{ route('ver.nuevo.formulario.docente.segunda.etapa', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a88')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese el número de estudiantes que participan en el proyecto" data-html="true"></i></a>
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card mb-4 bg-white shadow-sm">
                        <div class="card-body">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-dark">
                                        <h4>{{ trans('multi-leng.a201') }} <strong class="statusval">{{ ($finalstus->statuset1 == 1) ? trans('multi-leng.a197') : trans('multi-leng.a198') }}</strong></h4>
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

        function ocultar() {
            $('#alert').css('display', 'none');
        }
        setTimeout(ocultar, 13000);
        $('#alert').focus();

        $('#titulo').trigger('keyup');
        $('#nombredoc').trigger('keyup');
        $('#directoralt').trigger('keyup');
        $('#facultades').trigger('keyup'); 
        $('#carreras').trigger('keyup'); 
        $('#sedes').trigger('keyup'); 
        $('#equipodoc').trigger('keyup'); 
    });
    
    $('#titulo').keyup(function () {
        var max = 70;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda1').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda1').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda1').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda1').removeClass('text-danger');
            actualizardatos($(this).val(), "titulo", "etapa1", 0, 0, 0);

        }
    });
    $('#fechaingreso').change(function () {
        const fechaMoment = moment($(this).val(), 'YYYY-MM-DD', true);
        console.log($(this).val());
        if (fechaMoment.isValid()) 
        {
            actualizardatos($(this).val(), "fecha", "etapa1", 0, 0, 0);
        }
        
    });
    
    $('#facultades').keyup(function () {
        var max = 250;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda3').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda3').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda3').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda3').removeClass('text-danger');
            actualizardatos($(this).val(), "facultades", "etapa1", 0, 0, 0);

        }
    });
    
    $('#carreras').keyup(function () {
        var max = 250;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda4').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda4').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda4').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda4').removeClass('text-danger');
            actualizardatos($(this).val(), "carreras", "etapa1", 0, 0, 0);

        }
    });
    
    $('#sedes').keyup(function () {
        var max = 250;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda5').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda5').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda5').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda5').removeClass('text-danger');
            actualizardatos($(this).val(), "sedes", "etapa1", 0, 0, 0);

        }
    });
    $('#nombredoc').keyup(function () {
        var max = 70;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda6').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda6').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda6').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda6').removeClass('text-danger');
            actualizardatos($(this).val(), "nombredoc", "etapa1", 0, 0, 0);

        }
    });
    $('#directoralt').keyup(function () {
        var max = 70;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda7').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda7').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda7').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda7').removeClass('text-danger');
            actualizardatos($(this).val(), "directoralt", "etapa1", 0, 0, 0);

        }
    });
    $('#equipodoc').keyup(function () {
        var max = 250;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda8').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda8').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda8').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda8').removeClass('text-danger');
            actualizardatos($(this).val(), "equipodoc", "etapa1", 0, 0, 0);

        }
    });
    
    $('#numeropar').keyup(function () {

        
        if(!isNaN(+$(this).val()) && $(this).val() !== '')
        {
            
            actualizardatos($(this).val(), "numeropar", "etapa1", 0, 0, 0);
        }
    });
    $('#numdoc').keyup(function () {

        if(!isNaN(+$(this).val()) && $(this).val() !== '')
        {
            
            actualizardatos($(this).val(), "numdoc", "etapa1", 0, 0, 0);
        }
    });
    $('#numest').keyup(function () {

        if(!isNaN(+$(this).val()) && $(this).val() !== '')
        {
            
            actualizardatos($(this).val(), "numest", "etapa1", 0, 0, 0);
        }
    });
    
    $("#staticBackdrop").on('show.bs.modal', function() { 
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        
        
    });
    
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
    function valideKey(evt)
    {
        var code = (evt.which) ? evt.which : evt.keyCode;
    
        if(code==8) 
        { 
            return true;
        }
        else if(code==45) 
        {
            return true;
        }
        else if(code == 107) 
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

    function actualizardatos(val, col, type, tipo, data, data1)
    {
        
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
                if(type == "validar1")
                {
                    window.location.reload(); 
                }
                console.log(respu);
                
            }
        });
    }
    $(document).on('click','#validardatos',function(e){
        let error = "";
        
        if($.trim($("#titulo").val()).length <= 2)
        {
            error += "<strong>Ingrese el título del proyecto.</strong><br>";
        }
        const fechaMoment = moment($.trim($("#fechaingreso").val()), 'YYYY-MM-DD', true);

        if (!fechaMoment.isValid()) 
        {
            error += "<strong>Ingrese una fecha válida par el ingreso del proyecto.</strong><br>";
        }

        if($.trim($("#facultades").val()).length <= 2)
        {
            error += "<strong>Ingrese las facultades</strong><br>";
        }

        if($.trim($("#carreras").val()).length <= 2)
        {
            error += "<strong>Ingrese las carreras.</strong><br>";
        }
        
        if($.trim($("#sedes").val()).length <= 2)
        {
            error += "<strong>Ingrese las sedes.</strong><br>";
        }

        if($.trim($("#nombredoc").val()).length <= 2)
        {
            error += "<strong>Ingrese el nombre del (la) docente Director (a) del Proyecto.</strong><br>";
        }

        if($.trim($("#directoralt").val()).length <= 2)
        {
            error += "<strong>Ingrese el nombre del Director Alterno.</strong><br>";
        }

        if($.trim($("#equipodoc").val()).length <= 2)
        {
            error += "<strong>Ingrese el equipo docente.</strong><br>";
        }

        if($.trim($("#numeropar").val()).length == 0 || $("#numeropar").val() <= 0)
        {
            error += "<strong>Ingrese el número de participantes.</strong><br>";
        }

        if($.trim($("#numdoc").val()).length == 0 || $("#numdoc").val() <= 0)
        {
            error += "<strong>Ingrese el número de docentes.</strong><br>";
        }

        if($.trim($("#numest").val()).length == 0 || $("#numest").val() <= 0)
        {
            error += "<strong>Ingrese el número de estudiantes.</strong><br>";
        }
        if(error != "")
        {
            $('#staticBackdropLabel').html('{{ trans('multi-leng.a139')}}');
            $('#modalbody').html(`{{ trans('multi-leng.a138')}} <br>${error}`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else
        {
            actualizardatos(1, 0, "validar1", "validar1", 0, 0);
        }
        
    });
    
</script>
@endsection
