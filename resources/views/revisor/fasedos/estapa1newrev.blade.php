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
                                        @if($finalstus->statusrub > 0)
                                            <a href="#" class="btn btn-primary btn-sm btn-block">Imprimir Rúbrica&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                        @else
                                            <a href="#" class="btn btn-primary btn-sm btn-block" disabled>Imprimir Rúbrica&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                        @endif
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
                <div class="col-md-12 mb-1">
                    <div class="card mb-4 bg-white shadow-sm">
                        <div class="card-body">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="author text-dark mb-3">
                                            <h5>{{ __('inst.75') }}</h5>
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="titulo" class="textlabel text-dark"><b>{{ __('inst.76') }}</b></label>
                                            <input class="form-control input-lg text-dark" id="titulo" name="titulo" type="text" minlength="2" maxlength="70" value="{{ $finalstus->titulo }}" placeholder="{{ trans('multi-leng.a150')}}" disabled>
                                            
                                            <label for="obspreg1" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg1" name="obspreg1" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg1 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda1" class="help-block"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="fechaingreso" class="textlabel text-dark"><b>{{ __('inst.77') }}</b></label>
                                            <input class="form-control input-lg text-dark" id="fechaingreso" name="fechaingreso" type="date" minlength="8" maxlength="10" value="{{ $finalstus->fecha }}" placeholder="{{ __('inst.84') }}" disabled>
                                            
                                            <label for="obspreg2" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg2" name="obspreg2" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg2 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda2" class="help-block text-dark"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="facultades" class="textlabel text-dark"><b>{{ __('inst.79') }}</b></label>
                                            <br>
                                            <label for="facultades" class="textlabel text-dark"><b>{{ __('inst.80') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.81') }}" id="facultades" name="facultades" rows="15" maxlength="250" disabled>{{ $finalstus->facultades }}</textarea>
                                             
                                            <label for="obspreg3" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg3" name="obspreg3" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg3 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda3" class="help-block text-dark"></p>
                                            </span> 
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="carreras" class="textlabel text-dark"><b>{{ __('inst.83') }}</b></label>
                                            <br>
                                            <label for="carreras" class="textlabel text-dark"><b>{{ __('inst.85') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="carreras" name="carreras" rows="15" maxlength="250" disabled>{{ $finalstus->carreras }}</textarea>
                                             
                                            <label for="obspreg4" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg4" name="obspreg4" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg4}}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda4" class="help-block text-dark"></p>
                                            </span>
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="sedes" class="textlabel text-dark"><b>{{ __('inst.87') }}</b></label>
                                            <br>
                                            <label for="sedes" class="textlabel text-dark"><b>{{ __('inst.88') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.89') }}" id="sedes" name="sedes" rows="15" maxlength="500" disabled>{{ $finalstus->sedes }}</textarea>
                                             
                                            <label for="obspreg5" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg5" name="obspreg5" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg5 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda5" class="help-block text-dark"></p>
                                            </span>
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="nombredoc" class="textlabel text-dark"><b>{{ __('inst.90') }}</b></label>
                                            <input class="form-control input-lg text-dark" id="nombredoc" name="nombredoc" type="text" minlength="2" maxlength="70" value="{{ $finalstus->nombredoc }}" placeholder="{{ __('inst.91') }}" disabled>
                                             
                                            <label for="obspreg6" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg6" name="obspreg6" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg6 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda6" class="help-block text-dark"></p>
                                            </span>
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="directoralt" class="textlabel text-dark"><b>{{ __('inst.92') }}</b></label>
                                            <input class="form-control input-lg text-dark" id="directoralt" name="directoralt" type="text" minlength="2" maxlength="70" value="{{ $finalstus->directoralt }}" placeholder="{{ __('inst.93') }}" disabled>
                                             
                                            <label for="obspreg7" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg7" name="obspreg7" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg7 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda7" class="help-block text-dark"></p>
                                            </span>
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="equipodoc" class="textlabel text-dark"><b>{{ __('inst.94') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.95') }}" id="equipodoc" name="equipodoc" rows="15" maxlength="250" disabled>{{ $finalstus->equipodoc }}</textarea>
                                            
                                            <label for="obspreg8" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg8" name="obspreg8" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg8 }}</textarea> 
                                            <span class="help-block">
                                                <p id="mensaje_ayuda8" class="help-block text-dark"></p>
                                            </span>
                                        </div>

                                        <hr style="border-top: 2px solid #000;">
                                        
                                        <div class="author text-dark mb-3">
                                            <h5>{{ __('inst.96') }}</h5>
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="numeropar" class="textlabel text-dark"><b>{{ __('inst.97') }}</b></label>
                                            <input class="form-control input-lg text-dark" id="numeropar" name="numeropar" type="text" minlength="1" maxlength="2" value="{{ $finalstus->numeropar }}" placeholder="{{ __('inst.98') }}" onkeypress="return valideKey(event);" disabled>
                                             
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="numdoc" class="textlabel text-dark"><b>{{ __('inst.99') }}</b></label>
                                            <input class="form-control input-lg text-dark" id="numdoc" name="numdoc" type="text" minlength="1" maxlength="2" value="{{ $finalstus->numdoc }}" placeholder="{{ __('inst.100') }}" onkeypress="return valideKey(event);" disabled>
                                        </div>

                                        <hr style="border-top: 2px solid #000;">

                                        <div class="form-group mb-4">
                                            <label for="numest" class="textlabel text-dark"><b>{{ __('inst.101') }}</b></label>
                                            <input class="form-control input-lg text-dark" id="numest" name="numest" type="text" minlength="1" maxlength="2" value="{{ $finalstus->numest }}" placeholder="{{ __('inst.102') }}" onkeypress="return valideKey(event);" disabled>
                                             
                                            <label for="obspreg9" class="textlabel text-dark"><b>{{ __('inst.74') }}</b></label>
                                            <textarea class="form-control input-lg textarea1 text-dark" placeholder="{{ __('inst.78') }}" id="obspreg9" name="obspreg9" rows="15" maxlength="250" disabled>{{ $finalstus->obspreg9 }}</textarea>
                                            <span class="help-block">
                                                <p id="mensaje_ayuda9" class="help-block text-dark"></p>
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
                                                    @role('revisor')
                                                        <a href="{{ route('ver-postulaciones-concursos-registrados', $idconcurso ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-leng.lognav')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                                    @endrole
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="{{ route('ver.nuevo.formulario.revisor.segunda.etapa', $idpostulacion ) }}" class="btn btn-primary btn-sm btn-block">{{ trans('multi-leng.a88')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
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
