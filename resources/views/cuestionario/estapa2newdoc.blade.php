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
</style>
@endsection
@section('index')
<div class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            
            <div class="row justify-content-center mt-4">
                <div class="alert bg-white" {{ trans('multi-leng.a177')}}" role="alert" id="alert">
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
                                        <h4 class="text-dark">{{ trans('multi-leng.a200') }} <strong class="statusval">{{ ($finalstus->statuset2 == 1) ? trans('multi-leng.a197') : trans('multi-leng.a198') }}</strong></h4>
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
                                        <div class="author text-dark mb-5">
                                            <h3 class="text-dark">{{ trans('multi-leng.a42')}}</h3>
                                        </div>
                                        <div class="author text-white mb-3">
                                            <h5 class="text-dark">3.- Antecedentes </h5>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="preg1a" class="textlabel text-dark"><b>3.1.- Fundamentación del proyecto (máximo 400 palabras). Incluya tres acciones de sustentabilidad en el tiempo, dos aspectos del modelo educativo UST, dos aspectos de la unidad académica (escuela, carrera, facultad)</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a95') }}" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Máximo 400 palabras" id="preg1a" name="preg1a" rows="30" >{{ $finalstus->pregunta1 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda1" class="help-block" style="color:#000;"></p>
                                            </span>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="preg2a" class="textlabel text-dark"><b>3.2.- Proyecto (s) anterior(es) Adjuntar tres o más evidencias cuantitativas y/o cualitativas (anexar informes finales del proceso anterior o fase 1) y datos (máximo 400 palabras)</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a97') }}" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <hr style="border-top: 2px solid #000;">
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tabla2">
                                                <caption class="text-white bg-success pl-2" style="font-size:16px;">{{ __('inst.71') }} &nbsp; 
                                                    <button type="button" class="btn btn-warning btn-sm" style="font-size:12px;" onclick="addcat(1);">{{ __('inst.72') }}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Formatos permitidos: .docx, .pdf, .xlsx, .png, .jpeg, .jpg" data-html="true"></i></button>&nbsp;<strong>({{ __('inst.70') }}).</strong>
                                                </caption>
                                                <thead>
                                                    <tr>
                                                        
                                                        <th>{{ trans('multi-leng.a20')}}</th>
                                                        <th>{{ trans('multi-leng.formerror79')}}</th>
                                                        <th>{{ trans('multi-leng.formerror22')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodytable2">
                                                    @foreach($files as $file)
                                                    <tr>
                                                        
                                                        <td> {{ $file->dirfile }} </td>
                                                        <td> {{ $file->descripcion}} </td>
                                                        <td>
                                                            <button type='button' class='btn btn-danger btn-sm btn-block deletefile mb-1' onclick='senddelete({{ $file->idfile }}, "{{ $file->dirfile }}")'>{{__('multi-leng.a38')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button><a class='btn btn-success btn-sm btn-block' href='{{url('/')}}/storage/adjuntos/docentes/{{ $file->dirfile }}' role='button' download='{{ $file->dirfile }}'>{{__('multi-leng.a39')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    
                                                </tbody>
                                            </table>
                                            <textarea class="form-control input-lg textarea1 text-dark mt-4" placeholder="Máximo 400 palabras" id="preg2a" name="preg2a" rows="30">{{ $finalstus->pregunta2 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda2" class="help-block" style="color:#000;"></p>
                                            </span>
                                            
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="preg3a" class="textlabel text-dark"><b>3.3.- Objetivo general y específicos: pertinentes, coherentes, lógicos. Consideran el escalamiento.</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a99') }}" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Máximo 400 palabras" id="preg3a" id="preg3a" rows="30">{{ $finalstus->pregunta3 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda3" class="help-block" style="color:#000;"></p>
                                            </span>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="author text-white mb-3">
                                            <br>
                                            <h5 class="text-dark">4.- Metodología </h5>
                                            <br>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="preg4a" class="textlabel text-dark"><b>4.1.- Fundamente la teoría educativa que sustenta la metodología del aprendizaje, el tipo de tecnología y su uso pedagógico (máximo 400 palabras)</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a101') }}" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Máximo 400 palabras" id="preg4a" name="preg4a" rows="30">{{ $finalstus->pregunta4 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda4" class="help-block" style="color:#000;"></p>
                                            </span>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="preg5a" class="textlabel text-dark"><b>4.2.-Cómo se fomenta la participación e interacción de los estudiantes. Indica de forma precisa la equidad de género y el apoyo para estudiantes con discapacidad y neurodivergentes.(máximo 300 palabras)</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a103') }}" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Máximo 300 palabras" id="preg5a" id="preg5a" rows="30">{{ $finalstus->pregunta5 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda5" class="help-block" style="color:#000;"></p>
                                            </span>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <div class="container-fluid">
                                                <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <a href="{{ route('ver.nuevo.formulario.docente.primera.etapa', $idpostulacion )  }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a104')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <button type="button" id="validardatos" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a87')}} {{ trans('multi-leng.a149')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <a href="{{ route('buscar.concursos.registrados.docentes.fase.dos' ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <a href="{{ route('ver.nuevo.formulario.docente.tercera.etapa', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a88')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a> 
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
                                        <h4 class="text-dark">{{ trans('multi-leng.a200') }} <strong class="statusval">{{ ($finalstus->statuset2 == 1) ? trans('multi-leng.a197') : trans('multi-leng.a198') }}</strong></h4>
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
<input type="hidden" id="idetapa" name="idestapa" value="{{ Crypt::encrypt($finalstus->id) }}">
@endsection

@section('extra-script')
<script type="text/javascript">
    
    $(document).ready(function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $('#alert').focus(); 
        
        setTimeout(ocultar, 13000);
        
        
        $('#preg1a').trigger('keyup'); 
        $('#preg2a').trigger('keyup'); 
        $('#preg3a').trigger('keyup'); 
        $('#preg4a').trigger('keyup'); 
        $('#preg5a').trigger('keyup');
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
    });
    function ocultar() {
            $('#alert').css('display', 'none');
        }
    $('#preg1a').keyup(function () {
        var max = 400;
        const texto = this.value.trim(); // Eliminar espacios en blanco al inicio y al final
        const palabras = texto.length > 0 ? texto.split(/\s+/) : [];
        if (palabras.filter(Boolean).length > max) {
            this.value = palabras.slice(0, max).join(' ');
            $('#mensaje_ayuda1').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda1').addClass('text-danger');                  
        } 
        else {
            var ch2 = max - palabras.filter(Boolean).length;
            $('#mensaje_ayuda1').text(ch2 + ' palabras restantes');
            $('#mensaje_ayuda1').removeClass('text-danger');
            actualizardatos($(this).val(), "pregunta1", "etapa2", 0, 0, 0);

        }

    });
    $('#preg2a').keyup(function () {
        var max1 = 400;
        const texto = this.value.trim(); // Eliminar espacios en blanco al inicio y al final
        const palabras = texto.length > 0 ? texto.split(/\s+/) : [];
        if (palabras.filter(Boolean).length > max1) {
            this.value = palabras.slice(0, max1).join(' ');
            $('#mensaje_ayuda2').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda2').addClass('text-danger');                  
        } 
        else {
            var ch2 = max1 - palabras.filter(Boolean).length;
            $('#mensaje_ayuda2').text(ch2 + ' palabras restantes');
            $('#mensaje_ayuda2').removeClass('text-danger');
            actualizardatos($(this).val(), "pregunta2", "etapa2", 0, 0, 0);

        }
    });
    $('#preg3a').keyup(function () {
        var max2 = 400;
        const texto = this.value.trim(); // Eliminar espacios en blanco al inicio y al final
        const palabras = texto.length > 0 ? texto.split(/\s+/) : [];
        if (palabras.filter(Boolean).length > max2) {
            this.value = palabras.slice(0, max2).join(' ');
            $('#mensaje_ayuda3').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda3').addClass('text-danger');                  
        } 
        else {
            var ch2 = max2 - palabras.filter(Boolean).length;
            $('#mensaje_ayuda3').text(ch2 + ' palabras restantes');
            $('#mensaje_ayuda3').removeClass('text-danger');
            actualizardatos($(this).val(), "pregunta3", "etapa2", 0, 0, 0);

        }
    });
    $('#preg4a').keyup(function () {
        var max3 = 400;
        const texto = this.value.trim(); // Eliminar espacios en blanco al inicio y al final
        const palabras = texto.length > 0 ? texto.split(/\s+/) : [];
        if (palabras.filter(Boolean).length > max3) {
            this.value = palabras.slice(0, max3).join(' ');
            $('#mensaje_ayuda4').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda4').addClass('text-danger');                  
        } 
        else {
            var ch2 = max3 - palabras.filter(Boolean).length;
            $('#mensaje_ayuda4').text(ch2 + ' palabras restantes');
            $('#mensaje_ayuda4').removeClass('text-danger');
            actualizardatos($(this).val(), "pregunta4", "etapa2", 0, 0, 0);
        }
    });
    $('#preg5a').keyup(function () {
        var max4 = 300;
        const texto = this.value.trim(); // Eliminar espacios en blanco al inicio y al final
        const palabras = texto.length > 0 ? texto.split(/\s+/) : [];
        if (palabras.filter(Boolean).length > max4) {
            this.value = palabras.slice(0, max4).join(' ');
            $('#mensaje_ayuda5').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda5').addClass('text-danger');                  
        } 
        else {
            var ch2 = max4 - palabras.filter(Boolean).length;
            $('#mensaje_ayuda5').text(ch2 + ' palabras restantes');
            $('#mensaje_ayuda5').removeClass('text-danger');
            actualizardatos($(this).val(), "pregunta5", "etapa2", 0, 0, 0);
        }
    });

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
                if(type == "validar2" || type == "file" || type == "delete")
                {
                    window.location.reload(); 
                }
                console.log(respu);
                
            }
        });
    }
    $(document).on('click','#validardatos',function(e){
        
        let error = "";
        
        if($.trim($("#preg1a").val()).length <= 2)
        {
            error += "<strong>Fundamentación del proyecto</strong><br>";
        }
        if($.trim($("#preg3a").val()).length <= 2)
        {
            error += "<strong>Ingrese objetivo general y específicos</strong><br>";
        }
        if($.trim($("#preg4a").val()).length <= 2)
        {
            error += "<strong>Fundamente la teoría educativa</strong><br>";
        }
        if($.trim($("#preg5a").val()).length <= 2)
        {
            error += "<strong>Ingrese como se fomenta la participación e interacción de los estudiantes</strong><br>";
        }
        if(error != "")
        {
            $('#staticBackdropLabel').html(`{{ trans('multi-leng.a87')}} {{ trans('multi-leng.a149')}}`);
            $('#modalbody').html(`Estimado Usuario, para proceder a validar la información de esta etapa (2), debe solucionar los siguientes errores para continuar: <br>${error}`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $('#staticBackdrop').modal('show');
        }
        else
        {
           
            actualizardatos(1, 0, "validar2", "validar2", 0, 0);
        }
        
    });
    function addcat(tipo)
    {
        if(tipo == 1)
        {
            $( "#staticBackdropLabel" ).html("{{ trans('multi-leng.a24')}}");
            $( "#modalbody" ).html(`<div class="form-group">
                                        <label for="textdocs"><b>{{ trans('multi-leng.formerror26')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __("multi-leng.a36") }}" data-html="true"></i></label>
                                        <input type="text" class="form-control" name="textdocs" id="textdocs" maxlength="30">
                                        <small id="errortextfile" style="color:red"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="docs"><b>{{ trans('multi-leng.a23')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Formatos permitidos: .pdf, .docx, .xlsx, .png, .jpeg, jpg" data-html="true"></i></label>
                                        <input type="file" class="form-control" name="docs" id="docs" accept=".pdf, .docx, .xlsx, .png, .jpeg, jpg">
                                        <small id="errorfile" style="color:red"></small>
                                    </div>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $( "#staticBackdrop" ).modal('show');
        }

        else if(tipo == 2)
        {
            $( "#staticBackdropLabel" ).html("{{ trans('multi-leng.a24')}}");
            $( "#modalbody" ).html(`<div class="form-group">
                                        <label for="textdocs"><b>{{ trans('multi-leng.formerror26')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __("multi-leng.a36") }}" data-html="true"></i></label>
                                        <input type="text" class="form-control" name="textdocs" id="textdocs" maxlength="30">
                                        <small id="errortextfile" style="color:red"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="docs1"><b>{{ trans('multi-leng.a23')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __("multi-leng.a191") }}" data-html="true"></i></label>
                                        <input type="file" class="form-control" name="docs1" id="docs1" accept=".pdf, .docx">
                                        <small id="errorfile" style="color:red"></small>
                                    </div>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $( "#staticBackdrop" ).modal('show');
        }

        else if(tipo == 3)
        {
            $( "#staticBackdropLabel" ).html("{{ trans('multi-leng.a24')}}");
            $( "#modalbody" ).html(`<div class="form-group">
                                        <label for="textdocs"><b>{{ trans('multi-leng.formerror26')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __("multi-leng.a36") }}" data-html="true"></i></label>
                                        <input type="text" class="form-control" name="textdocs" id="textdocs" maxlength="30">
                                        <small id="errortextfile" style="color:red"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="docs2"><b>{{ trans('multi-leng.a23')}}</b> <small style="color:red">(*{{ __('lang.reqinf') }})</small>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __("multi-leng.a191") }}" data-html="true"></i></label>
                                        <input type="file" class="form-control" name="docs2" id="docs2" accept=".pdf, .docx">
                                        <small id="errorfile" style="color:red"></small>
                                    </div>`);
            $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
            $( "#staticBackdrop" ).modal('show');
        }
        
        
    }
    $("#staticBackdrop").on('show.bs.modal', function() { 
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $("#docs").change(function(e){
            $("#errorfile").html('');
            $("#errortextfile").html('');

            if($.trim($("#textdocs").val()).length < 3)
            {
                $("#errortextfile").html("{{__('multi-leng.a37')}}");
                $("#docs").val('');
            }
            else
            {
                var fileUpload = $(this)[0];
                if(fileUpload.size > 9000000)
                {
                    $("#errorfile").html("{{__('multi-leng.a21')}}");
                    $("#docs").val('');
                }
                else
                {
                    var filePath = fileUpload.value;
                    var allowedExtensions = /(.pdf|.docx|.xlsx|.png|.jpeg|.jpeg)$/i;
                    if(!allowedExtensions.exec(filePath))
                    {
                        $("#errorfile").html("{{__('lang.textprof3')}}");
                        $("#docs").val('');
                    }
                    else
                    {
                        //Check whether HTML5 is supported.
                        if (typeof (fileUpload.files) != "undefined") 
                        {
                            
                            const fileInput = document.querySelector('#docs');
                            const file = fileInput.files[0];
                            actualizardatos(file, $("#textdocs").val(), "file", 0, 0, 1, e, null);
                            e.stopPropagation();
                            e.preventDefault();
                        } 
                        else 
                        {
                            $("#errorfile").html("{{__('lang.textprof2')}}");
                            $("#docs").val('');
                        }
                    }
                }
            }
            
            
        });
    });

    function senddelete(id, name)
    {
        $( "#staticBackdropLabel" ).html("{{ trans('lang.eliminar')}}");
        $( "#modalbody" ).html(`<div class="form-group"><label for="namecat"><b>{{ trans('multi-leng.formerror9')}}</b></label><input type="text" class="form-control" name="deldocs" id="deldocs" value="${name}" readonly><button type="button" class="btn btn-danger btn-sm" onclick="validardelete(${id}, '${name}', event)">{{ trans('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button></div>`);
        $( "#footerbody" ).html('<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('lang.cancelar')}}</button>');
        $( "#staticBackdrop" ).modal('show');
    }
    function validardelete(id, nombre, e)
    {
        actualizardatos(id, nombre, "delete", 0, 0, 0, e, null);
    }
    
</script>
@endsection
