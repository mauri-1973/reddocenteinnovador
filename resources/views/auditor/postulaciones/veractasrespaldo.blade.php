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
                @if($value == 0)
                <div class="col-md-12">
                    <div class="card mb-4 bg-success shadow-sm text-white">
                        <div class="card-body">
                            <h3><strong>{{ trans('multi-new.0052')}} </strong></h3><br><br>
                            @if(Auth::user()->hasRole('auditor')  )
                            <a href="{{ route('ver-asignaciones-auditor-id-postulacion', $idconc) }}" class="btn btn-info btn-sm">{{ trans('lang.volver')}}</a>
                            <button class="btn btn-warning btn-sm" onclick="solicitaractas('{{ $id }}', 1)">{{ trans('multi-new.0053')}}</button>
                            @endif
                        </div>
                        
                    </div>
                </div>
                @else
                <div class="col-md-12">
                    <div class="card mb-4 bg-success shadow-sm text-white">
                        <div class="card-body">

                            @if($count == 0)
                                <h3><strong>{{ trans('multi-new.0052')}} </strong></h3><br><br>
                                @if(Auth::user()->hasRole('auditor')  )
                                <a href="{{ route('ver-asignaciones-auditor-id-postulacion', $idconc) }}" class="btn btn-info btn-sm">{{ trans('lang.volver')}}</a>
                                <button class="btn btn-warning btn-sm" onclick="solicitaractas('{{ $id }}', 2)">{{ trans('multi-new.0053')}}</button>
                                @endif
                            @elseif($count == 1)
                                @if(is_array($actas))
                                    <h3><strong>{{ trans('multi-new.0054')}} </strong></h3><br><br>
                                    @if(Auth::user()->hasRole('auditor')  )
                                    <a href="{{ route('ver-asignaciones-auditor-id-postulacion', $idconc) }}" class="btn btn-info btn-sm">{{ trans('lang.volver')}}</a>
                                    <button class="btn btn-danger btn-sm" onclick="solicitaractas('{{ $id }}', 4)">Reportar Error</button>
                                    @endif
                                @elseif($actas->count() == 1)
                                    <div class="content-fluid">
                                        @if($actas[0]->fecha_ini == '' || $actas[0]->fecha_ini == null)
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <a href="{{ route('ver-asignaciones-auditor-id-postulacion', $idconc) }}" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0055')}}">{{ trans('lang.volver')}} <i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{ url('funcionalidades-ajax-usuario-auditor')}}">
                                                @csrf
                                                    <input type="hidden" id="idacta" name="idacta" value="{{ Crypt::encrypt($actas[0]->id) }}" required>
                                                    <input type="hidden" id="idansw" name="idansw" value="{{ $id }}" required>
                                                    <input type="hidden" id="tipo" name="tipo" value="1" required>
                                                    <button type="submit" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0056') }}">{{ trans('multi-new.0057')}} <i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                </form>
                                                
                                            </div>
                                        </div>
                                        @else
                                        <div class="container demo">
                                            
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <a href="{{ route('ver-asignaciones-auditor-id-postulacion', $idconc) }}" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0065') }}">{{ trans('lang.volver')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></a>
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
                                                        <a href="{{ route('imprimr-formulario-auditor', $id) }}" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0067') }}">{{ trans('multi-new.0062')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></a>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <button type="button" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0068') }}" onclick="solicitaractas('{{ Crypt::encrypt($actas[0]->id) }}', 'emailteacher', '{{ Crypt::encrypt($defansw->id) }}')">{{ trans('multi-new.0063')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></button>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <button type="button" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0069') }}" onclick="solicitaractas('{{ Crypt::encrypt($actas[0]->id) }}', 'notificaciones', '{{ Crypt::encrypt($defansw->id) }}')">{{ trans('multi-new.0064')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:" ></i></button>
                                                    </div>
                                                </div> 
                                                
                                                
                                                @foreach($arreglo as $y => $sli)
                                                
                                                    @foreach($arreglo[$y] as $new => $n)
                                                    
                                                        @foreach($arreglo[$y]['arrayactas'] as $fin => $f)
                                                        
                                                            
                                                            @foreach($arreglo[$y]['arrayactas'][$fin] as $cua => $c)
                                                            
                                                                
                                                                @if($cua == 'auditores')
                                                                
                                                                    @foreach($arreglo[$y]['arrayactas'][$fin][$cua] as $ja => $j)
                                                                    
                                                                        @if($ja == 0)
                                                                        
                                                                            

                                                                        @endif

                                                                    @endforeach
                                                                        
                                                                @endif
                                                                
                                                            @endforeach

                                                        @endforeach

                                                    @endforeach
                                                        
                                                @endforeach
                                                <!--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    5
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    6
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    7
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    8
                                                </div>-->
                                            </div>
                                            
	
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingOne" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0100')}}">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:#004238;text-decoration:none;">
                                                                <strong>{{ trans('multi-new.0070')}}</strong><i class="nc-icon nc-tap-01" style="font-size:20px;color:">&nbsp;</i> <i class="nc-change nc-icon nc-simple-add float-right" style="font-size:25px;#004238;"></i>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse collapse mb-3" role="tabpanel" aria-labelledby="headingOne">
                                                        <div class="panel-body">
                                                            <h3><strong>{{ trans('multi-new.0096')}}: </strong></h3>
                                                            <div class="col-12 border border-white pt-2 pb-2">
                                                                <div class="container-fluid">
                                                                    @foreach($arreglo[0]["arrayactas"] as $ar => $a)
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                            {{ trans('multi-new.0095')}}: {{ $a['nombreaudit'] }}
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                                Email: {{ $a['emailauditor'] }}
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                            {{ trans('multi-new.0094')}}: {{ $a['mobauditor'] }}
                                                                            </div>
                                                                        </div>
                                                                        @if($ar > 0)
                                                                        <hr style="border: 1px solid white;">
                                                                        @endif
                                                                    @endforeach
                                                                    <hr style="border: 1px solid white;">
                                                                    @foreach($arreglo[0]["arrayactasext"] as $ar => $a)
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                            {{ trans('multi-new.0095')}}: {{ $a['nombreaudit'] }}
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                                Email: {{ $a['emailauditor'] }}
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                            {{ trans('multi-new.0094')}}: {{ $a['mobauditor'] }}
                                                                            </div>
                                                                        </div>
                                                                        @if($ar > 0)
                                                                        <hr style="border: 1px solid white;">
                                                                        @endif

                                                                    @endforeach
                                                                    
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <h3><strong>{{ trans('multi-new.0097')}}: </strong></h3>
                                                            <div class="col-12 border border-white pt-2 pb-2">
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                        {{ trans('multi-new.0093')}}: {{$defansw->name.' '.$defansw->surname}}
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                            Email: {{$defansw->email}}
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                        {{ trans('multi-new.0094')}}: {{$defansw->mobile}}
                                                                        </div>
                                                                    </div>
                                                                    <hr style="border: 1px solid white;">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                        {{ trans('multi-new.0099')}}: {{$defansw->titulo }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <h3><strong>{{ trans('multi-new.0098')}}: 10% </strong></h3>
                                                            <div class="col-12 border border-white pt-2 pb-2">
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="progress mt-2 mb-2">
                                                                                <div class="progress-bar w-10 bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10%</div> 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                               <!-- <div class="panel panel-default">
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
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                    <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0103') }}">{{ trans('multi-new.0102')}} {{ date('d-m-Y') }}--{{ date('d-m-Y') }}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></button>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                    <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0103') }}">{{ trans('multi-new.0102')}} {{ date('d-m-Y') }}--{{ date('d-m-Y') }}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></button>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                    <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0103') }}">{{ trans('multi-new.0102')}} {{ date('d-m-Y') }}--{{ date('d-m-Y') }}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></button>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                    <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0103') }}">{{ trans('multi-new.0102')}} {{ date('d-m-Y') }}--{{ date('d-m-Y') }}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>panel-group -->
                                            
                                            
                                        </div><!-- container -->
                                        
                                        @endif
                                    
                                @else
                                    <h3>{{ trans('multi-new.0054')}} </strong></h3><br><br>
                                    @if(Auth::user()->hasRole('auditor')  )
                                    <a href="{{ route('ver-asignaciones-auditor-id-postulacion', $idconc) }}" class="btn btn-info btn-sm">{{ trans('lang.volver')}}</a>
                                    <button class="btn btn-danger btn-sm" onclick="solicitaractas('{{ $id }}', 5)">Reportar Error</button>
                                    @endif
                                @endif
                            
                            @else
                                <h3>{{ trans('multi-new.0054')}} </strong></h3><br><br>
                                @if(Auth::user()->hasRole('auditor')  )
                                <a href="{{ route('ver-asignaciones-auditor-id-postulacion', $idconc) }}" class="btn btn-info btn-sm">{{ trans('lang.volver')}}</a>
                                <button class="btn btn-danger btn-sm" onclick="solicitaractas('{{ $id }}', 3)">Reportar Error</button>
                                @endif
                            @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4 bg-success shadow-sm text-white">
                        <div class="card-body">
                            <button class="btn btn-info btn-sm btn-block" onclick="solicitaractas('{{ $id }}', 'addact')" disabled>
                            {{ trans('multi-new.0073')}}&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0104')}}" data-html="true" data-original-title=""></i>
                            </button> 
                            
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
                                                        <div class="progress-bar w-10 bg-info" id="progressgen" name="progressgen" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                            10%
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
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepickerone" disabled/>
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
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepickertwo" disabled/>
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
                                                    <input type="number" class="form-control input-lg" id="porcentaje" name="porcentaje" value="" min="0" max="100" disabled/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="datetimepickerthree" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    {{ trans('multi-new.0089')}}:
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0090')}}"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 input-group date mt-2" id="datetimepickerthree" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepickerthree"/>
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
                                                    <input type="number" class="form-control input-lg" id="porcentajeaud" name="porcentajeaud" min="0" max="100" value="" onkeypress="return valideKey(event);"/>
                                                </div>
                                            </div>
                                            <!--<button type="submit" class="btn btn-primary">Submit</button>-->
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <div class="col-12 mt-5">
                                            <div class="form-group row">
                                                <label for="tema" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    Docente
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="Seleccione los tags, a los que quedará asociada el concurso, esto le permitirá agrupar concursos relacionadas"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="tema" name="tema" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="auditor_1" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    Auditor_1
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="Seleccione los tags, a los que quedará asociada el concurso, esto le permitirá agrupar concursos relacionadas"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="auditor_1" name="auditor_1" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="auditor_1" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    Auditor_2
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="Seleccione los tags, a los que quedará asociada el concurso, esto le permitirá agrupar concursos relacionadas"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="auditor_2" name="auditor_2" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <div class="col-12 mt-5">
                                            <div class="form-group row">
                                                <label for="tema" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    Docente
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="Seleccione los tags, a los que quedará asociada el concurso, esto le permitirá agrupar concursos relacionadas"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="tema" name="tema" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="auditor_1" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    Auditor_1
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="Seleccione los tags, a los que quedará asociada el concurso, esto le permitirá agrupar concursos relacionadas"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="auditor_1" name="auditor_1" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="auditor_1" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    Auditor_2
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="Seleccione los tags, a los que quedará asociada el concurso, esto le permitirá agrupar concursos relacionadas"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="auditor_2" name="auditor_2" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-comp" role="tabpanel" aria-labelledby="nav-comp-tab">
                                        <div class="col-12 mt-5">
                                            <div class="form-group row">
                                                <label for="tema" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    Docente
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="Seleccione los tags, a los que quedará asociada el concurso, esto le permitirá agrupar concursos relacionadas"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="tema" name="tema" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="auditor_1" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    Auditor_1
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="Seleccione los tags, a los que quedará asociada el concurso, esto le permitirá agrupar concursos relacionadas"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="auditor_1" name="auditor_1" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="auditor_1" class="col-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label text-white mt-2 mb-2">
                                                    Auditor_2
                                                    &nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-html="true" data-original-title="Seleccione los tags, a los que quedará asociada el concurso, esto le permitirá agrupar concursos relacionadas"></i>
                                                </label>
                                                <div class="col-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-2 mb-2">
                                                    <textarea class="mt-2 mb-2 h-100 flex-grow-1" id="auditor_2" name="auditor_2" rows="7"  style="resize: none;min-height: 280px;width:100% !important;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
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
            defaultDate: new Date(),
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
            defaultDate: new Date(),
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
            defaultDate: null,
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
    function solicitaractas(valida, tipo, validu)
    {
        switch (true) {
            case (tipo == 'addact'):
                $('#staticBackdrop').modal('show');
            break;
            case (tipo == 'emailteacher'):
                
                $('#staticBackdropLabel').html("{{ trans('multi-new.0063')}}");
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
                $('#staticBackdrop').modal('hide');
                $('#staticBackdropLabeltwo').html("{{ trans('multi-new.0126')}}");
                $('#modalbodytwo').html(`<div class="mb-3">
                                                <label for="asunto" class="form-label">{{ trans('multi-new.0130')}}</label>
                                                <textarea class="" name="mensaje" id="mensaje" rows="10" style="height:150px !important;width:100%;resize:none;" maxlength="1000" disabled>${valida}</textarea>
                                                <small id="asuntoHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="mensajeresp" class="form-label">{{ trans('multi-new.0035')}}</label>
                                                <textarea class="" name="mensajeresp" id="mensajeresp" rows="10" style="height:150px !important;width:100%;resize:none;" maxlength="1000"></textarea>
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
        
            default:
            break;
        }
    }
    
    $('#staticBackdroptwo').on('shown.bs.modal', function () {
        
        $( "#sendfunctwo" ).on( "click", function(event) {

            event.preventDefault();

            var error = "";

            var input;

            if ($("#tipoop").val() === "respuestaemail") {
                
                
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
            url: '{{url("/")}}/funcionalidades-ajax-usuario-auditor',
            data: form,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(respu)
            {
                if( respu.status == "ok" && tipo === "emailteacher" )
                {
                    $('#staticBackdrop').modal('hide');
                    notificacion("{{ trans('multi-new.0131')}}", "success", "{{ trans('multi-new.0124')}}");
                    
                }
                if( respu.status == "ok" && tipo === "respuestaemail" )
                {
                    $('#staticBackdroptwo').modal('hide');
                    notificacion("{{ trans('multi-new.0132')}}", "success", "{{ trans('multi-new.0133')}}");
                    
                }
                if( respu.status == "error" && tipo === "respuestaemail" )
                {
                    $('#staticBackdroptwo').modal('hide');
                    notificacion("{{ trans('multi-new.0134')}}", "success", "{{ trans('multi-new.0135')}}");
                    
                }
                if( respu.status == "ok" && tipo === "notificaciones" )
                {
                    const obj = JSON.parse(respu.html);

                    var html = "";

                    if(respu.html.length > 0)
                    {
                        const obj = JSON.parse(respu.html);

                        Object.keys(obj).forEach(key => {

                            var btn = "";

                            if(obj[key].btn == "si")
                            {
                                var btn = `<button class="btn btn-primary" id="mensaje" onclick="solicitaractas('${obj[key].mensaje}', 'respuestaemail',  '${obj[key].idmens}')">Enviar Respuesta</button>`;
                            }
                            html += `<tr>
                            <td>&nbsp;</td>
                            <td>${obj[key].nombre}</td>
                            <td>${obj[key].asunto}</td>
                            <td>${obj[key].mensaje}</td>
                            <td>${obj[key].respuesta}</td>
                            <td>${obj[key].fechacre}</td>
                            <td>${obj[key].fechaact}</td>
                            <td>
                                ${btn}
                            </td>
                            </tr>`;
                        });
                    }
                    
                    $('#staticBackdropLabel').html("{{ trans('multi-new.0064')}}");
                    $('#modalbody').html(`<div class='col-12 table-responsive'>
                                        <table id="dt-mant-table" class="table table-bordered table-hober display responsive nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Asunto</th>
                                                    <th scope="col">Mensaje</th>
                                                    <th scope="col">Respuesta</th>
                                                    <th scope="col">Fecha Envío</th>
                                                    <th scope="col">Fecha Respuesta</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            ${html}                                         
                                            </tbody>
                                        </table></div>`);
                    $('#modalfooter').html(`<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
                    {{ trans('lang.cancelar')}}
                    </button>`); 
                    $('#staticBackdrop').modal('show');
                    $('#dt-mant-table').DataTable({

                        //"dom": 'lfrtip'

                        "dom": 'frtip', 

                        fixedHeader: true,

                        responsive: true,      

                        "order": [[ 0, "asc" ]],

                        "language": {

                            "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"

                        }

                    });
                    $('#dt-mant-table td').css('white-space','initial');
                    console.log("ok");
                    
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

</script>
@endsection
