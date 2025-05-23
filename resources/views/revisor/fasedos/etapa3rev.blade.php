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
                                        <div class="author text-white mb-5">
                                            <h3 class="text-dark">{{ trans('multi-leng.a42')}}</h3>
                                        </div>
                                        <div class="author text-white mb-3">
                                            <h5 class="text-dark">5.- Evaluación </h5>
                                        </div>
                                    <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="indicadores" class="textlabel text-dark"><b>5.1.- Indicadores y métodos de monitoreo parciales y finales (máximo 400 palabras)</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese los indicadores y métodos de monitoreo" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese los indicadores y métodos de monitoreo" id="indicadores" name="indicadores" rows="30" disabled>{{ $finalstus->pregunta6 }}</textarea>

                                            <label for="obspreg15" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg15" name="obspreg15" rows="15" maxlength="500">{{ $finalstus->obspreg15 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda15" class="help-block"></p>
                                            </span> 
                                        </div>
                                    <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="resultados" class="textlabel text-dark"><b>5.2.- Resultados y productos esperados en detalle (máximo 400 palabras)</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese los resultados y productos esperados" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese los resultados y productos esperados" id="resultados" name="resultados" rows="30" disabled>{{ $finalstus->pregunta7 }}</textarea>
                                            
                                            <label for="obspreg16" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg16" name="obspreg16" rows="15" maxlength="500">{{ $finalstus->obspreg16 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda16" class="help-block"></p>
                                            </span> 
                                        </div>
                                    <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="impacto" class="textlabel text-dark"><b>5.3.- Indicadores de Impacto en las prácticas pedagógicas considerando los objetivos (máximo 400 palabras)</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese los indicadores de impacto" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese los indicadores de impacto" id="impacto" name="impacto" rows="30" disabled>{{ $finalstus->pregunta8 }}</textarea>
                                            
                                            <label for="obspreg17" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg17" name="obspreg17" rows="15" maxlength="500">{{ $finalstus->obspreg17 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda17" class="help-block"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="institucional" class="textlabel text-dark"><b>5.4.- Indicadores de Impacto institucional considerando los objetivos, se incluye la difusión, licenciamiento, entre otros (máximo 400 palabras)</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ingrese los indicadores de impacto institucional" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="Ingrese los indicadores de impacto institucional" id="institucional" name="institucional" rows="30" disabled>{{ $finalstus->pregunta9 }}</textarea>
                                            
                                            <label for="obspreg18" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg18" name="obspreg18" rows="15" maxlength="500">{{ $finalstus->obspreg18 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda18" class="help-block"></p>
                                            </span> 
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="author text-white mb-3">
                                            <br>
                                            <h5 class="text-dark">6.- CARTA GANTT </h5>
                                            <br>
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <label for="institucional" class="textlabel text-dark"><b>6.1.- En la siguiente tabla indique la duración estimada de las diferentes actividades del proyecto en detalle, marcando los meses que corresponda. Hay que destacar los hitos relevantes. Considere eficiencia y sostenibilidad para la continuidad para lograr el cambio en la práctica pedagógica y los productos del proyecto de continuidad.</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Complete la tabla adjunta" data-html="true"></i>&nbsp; <small style="color:white;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                            
                                            <table class="table table-bordered table-sm" style="background-color:#fff;" id="tabla2">
                                                <thead>
                                                    <tr>
                                                        <th>Actividades (Incluya hito relevante de logro)</th>
                                                        <th>Fecha de Inicio</th>
                                                        <th>Fecha de Término</th>
                                                        <th>Descripción</th>
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
                                            <br>
                                            <label for="obspreg19" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg19" name="obspreg19" rows="15" maxlength="500">{{ $finalstus->obspreg19 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda19" class="help-block"></p>
                                            </span> 
                                            
                                        </div>
                                        <hr style="border-top: 2px solid #000;">
                                        <div class="form-group mb-4">
                                            <div class="container-fluid">
                                                <div class="row">
                                                        
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('ver.nuevo.formulario.revisor.segunda.etapa', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a104')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('imprimr.formulario.docente.fase.dos', $idpostulacion) }}" role="button" id="imprimir" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a204')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('ver-postulaciones-concursos-registrados', $idconcurso  ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <a href="{{ route('ver.nuevo.formulario.revisor.cuarta.etapa', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a88')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
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
        $('#obspreg15').trigger('keyup');
        $('#obspreg16').trigger('keyup');
        $('#obspreg17').trigger('keyup');
        $('#obspreg18').trigger('keyup');
        $('#obspreg19').trigger('keyup'); 
        
    });
    $('#obspreg15').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda15').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda15').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda15').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda15').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg15", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg16').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda16').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda16').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda16').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda16').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg16", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg17').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda17').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda17').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda17').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda17').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg17", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg18').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda18').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda18').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda18').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda18').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg18", "correctionsprocesodos", "actualizar");

        }
    });
    $('#obspreg19').keyup(function () {
        var max = 500;
        var len = $(this).val().length;
        if (len >= max) 
        {

            $('#mensaje_ayuda19').text('{{ trans('multi-leng.a59')}}');// Aquí enviamos el mensaje a mostrar          
            $('#mensaje_ayuda19').addClass('text-danger'); 
                            
        } 
        else 
        {

            var ch = max - len;
            $('#mensaje_ayuda19').text(ch + '{{ trans('multi-leng.a58')}}');
            $('#mensaje_ayuda19').removeClass('text-danger');
            actualizardatos($(this).val(), "obspreg19", "correctionsprocesodos", "actualizar");

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
