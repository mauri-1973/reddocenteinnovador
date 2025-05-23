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
                                        <a href="{{ route('ver.nuevo.formulario.docente.segunda.etapa.admin', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block" disabled>Generar Rúbrica&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
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
                                        <div class="author text-dark mb-5">
                                            <h3 class="text-dark">{{ trans('multi-leng.a42')}}</h3>
                                        </div>
                                        <div class="author text-white mb-3">
                                            <h5 class="text-dark">3.- Antecedentes </h5>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                            <div class="form-group mb-4">
                                                <label for="preg1a" class="textlabel text-dark"><b>3.1.- Fundamentación del proyecto (máximo 400 palabras). Incluya tres acciones de sustentabilidad en el tiempo, dos aspectos del modelo educativo UST, dos aspectos de la unidad académica (escuela, carrera, facultad)</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a95') }}" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <textarea class="form-control input-lg textarea1 text-dark" placeholder="Máximo 400 palabras" id="preg1a" name="preg1a" rows="30" disabled>{{ $finalstus->pregunta1 }}</textarea>

                                                <label for="obspreg10" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                                <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg10" name="obspreg10" rows="15" maxlength="500">{{ $finalstus->obspreg10 }}</textarea>
                                                <span class="help-block">
                                                    <p id="mensaje_ayuda10" class="help-block"></p>
                                                </span> 
                                            </div>
                                        <hr style="border-top: 2px solid #000;">
                                            <div class="form-group mb-4">
                                                <label for="preg2a" class="textlabel text-dark"><b>3.2.- Proyecto (s) anterior(es) Adjuntar tres o más evidencias cuantitativas y/o cualitativas (anexar informes finales del proceso anterior o fase 1) y datos (máximo 400 palabras)</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a97') }}" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <textarea class="form-control input-lg textarea1 text-dark" placeholder="Máximo 400 palabras" id="preg2a" name="preg2a" rows="30" disabled>{{ $finalstus->pregunta2 }}</textarea>
                                                
                                                <label for="obspreg11" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                                <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg11" name="obspreg11" rows="15" maxlength="500">{{ $finalstus->obspreg11 }}</textarea>
                                                <span class="help-block">
                                                    <p id="mensaje_ayuda11" class="help-block"></p>
                                                </span>
                                                <hr style="border-top: 2px solid #000;">
                                                <table class="table table-bordered table-sm" style="background-color:#fff;" id="tabla2">
                                                    <caption class="bg-success p-2 text-white">Documentos Anexos &nbsp;
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
                                                                <a class='btn btn-success btn-sm btn-block' href='{{url('/')}}/storage/adjuntos/docentes/{{ $file->dirfile }}' role='button' download='{{ $file->dirfile }}'>{{__('multi-leng.a39')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        <hr style="border-top: 2px solid #000;">
                                            <div class="form-group mb-4">
                                                <label for="preg3a" class="textlabel text-dark"><b>3.3.- Objetivo general y específicos: pertinentes, coherentes, lógicos. Consideran el escalamiento.</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a99') }}" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <textarea class="form-control input-lg textarea1 text-dark" placeholder="Máximo 400 palabras" id="preg3a" id="preg3a" rows="30" disabled>{{ $finalstus->pregunta3 }}</textarea>
                                                
                                                <label for="obspreg12" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                                <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg12" name="obspreg12" rows="15" maxlength="500">{{ $finalstus->obspreg12 }}</textarea>
                                                <span class="help-block">
                                                    <p id="mensaje_ayuda12" class="help-block"></p>
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
                                                <textarea class="form-control input-lg textarea1 text-dark" placeholder="Máximo 400 palabras" id="preg4a" name="preg4a" rows="30" disabled>{{ $finalstus->pregunta4 }}</textarea>
                                                
                                                <label for="obspreg13" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                                <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg13" name="obspreg13" rows="15" maxlength="500">{{ $finalstus->obspreg13 }}</textarea>
                                                <span class="help-block">
                                                    <p id="mensaje_ayuda13" class="help-block"></p>
                                                </span>
                                            </div>
                                        <hr style="border-top: 2px solid #000;">
                                            <div class="form-group mb-4">
                                                <label for="preg5a" class="textlabel text-dark"><b>4.2.-Cómo se fomenta la participación e interacción de los estudiantes. Indica de forma precisa la equidad de género y el apoyo para estudiantes con discapacidad y neurodivergentes.(máximo 300 palabras)</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-leng.a103') }}" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <textarea class="form-control input-lg textarea1 text-dark" placeholder="Máximo 300 palabras" id="preg5a" id="preg5a" rows="30" disabled>{{ $finalstus->pregunta5 }}</textarea>
                                                
                                                <label for="obspreg14" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                                <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg14" name="obspreg14" rows="15" maxlength="500">{{ $finalstus->obspreg14 }}</textarea>
                                                <span class="help-block">
                                                    <p id="mensaje_ayuda14" class="help-block"></p>
                                                </span>
                                            </div>
                                        <hr style="border-top: 2px solid #000;">
                                            <div class="form-group mb-4">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <a href="{{ route('ver.informacion.ingresada.docente.revisor.fase.dos', ['tipo' => $poststatus, 'idpost' => $idpost, 'idansw' => Crypt::encrypt($finalstus->id)]) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a104')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <a href="{{ route('imprimr.formulario.docente.fase.dos', $idpostulacion) }}" role="button" id="imprimir" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a204')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <a href="{{ route('ver-postulaciones-concursos-registrados', $idconcurso  ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <a href="{{ route('ver.nuevo.formulario.revisor.tercera.etapa', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a88')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
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
<input type="hidden" id="idetapa" name="idestapa" value="{{ Crypt::encrypt($finalstus->id) }}">
@endsection

@section('extra-script')
<script type="text/javascript">
    
    $(document).ready(function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $('#obspreg10').trigger('keyup');
        $('#obspreg11').trigger('keyup');
        $('#obspreg12').trigger('keyup');
        $('#obspreg13').trigger('keyup');
        $('#obspreg14').trigger('keyup'); 

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
    $('#obspreg10').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda10').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda10').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda10').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda10').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg10", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg11').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda11').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda11').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda11').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda11').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg11", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg12').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda12').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda12').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda12').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda12').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg12", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg13').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda13').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda13').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda13').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda13').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg13", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg14').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda14').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda14').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda14').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda14').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg14", "correctionsprocesodos", "actualizar");

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
                
                console.log(respu);
                
            }
        });
    }
    
</script>
@endsection
