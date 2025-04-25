@extends('home')

@section('title')
{{ Auth::user()->name }}
@endsection

@section('extra-css')

<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css" />
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
    caption{
        color:#fff;
        caption-side: top;
        font-size:16px;
    }
    .panel-group .panel {
		border-radius: 0;
		box-shadow: none;
		border-color: #EEEEEE;
	}

	.panel-default > .panel-heading {
		padding: 0;
		border-radius: 0;
		color: #212121;
		background-color: #FAFAFA;
		border-color: #EEEEEE;
	}

	.panel-title {
		font-size: 14px;
	}

	.panel-title > a {
		display: block;
		padding: 15px;
		text-decoration: none;
	}

	.more-less {
		float: right;
		color: #212121;
	}

	.panel-default > .panel-heading + .panel-collapse > .panel-body {
		border-top-color: #EEEEEE;
	}
    .datepicker-days th.dow:first-child,
    .datepicker-days td:first-child {
    color: #f00;
    }
    .datepicker-days th.dow:last-child,
    .datepicker-days td:last-child {
    color: #00f;
    }
</style>
@endsection
@section('index')
<div class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row justify-content-center mt-4">
                @if($statusacta == "solicitar")
                <div class="col-md-12">
                    <div class="card mb-4 bg-success shadow-sm text-white">
                        <div class="card-body">
                            <h3><strong>{{ trans('multi-new.0138')}} </strong></h3><br><br>
                            @if(Auth::user()->hasRole('docente') )
                            
                                <form action="{{ route('funcionalidades-ajax-usuario-docente-actas') }}" method="post">
                                    @csrf 
                                    <div class="form-group">
                                        <input type="hidden" name="tipo" id="tipo" value="solicitar">
                                        <input type="hidden" name="idansw" id="idansw" value="{{ $id }}">
                                        <a href="{{ route('ver-formulario-docente-concurso-finalizado', $id) }}" class="btn btn-info btn-sm">{{ trans('lang.volver')}}</a>
                                        <button type="submit" class="btn btn-warning btn-sm">{{ trans('multi-new.0139')}}</button>
                                    </div>
                                </form>
                            
                            @endif
                        </div>
                        
                    </div>
                </div>
                @elseif($statusacta == "sinasesores")
                <div class="col-md-12">
                    <div class="card mb-4 bg-success shadow-sm text-white">
                        <div class="card-body">
                            <h3><strong>{{ trans('multi-new.0138')}} </strong></h3><br><br>
                            @if(Auth::user()->hasRole('docente') )
                            
                                <form action="{{ route('funcionalidades-ajax-usuario-docente-actas') }}" method="post">
                                    @csrf 
                                    <div class="form-group">
                                        <input type="hidden" name="tipo" id="tipo" value="sinasesores">
                                        <input type="hidden" name="idansw" id="idansw" value="{{ $id }}">
                                        <a href="{{ route('ver-formulario-docente-concurso-finalizado', $id) }}" class="btn btn-info btn-sm">{{ trans('lang.volver')}}</a>
                                        <button type="submit" class="btn btn-warning btn-sm">{{ trans('multi-new.0141')}}</button>
                                    </div>
                                </form>
                            
                            @endif
                        </div>
                        
                    </div>
                </div>
                @elseif($statusacta == "creada")
                <div class="col-md-12">
                    <div class="card mb-4 bg-success shadow-sm text-white">
                        <div class="card-body">
                            <h3><strong>{{ trans('multi-new.0142')}} </strong></h3><br><br>
                            @if(Auth::user()->hasRole('docente') )
                            
                            <a href="{{ route('ver-formulario-docente-concurso-finalizado', $id) }}" class="btn btn-warning btn-sm">{{ trans('lang.volver')}}</a>
                            
                            @endif
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4 bg-success shadow-sm text-white">
                        <div class="card-body">
                            <div class="container p-2">
                                <h3><strong>{{ trans('multi-new.0078')}} </strong></h3>
                                <nav>
                                    <div class="nav nav-pills text-center" id="nav-tab" role="tablist">
                                        <a class="col-3 nav-item nav-link active" id="nav-home-tab" data-toggle="tab" data-tooltip="tooltip" data-placement="top" title="{{ trans('multi-new.0105')}}" data-html="true"  href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{ trans('multi-new.0074')}}</a>
                                        <!--<a class="col-3 nav-item nav-link" id="nav-profile-tab" data-toggle="tab" data-tooltip="tooltip" data-placement="top" title="{{ trans('multi-new.0106')}}" data-html="true" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">{{ trans('multi-new.0075')}}</a>
                                        <a class="col-3 nav-item nav-link" id="nav-contact-tab" data-toggle="tab" data-tooltip="tooltip" data-placement="top" title="{{ trans('multi-new.0107')}}" data-html="true" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">{{ trans('multi-new.0076')}}</a>
                                        <a class="col-3 nav-item nav-link" id="nav-comp-tab" data-toggle="tab" data-tooltip="tooltip" data-placement="top" title="{{ trans('multi-new.0108')}}" data-html="true" href="#nav-comp" role="tab" aria-controls="nav-comp" aria-selected="false">{{ trans('multi-new.0077')}}</a>-->
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <form action="{{ route('funcionalidades-ajax-usuario-docente-actas') }}" method="post" id="formconfig">
                                    @csrf 
                                        <div class="col-12 mt-5">
                                            <div class="form-group row">
                                                <label for="fechaact" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0079')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0080')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <input type="text" class="form-control input-lg" id="fechaact" name="fechaact" value="{{ date('d-m-Y H:i:s') }}" readonly/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="progressgen" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0081')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0082')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <div class="progress mt-3 mb-3">
                                                        <div class="progress-bar w-0 bg-info" id="progressgen" name="progressgen" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                            0%
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="datetimepickerone" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0083')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0084')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 input-group date mt-2" id="datetimepickerone" data-target-input="nearest">
                                                    <input type="text" id="fechainiconfig" name="fechainiconfig" class="form-control datetimepicker-input" data-target="#datetimepickerone" />
                                                    <div class="input-group-text" data-target="#datetimepickerone" data-toggle="datetimepicker">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="datetimepickertwo" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0085')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0086')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 input-group date mt-2" id="datetimepickertwo" data-target-input="nearest">
                                                    <input type="text" id="fechafinconfig"  name="fechafinconfig" class="form-control datetimepicker-input" data-target="#datetimepickertwo" />
                                                    <div class="input-group-text" data-target="#datetimepickertwo" data-toggle="datetimepicker">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="datetimepickertwo" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0087')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0088')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <input type="number" class="form-control input-lg" id="porcentaje" name="porcentaje" value="" min="1" max="{{ $sumglobal }}" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="datetimepickerthree" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0089')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0090')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 input-group date mt-2" id="datetimepickerthree" data-target-input="nearest">
                                                    <input type="text" id="fechareuconfig" name="fechareuconfig" class="form-control datetimepicker-input" data-target="#datetimepickerthree"/>
                                                    <div class="input-group-text" data-target="#datetimepickerthree" data-toggle="datetimepicker">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="porcentajeaud" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0091')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0092')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <input type="number" class="form-control input-lg" id="porcentajeaud" name="porcentajeaud" min="0" max="100" value="" onkeypress="return valideKey(event);" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            
                                <div class="form-group">
                                    <input type="hidden" name="tipo" id="tipo" value="configurar">
                                    <input type="hidden" name="idansw" id="idansw" value="{{ $id }}">
                                    <input type="hidden" name="idacta" id="idacta" value="{{ Crypt::encrypt($arreglo->id) }}">
                                    <a href="{{ route('ver-formulario-docente-concurso-finalizado', $id) }}" class="btn btn-info btn-sm">{{ trans('lang.volver')}}</a>
                                    <button type="submit" class="btn btn-warning btn-sm">{{ trans('multi-new.0143')}}</button>
                                </div>
                    </form>
                        </div> 
                    </div>
                </div>
                @elseif($statusacta == "encurso")
                <div class="col-md-12">
                    <div class="card mb-4 bg-success shadow-sm text-white">
                        <div class="card-body">
                            <h3><strong>{{ trans('multi-new.0158')}} </strong></h3><br><br>
                            @if(Auth::user()->hasRole('docente') )
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0100')}}">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:#004238;text-decoration:none;">
                                                <strong>{{ trans('multi-new.0070')}}</strong><i class="nc-icon nc-tap-01" style="font-size:20px;color:">&nbsp;</i> <i class="nc-change nc-icon nc-simple-add float-right" style="font-size:25px;#004238;"></i>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse mb-3" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <h3><strong>{{ trans('multi-new.0096')}}: </strong></h3>
                                        <div class="col-12 border border-white pt-2 pb-2">
                                            <div class="container-fluid">
                                                
                                                <hr style="border: 1px solid white;">
                                                
                                                
                                            </div>
                                        </div>
                                        <br>
                                        <h3><strong>{{ trans('multi-new.0097')}}: </strong></h3>
                                        <div class="col-12 border border-white pt-2 pb-2">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    {{ trans('multi-new.0093')}}: {{ Auth::user()->name }} {{ Auth::user()->surname }}
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        Email: {{ Auth::user()->email }}
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    {{ trans('multi-new.0094')}}: {{ Auth::user()->mobile }}
                                                    </div>
                                                </div>
                                                <hr style="border: 1px solid white;">
                                                <div class="row">
                                                    <div class="col-12">
                                                    {{ trans('multi-new.0099')}}: {{ $defansw->preg1et1}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <h3><strong>{{ trans('multi-new.0098')}}: {{ round(($arreglo->avance/$evaluado)*100, 0, PHP_ROUND_HALF_UP) }}% </strong></h3>
                                        <div class="col-12 border border-white pt-2 pb-2">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="progress mt-2 mb-2">
                                                            <div class="progress-bar w-{{ round(($arreglo->avance/$evaluado)*100, 0, PHP_ROUND_HALF_UP) }} bg-info" role="progressbar" id="progressbarglobal" aria-valuenow="{{ round(($arreglo->avance/$evaluado)*100, 0, PHP_ROUND_HALF_UP) }}" aria-valuemin="0" aria-valuemax="100">{{ round(($arreglo->avance/$evaluado)*100, 0, PHP_ROUND_HALF_UP) }}%</div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                                                      
                                    </div>
                                </div>
                                @if(count($idantiguasactas) > 0)
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0101')}}">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="color:#004238;text-decoration:none;">
                                                <strong>{{ trans('multi-new.0072')}}</strong><i class="nc-icon nc-tap-01" style="font-size:20px;color:">&nbsp;</i> <i class="nc-change nc-icon nc-simple-add float-right" style="font-size:25px;#004238;"></i>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <div class="row">
                                                @for($i = 0; $i < count($idantiguasactas); $i=$i+3)
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <a role="button" href="{{ route('ver-acta-docente-historial', Crypt::encrypt($idantiguasactas[$i] ) ) }}" target="_blank" role="button" class="btn btn-primary btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0103') }}">{{ trans('multi-new.0102')}} {{ $idantiguasactas[$i+1] }}--{{ $idantiguasactas[$i+2] }}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></a>
                                                </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <a href="{{ route('ver-formulario-docente-concurso-finalizado', $id) }}" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0065') }}">{{ trans('lang.volver')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></a>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#info" aria-expanded="false" aria-controls="info" >
                                        {{ trans('multi-new.0036')}}&nbsp;<i class="nc-icon nc-tap-01" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0066') }}" style="font-size:15px;color:"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="collapse" id="info">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <a href="{{ route('imprimr-formulario-docente', $id) }}" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0067') }}">{{ trans('multi-new.0062')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></a>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button  class="btn btn-warning btn-sm btn-block" id="imprimiracta" onclick="solicitaractas('{{ Crypt::encrypt($arreglo->id) }}', 'imprimir', '{{ Crypt::encrypt(Auth::user()->id) }}', '')" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0067') }}">{{ trans('multi-new.0157')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></button>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0068') }}" onclick="solicitaractas('{{ Crypt::encrypt($arreglo->id) }}', 'emailteacher', '{{ Crypt::encrypt(Auth::user()->id) }}', '')">{{ trans('multi-new.0168')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></button>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0069') }}" onclick="solicitaractas('{{ Crypt::encrypt($arreglo->id) }}', 'notificaciones', '{{ Crypt::encrypt(Auth::user()->id) }}', '')">{{ trans('multi-new.0064')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:" ></i></button>
                                    </div>
                                </div> 
                            </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
                
                
                <div class="col-md-12">
                    <div class="card mb-4 bg-success shadow-sm text-white">
                        <div class="card-body">
                            <div class="container p-2">
                                <h3><strong>{{ trans('multi-new.0078')}} </strong></h3>
                                <nav>
                                    <div class="nav nav-pills text-center" id="nav-tab" role="tablist">
                                        <a class="col-3 nav-item nav-link active" id="nav-home-tab" data-toggle="tab" data-tooltip="tooltip" data-placement="top" title="{{ trans('multi-new.0105')}}" data-html="true"  href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{ trans('multi-new.0074')}}</a>
                                        <a class="col-3 nav-item nav-link" id="nav-profile-tab" data-toggle="tab" data-tooltip="tooltip" data-placement="top" title="{{ trans('multi-new.0106')}}" data-html="true" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">{{ trans('multi-new.0075')}}</a>
                                        <a class="col-3 nav-item nav-link" id="nav-contact-tab" data-toggle="tab" data-tooltip="tooltip" data-placement="top" title="{{ trans('multi-new.0107')}}" data-html="true" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">{{ trans('multi-new.0076')}}</a>
                                        <a class="col-3 nav-item nav-link" id="nav-comp-tab" data-toggle="tab" data-tooltip="tooltip" data-placement="top" title="{{ trans('multi-new.0108')}}" data-html="true" href="#nav-comp" role="tab" aria-controls="nav-comp" aria-selected="false">{{ trans('multi-new.0077')}}</a>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="col-12 mt-5">
                                            <div class="form-group row">
                                                <label for="fechaact" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0079')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0080')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <input type="text" class="form-control input-lg" id="fechaact" name="fechaact" value="{{ date('d-m-Y H:i:s') }}" readonly/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="progressgen" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0081')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0082')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <div class="progress mt-3 mb-3">
                                                        <div class="progress-bar w-{{ $evaluado }} bg-info" id="progressgen" name="progressgen" role="progressbar" aria-valuenow="{{ $evaluado }}" aria-valuemin="0" aria-valuemax="100">
                                                            {{ $evaluado }}%
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="datetimepickerone" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0083')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0084')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 input-group date mt-2" id="datetimepickerone" data-target-input="nearest">
                                                    <input type="text" id="fechainiconfig" name="fechainiconfig" class="form-control datetimepicker-input" data-target="#datetimepickerone"  disabled/>
                                                    <div class="input-group-text" data-target="#datetimepickerone" data-toggle="datetimepicker">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="datetimepickertwo" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0085')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0086')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 input-group date mt-2" id="datetimepickertwo" data-target-input="nearest">
                                                    <input type="text" id="fechafinconfig"  name="fechafinconfig" class="form-control datetimepicker-input" data-target="#datetimepickertwo" disabled/>
                                                    <div class="input-group-text" data-target="#datetimepickertwo" data-toggle="datetimepicker">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="datetimepickertwo" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0087')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0088')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <input type="text" class="form-control input-lg" id="porcentaje" name="porcentaje" value="{{ $arreglo->avance }}%" disabled/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="datetimepickerthree" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0089')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0090')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 input-group date mt-2" id="datetimepickerthree" data-target-input="nearest">
                                                    <input type="text" id="fechareuconfig" name="fechareuconfig" class="form-control datetimepicker-input" data-target="#datetimepickerthree" disabled/>
                                                    <div class="input-group-text" data-target="#datetimepickerthree" data-toggle="datetimepicker">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="porcentajeaud" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0091')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0092')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <input type="text" class="form-control input-lg" id="porcentajeaud" name="porcentajeaud" min="0" max="100" value="{{ $evaluado }}%" onkeypress="return valideKey(event);" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <div class="col-12 mt-5">
                                            <div class="form-group row">
                                                <label for="resumenactas" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0075') }}
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="{{ trans('multi-new.0191') }}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2 table-responsive" style="overflow-y: auto !important;max-height: 280px;">
                                                    <table class="table table-striped" style="resize: none;height: 280px;width:100% !important;text-align: left !important;overflow-y: auto !important">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">{{ trans('multi-new.0177') }}</th>
                                                                <th scope="col">{{ trans('multi-new.0178') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="resumenactas">

                                                            @foreach($newhist as $row => $r)
                                                            
                                                                @if($newhist[$row]->temas != null || $newhist[$row]->temas != '')

                                                                    <tr>
                                                                        <th scope="row">
                                                                            <?php  $val = explode("<br>", $newhist[$row]->temas) ?>
                                                                            @for($i = 0; $i < count($val); $i++)
                                                                                {{ ($i + 1).'.- '.$val[$i] }}<br>
                                                                            @endfor
                                                                        </th>
                                                                        <th scope="row">{{ date('d-m-Y H:i:s', strtotime($newhist[$row]->fechatemas)) }}</th>
                                                                    </tr>

                                                                @endif

                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tema" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0171') }}: {{ $personal->nombreaudit }}
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="{{ trans('multi-new.0192') }}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="tema" name="tema" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                    
                                                </div>
                                                
                                            </div>
                                            <div class="form-group row">
                                                <label for="temabutton" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    &nbsp;
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">

                                                    <button id="temabutton" type="button" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0069') }}" onclick="solicitaractas('{{ Crypt::encrypt($arreglo->id) }}', 'temas', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ $personal->id }}')">{{ trans('multi-new.0170')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:" ></i></button>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <div class="col-12 mt-5">
                                            <div class="form-group row">
                                                <label for="resumenacuerdos" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0076') }}
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="{{ trans('multi-new.0193') }}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2 table-responsive" style="overflow-y: auto !important;max-height: 280px;">
                                                    <table class="table table-striped" style="resize: none;max-height: 280px;width:100% !important;text-align: left !important;overflow-y: auto !important">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">{{ trans('multi-new.0177') }}</th>
                                                                <th scope="col">{{ trans('multi-new.0178') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="resumenacuerdos">

                                                            @foreach($newhist as $row => $r)
                                                            
                                                                @if($newhist[$row]->acuerdos != null || $newhist[$row]->acuerdos != '')

                                                                    <tr>
                                                                        <th scope="row">
                                                                            <?php  $val = explode("<br>", $newhist[$row]->acuerdos) ?>
                                                                            @for($i = 0; $i < count($val); $i++)
                                                                                {{ ($i + 1).'.- '.$val[$i] }}<br>
                                                                            @endfor
                                                                        </th>
                                                                        <th scope="row">{{ date('d-m-Y H:i:s', strtotime($newhist[$row]->fechaacuerdos)) }}</th>
                                                                    </tr>

                                                                @endif

                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="acuerdo" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0093') }}: {{ $personal->nombreaudit }}
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="{{ trans('multi-new.0194') }}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="acuerdo" name="acuerdo" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="acuerdosbutton" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    &nbsp;
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">

                                                    <button id="acuerdosbutton" type="button" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0069') }}" onclick="solicitaractas('{{ Crypt::encrypt($arreglo->id) }}', 'acuerdos', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ $personal->id }}')">{{ trans('multi-new.0170')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:" ></i></button>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-comp" role="tabpanel" aria-labelledby="nav-comp-tab">
                                        <div class="col-12 mt-5">
                                            <div class="form-group row">
                                                <label for="resumencompromisos" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0077') }}
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="{{ trans('multi-new.0195') }}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2 table-responsive" style="overflow-y: auto !important;max-height: 280px;">
                                                    <table class="table table-striped" style="resize: none;height: 280px;width:100% !important;text-align: left !important;overflow-y: auto !important;">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">{{ trans('multi-new.0177') }}</th>
                                                                <th scope="col">{{ trans('multi-new.0178') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="resumencompromisos">

                                                            @foreach($newhist as $row => $r)
                                                            
                                                                @if($newhist[$row]->compromisos != null || $newhist[$row]->compromisos != '')
                                                                
                                                                    <tr>
                                                                        <th scope="row">
                                                                            <?php  $val = explode("<br>", $newhist[$row]->compromisos) ?>
                                                                            @for($i = 0; $i < count($val); $i++)
                                                                                {{ ($i + 1).'.- '.$val[$i] }}<br>
                                                                            @endfor
                                                                        </th>
                                                                        <th scope="row">{{ date('d-m-Y H:i:s', strtotime($newhist[$row]->fechacompromisos)) }}</th>
                                                                    </tr>

                                                                @endif

                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="compromiso" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0093') }}: {{ $personal->nombreaudit }}
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0196') }}" data-html="true"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="compromiso" name="compromiso" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="compromisosbutton" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    &nbsp;
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">

                                                    <button id="compromisosbutton" type="button" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0069') }}" onclick="solicitaractas('{{ Crypt::encrypt($arreglo->id) }}', 'compromisos', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ $personal->id }}')">{{ trans('multi-new.0170')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:" ></i></button>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            
                                <div class="form-group">
                                    
                                    
                                    
                                    <a href="{{ route('ver-formulario-docente-concurso-finalizado', $id) }}" class="btn btn-info btn-sm">{{ trans('lang.volver')}}</a>
                                    
                                    <button  class="btn btn-info btn-sm" id="agendarreunion" onclick="solicitaractas('{{ Crypt::encrypt($arreglo->id) }}', 'agendarreunion', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ $personal->id }}')">{{ trans('multi-new.0155')}}</button>
                                    <form action="{{ route('funcionalidades-ajax-usuario-docente-actas') }}" method="post" class="mt-1">
                                        @csrf 
                                        <input type="hidden" name="idansw" id="idansw" value="{{ $id }}">
                                        <input type="hidden" name="tipo" id="tipo" value="finalizaracta">
                                        <input type="hidden" name="idacta" id="idacta" value="{{ Crypt::encrypt($arreglo->id) }}">
                                        
                                        <button type="submit" id="finalizaracta" class="btn btn-warning btn-sm">{{ trans('multi-new.0154')}}</button>
                                    </form>
                                </div>
                        </div> 
                    </div>
                </div>
                @elseif($statusacta == "finalizada")
                    finalizada
                @else
                    error
                @endif
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
            <div class="modal-footer" id="modalfooter">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="staticBackdroptwo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabeltwo" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabeltwo">{{ trans('multi-leng.admcat')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalbodytwo">
                ...
            </div>
            <div class="modal-footer" id="modalfootertwo">
                
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="idconc" name="idconc" value="">
<input type="hidden" id="idpost" name="idpost" value="">
<input type="hidden" id="idansw" name="idansw" value="">

@endsection

@section('extra-script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.5/bootstrap-notify.min.js"></script>
<script type="text/javascript">
    
    
    
    $(document).ready(function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-tooltip="tooltip"]').tooltip();
        });
        $('#progressgen').html("{{ $evaluado }}%");
        $('#progressgen').width("{{ $evaluado }}%").attr('aria-valuenow', {{ $evaluado }});
        $('#progressbarglobal').html("{{ round(($arreglo->avance/$evaluado)*100, 0, PHP_ROUND_HALF_UP) }}%");
        $('#progressbarglobal').width("{{ round(($arreglo->avance/$evaluado)*100, 0, PHP_ROUND_HALF_UP) }}%").attr('aria-valuenow', {{ round(($arreglo->avance/$evaluado)*100, 0, PHP_ROUND_HALF_UP) }});
        
        $("#porcentajeaud").on('input', function (evt) {
            
            if($(this).val() > 100)
            {
                $(this).val('100');
            }
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
            
            $('#progressgen').html($(this).val() + "%");
            $('#progressgen').width($(this).val() + "%").attr('aria-valuenow', $(this).val());
            
        });
        
        
        
    });
    
    $( "#formconfig" ).on( "submit", function(event) {

        event.preventDefault();

        var error = "";

        var datetimeini = moment($("#fechainiconfig").val(), 'DD-MM-YYYY HH:mm:ss', true); 

        var datetimefin = moment($("#fechafinconfig").val(), 'DD-MM-YYYY HH:mm:ss', true);

        var datetimereu = moment($("#fechareuconfig").val(), 'DD-MM-YYYY HH:mm:ss', true); 


        var now = moment();


        if (!datetimeini.isValid()) 
        {

            error += "{{ trans('multi-new.0144')}}"+"<br>";

        }

        if (!datetimefin.isValid()) 
        {

            error += "{{ trans('multi-new.0145')}}"+"<br>";

        }

        if (datetimeini.isBefore(now)) 
        {

            error += "{{ trans('multi-new.0146')}}"+"<br>";

        }


        if (datetimefin.isBefore(now)) 
        {

            error += "{{ trans('multi-new.0147')}}"+"<br>";

        }

        if (datetimefin.isBefore(datetimeini)) 
        {

            error += "{{ trans('multi-new.0148')}}"+"<br>";

        }

        var referencial = {{ $sumglobal }};

        var valor_1 = $("#porcentaje").val();

        if(valor_1 > referencial)
        {

            error += "{{ trans('multi-new.0149')}}"+"<br>";

        }

        if(valor_1 < 0 || valor_1 == '' || valor_1 == 0)
        {

            error += "{{ trans('multi-new.0150')}}"+"<br>";

        }

        if (!datetimereu.isBetween(datetimeini, datetimefin, null, '[]')) 
        {

            error += "{{ trans('multi-new.0151')}}" + "<br>";

        }
        if (error != '') 
        {
            
            notificacion(error, "danger", "{{ trans('multi-new.0152')}}");
            
        }
        else
        {
            this.submit(); // Ejecuta el submit del formulario
            return true;
        } 



    });

    function valideKey(evt){
        
        var code = (evt.which) ? evt.which : evt.keyCode;
        var valor_1 = $("#porcentajeaud").val();
        if(code==8) 
        { 
            console.log(valor_1, 'ok');
            if(valor_1 > 100)
            {
                $("#porcentajeaud").val('100');
                $('#progressgen').html($("#porcentajeaud").val() + "%");
                $('#progressgen').width($("#porcentajeaud").val() + "%").attr('aria-valuenow', $("#porcentajeaud").val());
            }
            else if(valor_1 < 0 || valor_1 == '')
            {
                $("#porcentajeaud").val('0');
                $('#progressgen').html($("#porcentajeaud").val() + "%");
                $('#progressgen').width($("#porcentajeaud").val() + "%").attr('aria-valuenow', $("#porcentajeaud").val());
            }
            else
            {
                $('#progressgen').html($("#porcentajeaud").val() + "%");
                $('#progressgen').width($("#porcentajeaud").val() + "%").attr('aria-valuenow', $("#porcentajeaud").val());
            }
            return true;

        } 
        else if(code>=48 && code<=57) 
        { 
            if(valor_1 > 100)
            {
                $("#porcentajeaud").val('100');
                $('#progressgen').html($("#porcentajeaud").val() + "%");
                $('#progressgen').width($("#porcentajeaud").val() + "%").attr('aria-valuenow', $("#porcentajeaud").val());
            }
            else if(valor_1 < 0 || valor_1 == '')
            {
                $("#porcentajeaud").val('0');
                $('#progressgen').html($("#porcentajeaud").val() + "%");
                $('#progressgen').width($("#porcentajeaud").val() + "%").attr('aria-valuenow', $("#porcentajeaud").val());
            }
            else
            {
                $('#progressgen').html($("#porcentajeaud").val() + "%");
                $('#progressgen').width($("#porcentajeaud").val() + "%").attr('aria-valuenow', $("#porcentajeaud").val());
            }
            return true;
        } 
        else
        { 
            if(valor_1 > 100)
            {
                $("#porcentajeaud").val('100');
                $('#progressgen').html($("#porcentajeaud").val() + "%");
                $('#progressgen').width($("#porcentajeaud").val() + "%").attr('aria-valuenow', $("#porcentajeaud").val());
            }
            else if(valor_1 < 0 || valor_1 == '')
            {
                $("#porcentajeaud").val('0');
                $('#progressgen').html($("#porcentajeaud").val() + "%");
                $('#progressgen').width($("#porcentajeaud").val() + "%").attr('aria-valuenow', $("#porcentajeaud").val());
            }
            else
            {
                $('#progressgen').html($("#porcentajeaud").val() + "%");
                $('#progressgen').width($("#porcentajeaud").val() + "%").attr('aria-valuenow', $("#porcentajeaud").val());
            }
            return false;
        }
    }

    
    function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".nc-change")
            .toggleClass('nc-simple-add nc-simple-delete');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
    $(function() 
    {
  
        $('#datetimepickerone').datetimepicker({
            dayViewHeaderFormat: 'MMMM YYYY',
            tooltips: {
                close: 'cerrar',
                selectMonth: 'Seleccione el mes',
                prevMonth: 'Anterior',
                nextMonth: 'Siguiente',
                selectYear: 'Seleccionar año',
                prevYear: 'año anterior',
                nextYear: 'al año que viene',
                selectTime: 'seleccionar hora',
                selectDate: 'seleccionar fecha',
                prevDecade: 'periodo anterior',
                nextDecade: 'próximo periodo',
                selectDecade: 'Seleccionar periodo',
                prevCentury: 'el siglo pasado',
                nextCentury: 'el próximo siglo',
                pickHour: 'conseguir tiempo',
                incrementHour: 'aumentar el tiempo',
                decrementHour: 'disminuir el tiempo',
                pickMinute: 'obtener minutos',
                incrementMinute: 'aumentar minutos',
                decrementMinute: 'disminuir minutos',
                pickSecond: 'obtener segundos',
                incrementSecond: 'aumentar segundos',
                decrementSecond: 'disminuir segundos',
                togglePeriod: 'Cambio AM/PM',
                selectTime: 'seleccionar hora',
            },
            defaultDate: new Date("{{ $fechaini }}"),
            format: 'DD-MM-YYYY hh:mm:ss',
            locale: 'es',
            icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar-alt',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
            },
            buttons: {
            showClose: true,
            },
            ignoreReadonly:true,
        });
        $('#datetimepickertwo').datetimepicker({
            dayViewHeaderFormat: 'MMMM YYYY',
            tooltips: {
                close: 'cerrar',
                selectMonth: 'Seleccione el mes',
                prevMonth: 'Anterior',
                nextMonth: 'Siguiente',
                selectYear: 'Seleccionar año',
                prevYear: 'año anterior',
                nextYear: 'al año que viene',
                selectTime: 'seleccionar hora',
                selectDate: 'seleccionar fecha',
                prevDecade: 'periodo anterior',
                nextDecade: 'próximo periodo',
                selectDecade: 'Seleccionar periodo',
                prevCentury: 'el siglo pasado',
                nextCentury: 'el próximo siglo',
                pickHour: 'conseguir tiempo',
                incrementHour: 'aumentar el tiempo',
                decrementHour: 'disminuir el tiempo',
                pickMinute: 'obtener minutos',
                incrementMinute: 'aumentar minutos',
                decrementMinute: 'disminuir minutos',
                pickSecond: 'obtener segundos',
                incrementSecond: 'aumentar segundos',
                decrementSecond: 'disminuir segundos',
                togglePeriod: 'Cambio AM/PM',
                selectTime: 'seleccionar hora',
            },
            defaultDate: new Date("{{ $fechater }}"),
            format: 'DD-MM-YYYY hh:mm:ss',
            locale: 'es',
            icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar-alt',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
            },
            buttons: {
            showClose: true,
            },
            ignoreReadonly:true,
        });
        $('#datetimepickerthree').datetimepicker({
            dayViewHeaderFormat: 'MMMM YYYY',
            tooltips: {
                close: 'cerrar',
                selectMonth: 'Seleccione el mes',
                prevMonth: 'Anterior',
                nextMonth: 'Siguiente',
                selectYear: 'Seleccionar año',
                prevYear: 'año anterior',
                nextYear: 'al año que viene',
                selectTime: 'seleccionar hora',
                selectDate: 'seleccionar fecha',
                prevDecade: 'periodo anterior',
                nextDecade: 'próximo periodo',
                selectDecade: 'Seleccionar periodo',
                prevCentury: 'el siglo pasado',
                nextCentury: 'el próximo siglo',
                pickHour: 'conseguir tiempo',
                incrementHour: 'aumentar el tiempo',
                decrementHour: 'disminuir el tiempo',
                pickMinute: 'obtener minutos',
                incrementMinute: 'aumentar minutos',
                decrementMinute: 'disminuir minutos',
                pickSecond: 'obtener segundos',
                incrementSecond: 'aumentar segundos',
                decrementSecond: 'disminuir segundos',
                togglePeriod: 'Cambio AM/PM',
                selectTime: 'seleccionar hora',
            },
            defaultDate: new Date("{{ $fechareu }}"),
            format: 'DD-MM-YYYY hh:mm:ss',
            locale: 'es',
            icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar-alt',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
            },
            buttons: {
            showClose: true,
            },
            ignoreReadonly:true,
        });
    });
    function solicitaractas(valida, tipo, validu, adic)
    {
        switch (true) {
            case (tipo == 'addact'):
                $('#staticBackdrop').modal('show');
            break;
            case (tipo == 'emailteacher'):
                
                $('#staticBackdropLabel').html("{{ trans('multi-new.0168')}}");
                $('#modalbody').html(`<div class="mb-3">
                                                <label for="asunto" class="form-label">{{ trans('multi-new.0117')}}</label>
                                                <input type="text" class="form-control" id="asunto" name="asunto" maxlength="200" aria-describedby="asuntoHelp">
                                                <small id="asuntoHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mensaje" class="form-label">{{ trans('multi-new.0035')}}</label>
                                                <textarea class="" name="mensaje" id="mensaje" rows="10" style="height:150px !important;width:100%;resize:none;" maxlength="1000"></textarea>
                                                <small id="mensajeHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <input type="hidden" id="idact" name="idact" value="${valida}">
                                            <input type="hidden" id="idus" name="idus" value="${validu}">
                                            <input type="hidden" id="tipoop" name="tipoop" value="${tipo}">
                                            <button class="btn btn-primary btn-sm" id="sendfunc">{{ trans('lang.enviar')}}</button>`);
                $('#modalfooter').html(`<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
                {{ trans('lang.cancelar')}}
                </button>`); 
                $('#staticBackdrop').modal('show');  
            break;
            case (tipo == 'notificaciones'):

                var formData = new FormData();
                formData.append("idact", valida);
                formData.append("idus", validu);
                formData.append("tipo", tipo);

                ajax(formData, tipo);

            break;
            case (tipo == 'respuestaemail'):
                var text = adic.replaceAll("*%%%%%%*", "\n");
                text = text.replaceAll("%%*********************************%%", "\n*********************************\n");
                $('#staticBackdrop').modal('hide');
                $('#staticBackdropLabeltwo').html("{{ trans('multi-new.0126')}}");
                $('#modalbodytwo').html(`<div class="mb-3">
                                                <label for="asunto" class="form-label">{{ trans('multi-new.0130')}}</label>
                                                <textarea class="" name="mensaje" id="mensaje" rows="10" style="height:120px !important;width:100%;resize:none;" maxlength="1000" disabled>${valida}</textarea>
                                                <small id="asuntoHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="asunto" class="form-label">{{ trans('multi-new.0166')}}</label>
                                                <textarea class="" name="respuesta" id="respuesta" rows="10" style="height:120px !important;width:100%;resize:none;" maxlength="1000" disabled>${text}</textarea>
                                                <small id="respuestaHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mensajeresp" class="form-label">{{ trans('multi-new.0035')}}</label>
                                                <textarea class="" name="mensajeresp" id="mensajeresp" rows="10" style="height:120px !important;width:100%;resize:none;" maxlength="1000"></textarea>
                                                <small id="mensajeHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            
                                            <input type="hidden" id="idmensresp" name="idmensresp" value="${validu}">
                                            <input type="hidden" id="tipoopresp" name="tipoopresp" value="${tipo}">
                                            <button class="btn btn-primary btn-sm" id="sendfunctwo">{{ trans('lang.enviar')}}</button>`);
                $('#modalfootertwo').html(`<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
                {{ trans('lang.cancelar')}}
                </button>`); 
                $('#staticBackdroptwo').modal('show');
            break;
            case (tipo == 'imprimir'):

                var formData = new FormData();
                formData.append("idact", valida);
                formData.append("idus", validu);
                formData.append("tipo", tipo);

                ajax(formData, tipo);

            break;
            case (tipo == 'temas'):

                var error = "";

                var input;
                
                input = $("#tema").val().trim();

                if (input === "") {
                    
                    error += "{{ trans('multi-new.0172')}}"+'<br>';
                }
                if (input.length < 2) {

                    error += "{{ trans('multi-new.0173')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0174')}}"+'<br>';
                }

                
                if(error !== "")
                {
                    notificacion(error, "danger", "{{ trans('multi-new.0124')}}");
                }
                else
                {
                    var formData = new FormData();
                    if (tipo === "temas") 
                    {
                        
                        formData.append("idacta", valida);
                        formData.append("idus", validu);
                        formData.append("tipo", tipo);
                        formData.append("tema", $('#tema').val());
                        formData.append("idhis", adic);
                        ajax(formData, tipo);
                    }
                    
                    
                    
                }

            break;
            case (tipo == 'acuerdos'):

                var error = "";

                var input;

                input = $("#acuerdo").val().trim();

                if (input === "") {
                    
                    error += "{{ trans('multi-new.0179')}}"+'<br>';
                }
                if (input.length < 2) {

                    error += "{{ trans('multi-new.0180')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0183')}}"+'<br>';
                }


                if(error !== "")
                {
                    notificacion(error, "danger", "{{ trans('multi-new.0124')}}");
                }
                else
                {
                    var formData = new FormData();
                    if (tipo === "acuerdos") 
                    {
                        
                        formData.append("idacta", valida);
                        formData.append("idus", validu);
                        formData.append("tipo", tipo);
                        formData.append("tema", $('#acuerdo').val());
                        formData.append("idhis", adic);
                        ajax(formData, tipo);
                    }
                    
                    
                    
                }

            break;
            case (tipo == 'compromisos'):

                var error = "";

                var input;

                input = $("#compromiso").val().trim();

                if (input === "") {
                    
                    error += "{{ trans('multi-new.0181')}}"+'<br>';
                }
                if (input.length < 2) {

                    error += "{{ trans('multi-new.0182')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0184')}}"+'<br>';
                }


                if(error !== "")
                {
                    notificacion(error, "danger", "{{ trans('multi-new.0124')}}");
                }
                else
                {
                    var formData = new FormData();
                    if (tipo === "compromisos") 
                    {
                        
                        formData.append("idacta", valida);
                        formData.append("idus", validu);
                        formData.append("tipo", tipo);
                        formData.append("tema", $('#compromiso').val());
                        formData.append("idhis", adic);
                        ajax(formData, tipo);
                    }
                    
                    
                    
                }

            break;
            case (tipo == 'agendarreunion'):
                
                $('#staticBackdropLabel').html("{{ trans('multi-new.0155')}}");
                $('#modalbody').html(`<div class="form-group row">
                                                <label for="datetimepickeronemodal" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-black mt-2 mb-2">
                                                    {{ trans('multi-new.0089')}}:
                                                    &nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0090')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 input-group date mt-2" id="datetimepickeronemodal" data-target-input="nearest">
                                                    <input type="text" id="fechainiconfigmodal" name="fechainiconfigmodal" class="form-control datetimepicker-input" data-target="#datetimepickeronemodal" />
                                                    <div class="input-group-text" data-target="#datetimepickeronemodal" data-toggle="datetimepicker">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="idact" name="idact" value="${valida}">
                                            <input type="hidden" id="idus" name="idus" value="${validu}">
                                            <input type="hidden" id="tipoop" name="tipoop" value="${tipo}">
                                            <input type="hidden" id="idacthis" name="idacthis" value="${adic}">
                                            <button class="btn btn-primary btn-sm" id="sendfuncmodal">{{ trans('lang.enviar')}}</button>`);
                $('#modalfooter').html(`<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
                {{ trans('lang.cancelar')}}
                </button>`);
                
                $('#datetimepickeronemodal').datetimepicker({
                    dayViewHeaderFormat: 'MMMM YYYY',
                    tooltips: {
                        close: 'cerrar',
                        selectMonth: 'Seleccione el mes',
                        prevMonth: 'Anterior',
                        nextMonth: 'Siguiente',
                        selectYear: 'Seleccionar año',
                        prevYear: 'año anterior',
                        nextYear: 'al año que viene',
                        selectTime: 'seleccionar hora',
                        selectDate: 'seleccionar fecha',
                        prevDecade: 'periodo anterior',
                        nextDecade: 'próximo periodo',
                        selectDecade: 'Seleccionar periodo',
                        prevCentury: 'el siglo pasado',
                        nextCentury: 'el próximo siglo',
                        pickHour: 'conseguir tiempo',
                        incrementHour: 'aumentar el tiempo',
                        decrementHour: 'disminuir el tiempo',
                        pickMinute: 'obtener minutos',
                        incrementMinute: 'aumentar minutos',
                        decrementMinute: 'disminuir minutos',
                        pickSecond: 'obtener segundos',
                        incrementSecond: 'aumentar segundos',
                        decrementSecond: 'disminuir segundos',
                        togglePeriod: 'Cambio AM/PM',
                        selectTime: 'seleccionar hora',
                    },
                    defaultDate: new Date("{{ $fechareu }}"),
                    format: 'DD-MM-YYYY hh:mm:ss',
                    locale: 'es',
                    icons: {
                        time: 'far fa-clock',
                        date: 'far fa-calendar-alt',
                        up: 'fas fa-arrow-up',
                        down: 'fas fa-arrow-down',
                    },
                    buttons: {
                    showClose: true,
                    },
                    ignoreReadonly:true,
                });
                $('#staticBackdrop').modal('show');  
            break;
        
            default:
            break;
        }
    }
    
    $('#staticBackdroptwo').on('shown.bs.modal', function () {
        $('[data-toggle="tooltip"]').tooltip();
        $( "#sendfunctwo" ).on( "click", function(event) {

            event.preventDefault();

            var error = "";

            var input;
            
            if ($("#tipoopresp").val() === "respuestaemail") {
                
                input = $("#mensajeresp").val().trim();

                if (input === "") {
                    
                    error += "{{ trans('multi-new.0127')}}"+'<br>';
                }
                if (input.length < 2) {

                    error += "{{ trans('multi-new.0128')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0129')}}"+'<br>';
                }
            }

            
            if(error !== "")
            {
                notificacion(error, "danger", "{{ trans('multi-new.0124')}}");
            }
            else
            {
                
                var formData = new FormData();
                if ($("#tipoopresp").val() === "respuestaemail") 
                {
                    formData.append("idmens", $('#idmensresp').val());
                    formData.append("tipo", $('#tipoopresp').val());
                    formData.append("mensaje", $('#mensajeresp').val());
                    ajax(formData, $("#tipoopresp").val());
                }
                
                
            }
        } );

        
    });
    $('#staticBackdrop').on('shown.bs.modal', function () {
        $('[data-toggle="tooltip"]').tooltip();
        $( "#sendfunc" ).on( "click", function(event) {

            event.preventDefault();

            var error = "";

            var input;

            if ($("#tipoop").val() === "emailteacher") {
                
                input = $("#asunto").val().trim();

                if (input === "") {
                    
                    error += "{{ trans('multi-new.0118')}}"+'<br>';
                }
                if (input.length < 2) {

                    error += "{{ trans('multi-new.0119')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0120')}}"+'<br>';
                }
                input = $("#mensaje").val().trim();
                if (input === "") {
                    
                    error += "{{ trans('multi-new.0121')}}"+'<br>';
                }
                if (input.length < 2) {

                    error += "{{ trans('multi-new.0122')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0123')}}"+'<br>';
                }
            }

            
            if(error !== "")
            {
                notificacion(error, "danger", "{{ trans('multi-new.0124')}}");
            }
            else
            {
                
                var formData = new FormData();
                if ($("#tipoop").val() === "emailteacher") 
                {
                    formData.append("idact", $('#idact').val());
                    formData.append("idus", $('#idus').val());
                    formData.append("tipo", $('#tipoop').val());
                    formData.append("asunto", $('#asunto').val());
                    formData.append("mensaje", $('#mensaje').val());
                    ajax(formData, $("#tipoop").val());
                }
                
                
            }
        } );
        $( "#sendfuncmodal" ).on( "click", function(event) {

            event.preventDefault();

            var error = "";

            var datetimeini = moment($("#fechainiconfig").val(), 'DD-MM-YYYY HH:mm:ss', true); 

            var datetimefin = moment($("#fechafinconfig").val(), 'DD-MM-YYYY HH:mm:ss', true);

            var datetimereu = moment($("#fechainiconfigmodal").val(), 'DD-MM-YYYY HH:mm:ss', true); 


            var now = moment();


            if (!datetimeini.isValid()) 
            {

                error += "{{ trans('multi-new.0144')}}"+"<br>";

            }

            if (!datetimefin.isValid()) 
            {

                error += "{{ trans('multi-new.0145')}}"+"<br>";

            }

            /*if (datetimeini.isBefore(now)) 
            {

                error += "{{ trans('multi-new.0146')}}"+"<br>";

            }*/


            if (datetimefin.isBefore(now)) 
            {

                error += "{{ trans('multi-new.0147')}}"+"<br>";

            }

            if (datetimefin.isBefore(datetimeini)) 
            {

                error += "{{ trans('multi-new.0148')}}"+"<br>";

            }

            var valor_1 = $("#porcentaje").val();

            if(valor_1 > 100)
            {

                error += "{{ trans('multi-new.0149')}}"+"<br>";

            }

            if(valor_1 < 0 || valor_1 == '' || valor_1 == 0)
            {

                error += "{{ trans('multi-new.0150')}}"+"<br>";

            }

            if (!datetimereu.isBetween(datetimeini, datetimefin, null, '[]')) 
            {

                error += "{{ trans('multi-new.0151')}}" + "<br>";

            }
            if (error != '') 
            {
                
                notificacion(error, "danger", "{{ trans('multi-new.0152')}}");
                
            }
            else
            {
                var formData = new FormData();
                formData.append("idact", $('#idact').val());
                formData.append("idus", $('#idus').val());
                formData.append("tipo", $('#tipoop').val());
                formData.append("idacthis", $('#idacthis').val());
                formData.append("datetimereu", datetimereu);
                ajax(formData, $("#tipoop").val());
            }
        } );

        
    });
    function caracteres(input)
    {
        // Expresiones regulares para detectar patrones sospechosos
        const sqlPattern = /(\b(SELECT|INSERT|DELETE|UPDATE|DROP|ALTER|TRUNCATE|EXEC|UNION|SCRIPT|ONERROR|ONLOAD)\b)|(--|\bOR\b|\bAND\b|;|%|')/i;
        const scriptPattern = /(<script\b|\bon\w+=|\bjavascript:|\bvbscript:|<\s*a\b|\bsrc=[^>]+>|<iframe\b|<img\b)/i;
    
        // Comprobando si el input coincide con los patrones de ataque.
        return !sqlPattern.test(input) && !scriptPattern.test(input)

    }
    function notificacion(text, tipo, title)
    {
        $.notify({
            // options
            title: '<strong>'+title+'</strong>',
            message: text,
        icon: false,
        },{
            // settings
            element: 'body',
            position: null,
            type: tipo,
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 999999,
            delay: 3300,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated flipInY',
                exit: 'animated flipOutX'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
        });
    }
    
    function ajax(form, tipo)
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{url("/")}}/funcionalidades-ajax-usuario-docente-actas',
            data: form,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(respu)
            {
                
                if( respu.status === "ok" && tipo === "imprimir" )
                {
                    downloadPDF(respu.pdf, "Actas.pdf");
                    notificacion("{{ trans('multi-new.0185')}}", "success", "{{ trans('multi-new.0186')}}");
                    
                }
                else if( respu.status === "ok" && tipo === "agendarreunion" )
                {
                    $("#fechareuconfig").val(respu.fecha);
                    console.log('fechadd', respu.fecha);
                    $('#staticBackdrop').modal('hide');
                    
                    notificacion("{{ trans('multi-new.0169')}}", "success", "{{ trans('multi-new.0125')}}");
                    
                    
                }
                else if( respu.status === "error" && tipo === "agendarreunion" )
                {
                    $('#staticBackdrop').modal('hide');
                    notificacion("{{ trans('multi-new.0167')}}", "success", "{{ trans('multi-new.0133')}}");
                    
                }
                else if( respu.status === "ok" && tipo === "emailteacher" )
                {
                    $('#staticBackdrop').modal('hide');
                    notificacion("{{ trans('multi-new.0169')}}", "success", "{{ trans('multi-new.0125')}}");
                    
                }
                else if( respu.status === "ok" && tipo === "respuestaemail" )
                {
                    $('#staticBackdroptwo').modal('hide');
                    notificacion("{{ trans('multi-new.0167')}}", "success", "{{ trans('multi-new.0133')}}");
                    
                }
                else if( respu.status === "error" && tipo === "respuestaemail" )
                {
                    $('#staticBackdroptwo').modal('hide');
                    notificacion("{{ trans('multi-new.0134')}}", "danger", "{{ trans('multi-new.0135')}}");
                    
                }
                else if( respu.status === "ok" && tipo === "temas" )
                {
                    $('#tema').val('');
                    
                    if(respu.html.length > 0)
                    {
                        const obj = JSON.parse(respu.html);
                        var html = "";
                        Object.keys(obj).forEach(key => {

                            
                            
                            if (typeof obj[key].temas !== 'undefined' && obj[key].temas !== null && obj[key].temas !== '')
                            {
                                var temp = "";
                                var i = 0;
                                var arrayFrutas = obj[key].temas.split("<br>");
                                for(i = 0; i < arrayFrutas.length; i++)
                                {
                                    temp += (i+1)+'.- '+arrayFrutas[i]+'<br>';
                                }
                                html += `<tr>
                                    <td>${temp}</td>
                                    <td>${moment(obj[key].fechatemas, 'YYYY-MM-DD HH:mm:ss').format('DD-MM-YYYY HH:mm:ss')}</td>
                                </tr>`;
                                
                            }
                            
                            $('#resumenactas').html(html);
                            
                        });
                    }
                    notificacion("{{ trans('multi-new.0133')}}", "success", "{{ trans('multi-new.0176')}}");
                    
                }
                else if( respu.status === "error" && tipo === "temas" )
                {
                    $('#tema').val('');
                    notificacion("{{ trans('multi-new.0134')}}", "danger", "{{ trans('multi-new.0175')}}");
                    
                }
                else if( respu.status === "ok" && tipo === "acuerdos" )
                {
                    $('#acuerdo').val('');
                    
                    if(respu.html.length > 0)
                    {
                        const obj = JSON.parse(respu.html);
                        var html = "";
                        Object.keys(obj).forEach(key => {

                            
                            
                            if (typeof obj[key].acuerdos !== 'undefined' && obj[key].acuerdos !== null && obj[key].acuerdos !== '')
                            {
                                var temp = "";
                                var i = 0;
                                var arrayFrutas = obj[key].acuerdos.split("<br>");
                                for(i = 0; i < arrayFrutas.length; i++)
                                {
                                    temp += (i+1)+'.- '+arrayFrutas[i]+'<br>';
                                }
                                html += `<tr>
                                    <td>${temp}</td>
                                    <td>${moment(obj[key].fechaacuerdos, 'YYYY-MM-DD HH:mm:ss').format('DD-MM-YYYY HH:mm:ss')}</td>
                                </tr>`;
                                
                            }
                            
                            $('#resumenacuerdos').html(html);
                            
                        });
                    }
                    notificacion("{{ trans('multi-new.0133')}}", "success", "{{ trans('multi-new.0187')}}");
                    
                }
                else if( respu.status === "error" && tipo === "acuerdos" )
                {
                    $('#acuerdos').val('');
                    notificacion("{{ trans('multi-new.0134')}}", "danger", "{{ trans('multi-new.0188')}}");
                    
                }
                else if( respu.status === "ok" && tipo === "compromisos" )
                {
                    $('#compromiso').val('');
                    
                    if(respu.html.length > 0)
                    {
                        const obj = JSON.parse(respu.html);
                        var html = "";
                        Object.keys(obj).forEach(key => {

                            
                            
                            if (typeof obj[key].compromisos !== 'undefined' && obj[key].compromisos !== null && obj[key].compromisos !== '')
                            {
                                var temp = "";
                                var i = 0;
                                var arrayFrutas = obj[key].compromisos.split("<br>");
                                for(i = 0; i < arrayFrutas.length; i++)
                                {
                                    temp += (i+1)+'.- '+arrayFrutas[i]+'<br>';
                                }
                                html += `<tr>
                                    <td scope="row">${temp}</td>
                                    <td scope="row">${moment(obj[key].fechacompromisos, 'YYYY-MM-DD HH:mm:ss').format('DD-MM-YYYY HH:mm:ss')}</td>
                                </tr>`;
                                
                            }
                            
                            $('#resumencompromisos').html(html);
                            
                        });
                    }
                    notificacion("{{ trans('multi-new.0133')}}", "success", "{{ trans('multi-new.0189')}}");
                    
                }
                else if( respu.status === "error" && tipo === "compromisos" )
                {
                    $('#compromiso').val('');
                    notificacion("{{ trans('multi-new.0134')}}", "danger", "{{ trans('multi-new.0190')}}");
                    
                }
                else if( respu.status === "ok" && tipo === "notificaciones" )
                {
                    var html = "";

                    if(respu.html.length > 0)
                    {
                        const obj = JSON.parse(respu.html);

                        Object.keys(obj).forEach(key => {

                            var btn = "";
                            
                            if (typeof obj[key].respuesta !== 'undefined' && obj[key].respuesta !== null)
                            {
                                console.log("obj[key].respuesta.length", obj[key].respuesta.length);
                                var text1 = obj[key].respuesta.replaceAll("*%%%%%%*", "<br>");
                                text1 = text1.replaceAll("%%*********************************%%", "<br>*********************************<br>"); 
                            }
                            else
                            {
                                var text1 = "";
                            }
                            
                            html += `<tr>
                                                <th colspan="2" class="text-center" scope="col">/********************************************/</th>
                                            </tr>
                                            <tr>
                                                <th scope="col" class="text-left" style="width:40%">{{ trans('multi-new.0095')}}</th>
                                                <th scope="col" class="text-left">${obj[key].name} ${obj[key].surname}</th>
                                            </tr>
                                            <tr>
                                                <th scope="col" class="text-left" style="width:40%">{{ trans('multi-new.0117')}}</th>
                                                <th scope="col" class="text-left">${obj[key].asunto}</th>
                                            </tr>
                                            <tr>
                                                <th scope="col" class="text-left" style="width:40%">{{ trans('multi-new.0035')}}</th>
                                                <th scope="col" class="text-left">${obj[key].mensaje}</th>
                                            </tr>
                                            <tr>
                                                <th scope="col" class="text-left" style="width:40%">{{ trans('multi-new.0166')}}</th>
                                                <th scope="col" class="text-left">${text1}</th>
                                            </tr>
                                            <tr>
                                                <th scope="col" class="text-left" style="width:40%">{{ trans('multi-new.0197')}}</th>
                                                <th scope="col" class="text-left">${moment(obj[key].fechanot, 'YYYY-MM-DD H:mm:ss').format('DD-MM-YYYY H:mm:ss')}</th>
                                            </tr>
                                            <tr>
                                                <th scope="col" class="text-left" style="width:40%">{{ trans('multi-new.0198')}}</th>
                                                <th scope="col" class="text-left">${moment(obj[key].fechares, 'YYYY-MM-DD H:mm:ss').format('DD-MM-YYYY H:mm:ss')}</th>
                                            </tr>
                                            <tr>
                                                <th scope="col" class="text-left" style="width:40%">{{ trans('multi-new.0036')}}</th>
                                                <th scope="col" class="text-left"><button class="btn btn-primary" id="mensaje" onclick="solicitaractas('${obj[key].mensaje}', 'respuestaemail',  '${obj[key].id}', '${obj[key].respuesta}')">{{ trans('multi-new.0199')}}</button></th>
                                            </tr>`;
                        });
                    }
                    
                    
                    $('#staticBackdropLabel').html("{{ trans('multi-new.0064')}}");
                    $('#modalbody').html(`<div class='col-12 table-responsive'>
                                        <table id="dt-mant-table" class="table table-bordered table-hober  display responsive" style="width:100%;">
                                           <tbody>
                                            ${html}                                         
                                            </tbody>
                                        </table></div>`);
                    $('#modalfooter').html(`<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
                    {{ trans('lang.cancelar')}}
                    </button>`); 
                    $('#staticBackdrop').modal('show');
                    
                    
                }
                else
                {
                    $('#staticBackdrop').modal('hide');
                    console.log("error");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $('#staticBackdrop').modal('hide');
            }
        });
    }

    function downloadPDF(pdf,fileName) 
    {
        const linkSource = `data:application/pdf;base64,${pdf}`;
        const downloadLink = document.createElement("a");
        downloadLink.href = linkSource;
        downloadLink.download = fileName;
        downloadLink.click();
    }

</script>
@endsection
