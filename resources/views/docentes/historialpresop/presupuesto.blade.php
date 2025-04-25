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
    @media (max-width: 576px) {
      .nav-tabs {
        flex-wrap: nowrap;
        overflow-x: auto;
      }
      .nav-tabs .nav-link {
        white-space: nowrap;
      }
    }
</style>
@endsection
@section('index')
<div class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row justify-content-center mt-4">
                <div class="col-md-12 mb-1">
                    <div class="card mb-4 bg-success shadow-sm">
                        <div class="card-body">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <a role="button" href="{{ route('ver-formulario-docente-concurso-finalizado', Crypt::encrypt($idpost) ) }}" role="button" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0103') }}">{{ trans('lang.volver')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></a>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <a role="button" href="{{ route('imprimr-formulario-docente-presupuesto-concurso-seleccionado', Crypt::encrypt($id) ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('multi-new.0264')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></a>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0267') }}" onclick="solicitaractas('{{ Crypt::encrypt($answ->idansw) }}', 'emailteacher', '{{ Crypt::encrypt(Auth::user()->id) }}', '')">{{ trans('multi-new.0266')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:"></i></button>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" class="btn btn-warning btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0268') }}" onclick="solicitaractas('{{ Crypt::encrypt($answ->idansw) }}', 'notificaciones', '{{ Crypt::encrypt(Auth::user()->id) }}', '')">{{ trans('multi-new.0064')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;color:" ></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4 bg-success shadow-sm">
                        <div class="card-body">
                            <div class="container">
                                <h3 class="text-white">{{ trans('multi-new.0254')}}</h3>
                                <ul id="myTabs" class="nav nav-pills nav-justified" role="tablist" data-tabs="tabs" style="width:100% !important;">
                                    <li class="active col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center"><a class="btn btn-primary btn-block" href="#Commentary" data-toggle="tab">{{ trans('multi-new.0255')}}</a></li>
                                    <li class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center"><a class="btn btn-primary btn-block" href="#Videos" data-toggle="tab">{{ trans('multi-new.0256')}}</a></li>
                                    <li class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center"><a class="btn btn-primary btn-block" href="#Events" data-toggle="tab">{{ trans('multi-new.0257')}}</a></li>
                                    <li class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center"><a class="btn btn-primary btn-block" href="#Other" data-toggle="tab">{{ trans('multi-new.0258')}}</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="Commentary">
                                        <table class="table table-bordered table-sm" style="background-color:#fff;width:100% !important;" id="tablainicio1">
                                            <caption>{{ trans('multi-leng.a117')}}</caption>
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
                                                    
                                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $tabla->descri }}</th>
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
                                        @if($status != 'finalizada')
                                        <label for="preg3et4" class="textlabel mt-4"><b>{{ trans('multi-new.0209')}}</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0222') }}" data-html="true"></i></label>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-white">
                                            <button role="button" id="informativo1" class="btn btn-danger btn-sm btn-block" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0221')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($answ->idansw) }}', 'egresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumper }}', '6')">{{ trans('multi-new.0210')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                        </div>
                                        @endif
                                        <table class="table table-bordered table-sm" style="background-color:#fff;width:100% !important;" id="tablainicio2">
                                            <caption>{{ trans('multi-new.0212')}}</caption>
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                    <th scope="col">{{ trans('multi-new.0036')}}</th>
                                                    <th scope="col">Total ($)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodytablaperegr">
                                                @foreach($tablaperegresos as $tabla)
                                                <tr>
                                                    
                                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $tabla->descri }}</th>
                                                    <td class="text-center">{{ $tabla->valor1 }}</td>
                                                    <td class="text-center">{{ $tabla->valor2 }}</td>
                                                    <td class="text-center">
                                                        <button role="button" class="btn btn-success btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0241')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'veregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumper }}', '6')">{{ trans('multi-new.0239')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        @if($status != 'finalizada')
                                                        <button role="button" class="btn btn-warning btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0246')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'editaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumper }}', '6')">{{ trans('multi-new.0245')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        <button role="button" class="btn btn-danger btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0242')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'eliminaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumper }}', '6')">{{ trans('multi-new.0240')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                    
                                                </tr>
                                                @endforeach
                                                
                                                
                                            </tbody>
                                            <tfoot id="tfoottablaperegresos">
                                                <tr>
                                                    <th colspan="4" scope="col">{{ trans('multi-new.0211')}} </th>
                                                    <th scope="col" id="subtotaltablaperegresos" class="text-center">$ {{ (int)($sumper - $sumperegresos) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="Videos">
                                        <table class="table table-bordered table-sm" style="background-color:#fff;width:100% !important;" id="tablainicio3">
                                            <caption>{{ trans('multi-leng.a118')}}</caption>
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                    <th scope="col">Total ($)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodytablacom">
                                                @foreach($tablacom as $tabla)
                                                <tr>
                                                    
                                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $tabla->descri }}</th>
                                                    <td class="text-center">{{ $tabla->valor1 }}</td>
                                                    <td class="text-center">{{ $tabla->valor2 }}</td>
                                                    <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                    
                                                </tr>
                                                @endforeach
                                                
                                                <tfoot id="tfoottablacom">
                                                    <tr>
                                                        <th colspan="3" scope="col">ITEM {{ trans('multi-leng.a121')}} </th>
                                                        <th scope="col" class="text-center">$ {{ $sumcom }}</th>
                                                    </tr>
                                                </tfoot>
                                            </tbody>
                                        </table>
                                        @if($status != 'finalizada')
                                        <label for="preg3et4" class="textlabel mt-4"><b>{{ trans('multi-new.0209')}}</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0222') }}" data-html="true"></i></label>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-white">
                                            <button role="button" id="informativo1" class="btn btn-danger btn-sm btn-block" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0260')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($answ->idansw) }}', 'egresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumcom }}', '7')">{{ trans('multi-new.0210')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                        </div>
                                        @endif
                                        <table class="table table-bordered table-sm" style="background-color:#fff;width:100% !important;" id="tablainicio4">
                                            <caption>{{ trans('multi-new.0212')}}</caption>
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                    <th scope="col">{{ trans('multi-new.0036')}}</th>
                                                    <th scope="col">Total ($)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodytablacomegr">
                                                @foreach($tablacomegresos as $tabla)
                                                <tr>
                                                    
                                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $tabla->descri }}</th>
                                                    <td class="text-center">{{ $tabla->valor1 }}</td>
                                                    <td class="text-center">{{ $tabla->valor2 }}</td>
                                                    <td class="text-center">
                                                        <button role="button" class="btn btn-success btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0241')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'veregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumcom }}', '7')">{{ trans('multi-new.0239')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        @if($status != 'finalizada')
                                                        <button role="button" class="btn btn-warning btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0246')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'editaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumcom }}', '7')">{{ trans('multi-new.0245')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        <button role="button" class="btn btn-danger btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0242')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'eliminaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumcom }}', '7')">{{ trans('multi-new.0240')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                    
                                                </tr>
                                                @endforeach
                                                
                                                
                                            </tbody>
                                            <tfoot id="tfoottablacomegresos">
                                                <tr>
                                                    <th colspan="4" scope="col">{{ trans('multi-new.0211')}}</th>
                                                    <th scope="col" id="subtotaltablacomegresos" class="text-center">$ {{ (int)($sumcom - $sumcomegresos) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="Events">
                                        <table class="table table-bordered table-sm" style="background-color:#fff;width:100% !important;" id="tablainicio5">
                                            <caption>{{ trans('multi-leng.a119')}}</caption>
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
                                                    
                                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $tabla->descri }}</th>
                                                    <td class="text-center">{{ $tabla->valor1 }}</td>
                                                    <td class="text-center">{{ $tabla->valor2 }}</td>
                                                    <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                    
                                                </tr>
                                                @endforeach
                                                
                                                <tfoot id="tfoottablafun">
                                                    <tr>
                                                        <th colspan="3" scope="col">ITEM {{ trans('multi-leng.a121')}} </th>
                                                        <th scope="col" class="text-center">$ {{ $sumfun }}</th>
                                                    </tr>
                                                </tfoot>
                                            </tbody>
                                        </table>
                                        @if($status != 'finalizada')
                                        <label for="preg3et4" class="textlabel mt-4"><b>{{ trans('multi-new.0209')}}</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0222') }}" data-html="true"></i></label>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-white">
                                            <button role="button" id="informativo1" class="btn btn-danger btn-sm btn-block" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0261')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($answ->idansw) }}', 'egresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumfun }}', '8')">{{ trans('multi-new.0210')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                        </div>
                                        @endif
                                        <table class="table table-bordered table-sm" style="background-color:#fff;width:100% !important;" id="tablainicio6">
                                            <caption>{{ trans('multi-new.0212')}}</caption>
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                    <th scope="col">{{ trans('multi-new.0036')}}</th>
                                                    <th scope="col">Total ($)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodytablafunegr">
                                                @foreach($tablafunegresos as $tabla)
                                                <tr>
                                                    
                                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $tabla->descri }}</th>
                                                    <td class="text-center">{{ $tabla->valor1 }}</td>
                                                    <td class="text-center">{{ $tabla->valor2 }}</td>
                                                    <td class="text-center">
                                                        <button role="button" class="btn btn-success btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0241')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'veregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumfun }}', '8')">{{ trans('multi-new.0239')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        @if($status != 'finalizada')
                                                        <button role="button" class="btn btn-warning btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0246')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'editaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumfun }}', '8')">{{ trans('multi-new.0245')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        <button role="button" class="btn btn-danger btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0242')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'eliminaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumfun }}', '8')">{{ trans('multi-new.0240')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                    
                                                </tr>
                                                @endforeach
                                                
                                                
                                            </tbody>
                                            <tfoot id="tfoottablafunegresos">
                                                <tr>
                                                    <th colspan="4" scope="col">{{ trans('multi-new.0211')}}</th>
                                                    <th scope="col" id="subtotaltablafunegresos" class="text-center">$ {{ (int)($sumfun - $sumfunegresos) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="Other">
                                        <table class="table table-bordered table-sm" style="background-color:#fff;width:100% !important;" id="tablainicio7">
                                            <caption>{{ trans('multi-leng.a120')}}</caption>
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                    <th scope="col">Total ($)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodytablaoth">
                                                @foreach($tablaotr as $tabla)
                                                <tr>
                                                    
                                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $tabla->descri }}</th>
                                                    <td class="text-center">{{ $tabla->valor1 }}</td>
                                                    <td class="text-center">{{ $tabla->valor2 }}</td>
                                                    <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                    
                                                </tr>
                                                @endforeach
                                                
                                                <tfoot id="tfoottablaoth">
                                                    <tr>
                                                        <th colspan="3" scope="col">ITEM {{ trans('multi-leng.a121')}} </th>
                                                        <th scope="col" class="text-center">$ {{ $sumotr }}</th>
                                                    </tr>
                                                </tfoot>
                                            </tbody>
                                        </table>
                                        @if($status != 'finalizada')
                                        <label for="preg3et4" class="textlabel mt-4"><b>{{ trans('multi-new.0209')}}</b>&nbsp;&nbsp;<i style="color:#fff;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0222') }}" data-html="true"></i></label>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-white">
                                            <button role="button" id="informativo1" class="btn btn-danger btn-sm btn-block" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0262')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($answ->idansw) }}', 'egresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumotr }}', '9')">{{ trans('multi-new.0210')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                        </div>
                                        @endif
                                        <table class="table table-bordered table-sm" style="background-color:#fff;width:100% !important;" id="tablainicio8">
                                            <caption>{{ trans('multi-new.0212')}}</caption>
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ trans('multi-leng.formerror26')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a123')}}</th>
                                                    <th scope="col">{{ trans('multi-leng.a124')}}</th>
                                                    <th scope="col">{{ trans('multi-new.0036')}}</th>
                                                    <th scope="col">Total ($)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodytablaothegr">
                                                @foreach($tablaotregresos as $tabla)
                                                <tr>
                                                    
                                                    <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $tabla->descri }}</th>
                                                    <td class="text-center">{{ $tabla->valor1 }}</td>
                                                    <td class="text-center">{{ $tabla->valor2 }}</td>
                                                    <td class="text-center">
                                                        <button role="button" class="btn btn-success btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0241')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'veregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumfun }}', '9')">{{ trans('multi-new.0239')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        @if($status != 'finalizada')
                                                        <button role="button" class="btn btn-warning btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0246')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'editaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumfun }}', '9')">{{ trans('multi-new.0245')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        <button role="button" class="btn btn-danger btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0242')}}" data-html="true" onclick="solicitaractas('{{ Crypt::encrypt($tabla->iddetres) }}', 'eliminaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '{{ (int)$sumfun }}', '9')">{{ trans('multi-new.0240')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $tabla->valor1 * $tabla->valor2 }}</td>
                                                    
                                                </tr>
                                                @endforeach
                                                
                                                
                                            </tbody>
                                            <tfoot id="tfoottablaothegresos">
                                                <tr>
                                                    <th colspan="4" scope="col">{{ trans('multi-new.0211')}}</th>
                                                    <th scope="col" id="subtotaltablaothegresos" class="text-center">$ {{ (int)($sumotr - $sumotregresos) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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

<input type="hidden" id="idconc" name="idconc" value="{{ $idconcurso }}">
<input type="hidden" id="idpost" name="idpost" value="{{ $idpostulacion }}">
<input type="hidden" id="idansw" name="idansw" value="{{ Crypt::encrypt($answ->idansw) }}">

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
            $('[data-toggle="tooltip"]').tooltip()
        });
        
        $('#tablainicio').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,
            ordering: false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tablainicio2').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,
            ordering: false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tablainicio3').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,
            ordering: false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tablainicio4').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,
            ordering: false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tablainicio5').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,
            ordering: false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tablainicio6').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,
            ordering: false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tablainicio7').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,
            ordering: false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        $('#tablainicio8').DataTable({
            //"dom": 'lfrtip'
            "dom": '', 
            fixedHeader: true,
            responsive: true,
            ordering: false,
            "language": {
                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
            }
        });
        
       
        
    });
    function solicitaractas(valida, tipo, validu, adic, tipoegreso)
    {
        switch (true) 
        {
            
            case (tipo == 'egresopersonal'):
                
                
                if(parseInt(tipoegreso, 10) == 6)
                {
                    $('#staticBackdropLabel').html("{{ trans('multi-new.0253')}} {{ trans('multi-new.0213')}}");
                }
                if(parseInt(tipoegreso, 10) == 7)
                {
                    $('#staticBackdropLabel').html("{{ trans('multi-new.0253')}} {{ trans('multi-new.0251')}}");
                }
                if(parseInt(tipoegreso, 10) == 8)
                {
                    $('#staticBackdropLabel').html("{{ trans('multi-new.0253')}} {{ trans('multi-new.0252')}}");
                }
                if(parseInt(tipoegreso, 10) == 9)
                {
                    $('#staticBackdropLabel').html("{{ trans('multi-new.0253')}} {{ trans('multi-new.0263')}}");
                }
                $('#modalbody').html(`<div class="mb-3">
                                                <label for="descripcion" class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0216') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="200" aria-describedby="descripcionHelp">
                                                <small id="descripcionHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cantidad" class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0217') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <input type="text" class="form-control" id="cantidad" name="cantidad" maxlength="6" aria-describedby="cantidadHelp" onkeypress="return valideKey(event);">
                                                <small id="cantidadHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="valorunitario" class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0218') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <input type="text" class="form-control" id="valorunitario" name="valorunitario" maxlength="8" aria-describedby="valorunitarioHelp" onkeypress="return valideKey(event);">
                                                <small id="valorunitarioHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="carac" class="form-label"><b>{{ trans('multi-new.0214')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0219') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <textarea class="" name="carac" id="carac" rows="10" style="height:150px !important;width:100%;resize:none;" maxlength="1000" aria-describedby="caracHelp"></textarea>
                                                <small id="caracHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label"><b>{{ trans('multi-new.0215')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0220') }}" data-html="true"></i></label>
                                                <input class="form-control" type="file" id="formFile" name="formFile" multiple accept=".png, .jpg, .jpeg, .pdf, .docx" aria-describedby="formFileHelp" >
                                                <small id="formFileHelp" class="form-text" style="color:red;"></small>
                                                <div id="errorContainer"></div>
                                                <ul id="fileList" class="file-list"></ul>
                                            </div>
                                            <input type="hidden" id="idact" name="idact" value="${valida}">
                                            <input type="hidden" id="idus" name="idus" value="${validu}">
                                            <input type="hidden" id="adic" name="adic" value="${adic}">
                                            <input type="hidden" id="tipoop" name="tipoop" value="${tipo}">
                                            <input type="hidden" id="tipoegreso" name="tipoegreso" value="${tipoegreso}">
                                            <button class="btn btn-primary btn-sm" id="sendfunc">{{ trans('lang.enviar')}}</button>`);
                $('#modalfooter').html(`<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
                {{ trans('lang.cancelar')}}
                </button>`); 
                $('#staticBackdrop').modal('show');  
            break;
            
            case (tipo == 'veregresopersonal' || tipo == 'eliminaregresopersonal' || tipo == 'validareliminaritem' || tipo == 'editaregresopersonal' || tipo == 'validareliminarfile'):
                var formData = new FormData();
                    formData.append("idegresoper", valida);
                    formData.append("idus", validu);
                    formData.append("tipo", tipo);
                    formData.append("adic", adic);
                    formData.append("tipoegreso", tipoegreso);
                    
                    ajax(formData, tipo);
            break;
            case (tipo == 'validareditaritem'):

                var error = "";

                var input;

                input = $("#descripcion").val().trim();

                if (input === "") {
                    
                    error += "{{ trans('multi-new.0227')}}"+'<br>';
                }
                if (input.length < 2) {

                    error += "{{ trans('multi-new.0228')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0229')}}"+'<br>';
                }

                input = $("#cantidad").val().trim();

                if (input === "") {
                    
                    error += "{{ trans('multi-new.0230')}}"+'<br>';
                }
                if ($("#cantidad").val() < 0) {

                    error += "{{ trans('multi-new.0231')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0232')}}"+'<br>';
                }

                input = $("#valorunitario").val().trim();
                
                if (input === "") {
                    
                    error += "{{ trans('multi-new.0233')}}"+'<br>';
                }
                if ($("#valorunitario").val() < 0) {

                    error += "{{ trans('multi-new.0234')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0235')}}"+'<br>';
                }

                input = $("#carac").val().trim();
                if (input === "") {
                    
                    error += "{{ trans('multi-new.0236')}}"+'<br>';
                }
                if (input.length < 0) {

                    error += "{{ trans('multi-new.0237')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0238')}}"+'<br>';
                }

                if(error !== "")
                {
                    notificacion(error, "danger", "{{ trans('multi-new.0124')}}");
                }
                else
                {
                    var formData = new FormData();
                    var files = document.getElementById('formFile').files;
                    for (var x = 0; x < files.length; x++) {
                        formData.append("fileToUpload[]", files[x]);
                    }
                    formData.append("idansw", valida);
                    formData.append("idus", validu);
                    formData.append("adic", adic);
                    formData.append("tipo", tipo);
                    formData.append("descripcion", $('#descripcion').val());
                    formData.append("cantidad", $('#cantidad').val());
                    formData.append("valorunitario", $('#valorunitario').val());
                    formData.append("carac", $('#carac').val());
                    formData.append("tipoegreso", tipoegreso);
                    ajax(formData, tipo);
                }
            break;
            case (tipo == 'emailteacher'):
                
                $('#staticBackdropLabeltwo').html("{{ trans('multi-new.0269')}}");
                $('#modalbodytwo').html(`<div class="mb-3">
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
                $('#modalfootertwo').html(`<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
                {{ trans('lang.cancelar')}}
                </button>`); 
                $('#staticBackdroptwo').modal('show');  
            break;
            case (tipo == 'notificaciones'):

                var formData = new FormData();
                formData.append("idact", valida);
                formData.append("idus", validu);
                formData.append("tipo", tipo);

                ajax(formData, tipo);

            break;
            case (tipo == 'respuestaemail'):
                let text = " ";
                
                if(adic !== "" && adic !== null && adic !== 'null')
                {
                    console.log( adic.length);
                    text = adic.replaceAll("*%%%%%%*", "\n");
                    text = text.replaceAll("%%*********************************%%", "\n*********************************\n");
                }
                
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
            
        }
    }
    function valideKey(evt){
        
        var code = (evt.which) ? evt.which : evt.keyCode;
        var valor_1 = $("#porcentajeaud").val();
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
    // Función para limpiar mensajes y lista de archivos
    function clearDisplay() 
    {
        errorContainer.innerHTML = '';

        fileList.innerHTML = '';

    }

    // Función para mostrar mensajes de error
    function displayError(message) 
    {
        const errorDiv = document.createElement('div');

        errorDiv.className = 'error';

        errorDiv.textContent = message;

        errorContainer.appendChild(errorDiv);

    }

    // Función para mostrar la lista de archivos seleccionados
    function displayFileList(files) 
    {
        files.forEach(file => {

            const listItem = document.createElement('li');

            // Crear un icono basado en el tipo de archivo
            const icon = document.createElement('span');

            icon.className = 'file-icon';
            
            if (file.type.startsWith('image/')) 
            {

                icon.textContent = '📷'; // Icono de imagen

            } 
            else if (file.type === 'application/pdf') 
            {

                icon.textContent = '📄'; // Icono de documento PDF

            } 
            else if (file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') 
            {

                icon.textContent = '📃'; // Icono de documento Word

            } 
            else 
            {

                icon.textContent = '📁'; // Icono genérico

            }

            listItem.appendChild(icon);

            listItem.appendChild(document.createTextNode(file.name));

            fileList.appendChild(listItem);

        });
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
    function caracteres(input)
    {
        // Expresiones regulares para detectar patrones sospechosos
        const sqlPattern = /(\b(SELECT|INSERT|DELETE|UPDATE|DROP|ALTER|TRUNCATE|EXEC|UNION|SCRIPT|ONERROR|ONLOAD)\b)|(--|\bOR\b|\bAND\b|;|%|')/i;
        const scriptPattern = /(<script\b|\bon\w+=|\bjavascript:|\bvbscript:|<\s*a\b|\bsrc=[^>]+>|<iframe\b|<img\b)/i;
    
        // Comprobando si el input coincide con los patrones de ataque.
        return !sqlPattern.test(input) && !scriptPattern.test(input)

    }
    $('#staticBackdrop').on('shown.bs.modal', function () {

        $('[data-toggle="tooltip"]').tooltip();
        $( "#sendfunc" ).on( "click", function(event) {

            event.preventDefault();

            var error = "";

            var input;

            if ($("#tipoop").val() === "egresopersonal") 
            {
                
                input = $("#descripcion").val().trim();

                if (input === "") {
                    
                    error += "{{ trans('multi-new.0227')}}"+'<br>';
                }
                if (input.length < 2) {

                    error += "{{ trans('multi-new.0228')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0229')}}"+'<br>';
                }
                input = $("#cantidad").val().trim();

                if (input === "") {
                    
                    error += "{{ trans('multi-new.0230')}}"+'<br>';
                }
                if ($("#cantidad").val() < 0) {

                    error += "{{ trans('multi-new.0231')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0232')}}"+'<br>';
                }
                input = $("#valorunitario").val().trim();
                
                if (input === "") {
                    
                    error += "{{ trans('multi-new.0233')}}"+'<br>';
                }
                if ($("#valorunitario").val() < 0) {

                    error += "{{ trans('multi-new.0234')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0235')}}"+'<br>';
                }
                input = $("#carac").val().trim();
                if (input === "") {
                    
                    error += "{{ trans('multi-new.0236')}}"+'<br>';
                }
                if (input.length < 0) {

                    error += "{{ trans('multi-new.0237')}}"+'<br>';
                }
                if (!caracteres(input)) {
                    
                    error += "{{ trans('multi-new.0238')}}"+'<br>';
                }
            }


            if(error !== "")
            {
                notificacion(error, "danger", "{{ trans('multi-new.0124')}}");
            }
            else
            {
                if ($("#tipoop").val() === "egresopersonal") 
                {
                    var formData = new FormData();
                    var files = document.getElementById('formFile').files;
                    for (var x = 0; x < files.length; x++) {
                        formData.append("fileToUpload[]", files[x]);
                    }
                    formData.append("idansw", $('#idact').val());
                    formData.append("idus", $('#idus').val());
                    formData.append("adic", $('#adic').val());
                    formData.append("tipo", $('#tipoop').val());
                    formData.append("descripcion", $('#descripcion').val());
                    formData.append("cantidad", $('#cantidad').val());
                    formData.append("valorunitario", $('#valorunitario').val());
                    formData.append("carac", $('#carac').val());
                    formData.append("tipoegreso", $('#tipoegreso').val());
                    ajax(formData, $("#tipoop").val());
                }
            }
        } );
        const allowedFormats = ['image/png', 'image/jpeg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

        const maxSize = 5 * 1024 * 1024; // 5MB

        const fileInput = document.getElementById('formFile');

        const errorContainer = document.getElementById('errorContainer');

        const fileList = document.getElementById('fileList');

        fileInput.addEventListener('change', (event) => {

            clearDisplay();

            const files = Array.from(event.target.files);

            const invalidFiles = [];

            invalidFiles.push(`{{ trans('multi-new.0223')}}`);

            let hasError = false;

            files.forEach(file => 
            {
                
                if (!allowedFormats.includes(file.type)) 
                {
                    invalidFiles.push(`{{ trans('multi-new.0224')}}: ${file.name}`);

                    hasError = true;
                }
                if (file.size > maxSize) 
                {
                    invalidFiles.push(`{{ trans('multi-new.0225')}}"${file.name}"{{ trans('multi-new.0226')}}`);

                    hasError = true;
                }
            });

            if (hasError) 
            {
                
                invalidFiles.forEach(errorMsg => displayError(errorMsg));
                
                fileInput.value = '';
            } 
            else 
            {
                
                displayFileList(files);

            }
        });
    } );
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

        const allowedFormats = ['image/png', 'image/jpeg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

        const maxSize = 5 * 1024 * 1024; // 5MB

        const fileInput = document.getElementById('formFile');

        const errorContainer = document.getElementById('errorContainer');

        const fileList = document.getElementById('fileList');

        fileInput.addEventListener('change', (event) => {

            clearDisplay();

            const files = Array.from(event.target.files);

            const invalidFiles = [];

            invalidFiles.push(`{{ trans('multi-new.0223')}}`);

            let hasError = false;

            files.forEach(file => 
            {
                
                if (!allowedFormats.includes(file.type)) 
                {
                    invalidFiles.push(`{{ trans('multi-new.0224')}}: ${file.name}`);

                    hasError = true;
                }
                if (file.size > maxSize) 
                {
                    invalidFiles.push(`{{ trans('multi-new.0225')}}"${file.name}"{{ trans('multi-new.0226')}}`);

                    hasError = true;
                }
            });

            if (hasError) 
            {
                
                invalidFiles.forEach(errorMsg => displayError(errorMsg));
                
                fileInput.value = '';
            } 
            else 
            {
                
                displayFileList(files);

            }
        });
        
    });

    function ajax(form, tipo)
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{url("/")}}/funcionalidades-ajax-usuario-docente-presupuestos',
            data: form,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(respu)
            {
                var $html = "";
                if(tipo == 'editaregresopersonal' && respu.status == "ok")
                {
                    
                    var $btn = "";
                    
                    if(parseInt(respu.tipoegreso, 10) == 6)
                    {
                        $('#staticBackdropLabeltwo').html("{{ trans('lang.editar')}} {{ trans('multi-new.0213')}}");
                    }
                    if(parseInt(respu.tipoegreso, 10) == 7)
                    {
                        $('#staticBackdropLabeltwo').html("{{ trans('lang.editar')}} {{ trans('multi-new.0251')}}");
                    }
                    if(parseInt(respu.tipoegreso, 10) == 8)
                    {
                        $('#staticBackdropLabeltwo').html("{{ trans('lang.editar')}} {{ trans('multi-new.0251')}}");
                    }
                    if(parseInt(respu.tipoegreso, 10) == 9)
                    {
                        $('#staticBackdropLabeltwo').html("{{ trans('lang.editar')}} {{ trans('multi-new.0259')}}");
                    }
                    var $btn = `<button role="button" class="btn btn-warning btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0242')}}" data-html="true" onclick="solicitaractas('${respu.idbus}', 'validareditaritem', '${respu.idus}', '${respu.adic}', '${respu.tipoegreso}')">{{ trans('lang.editar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>`;
                    console.log('$btn', $btn);
                    if(respu.data1.length > 0)
                    {
                        

                        Object.keys(respu.data1).forEach(key => {

                            $html += `<li id="li${respu.data1[key].id}"><a href="{{ asset('storage/adjuntos/docentes/presupuestos/') }}/${respu.data1[key].nomfile}" download="${respu.data1[key].nomori}">{{ trans('multi-new.0250')}} ${respu.data1[key].nomori}</a>&nbsp;&nbsp;&nbsp;<button role="button" class="btn btn-danger btn-sm btn-sm mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0242')}}" data-html="true" onclick="solicitaractas('${respu.data1[key].id}', 'validareliminarfile', '${respu.idus}', '${respu.adic}', '${respu.tipoegreso}')">{{ trans('lang.eliminar')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button></li>`;
                            
                        });
                        
                    }
                    
                    $('#modalbodytwo').html(`<div class="mb-3">
                                                <label for="descripcion" class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0216') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="200" aria-describedby="descripcionHelp" value="${respu.data.descri}">
                                                <small id="descripcionHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cantidad" class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0217') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <input type="text" class="form-control" id="cantidad" name="cantidad" maxlength="6" aria-describedby="cantidadHelp" onkeypress="return valideKey(event);" value="${respu.data.valor1}">
                                                <small id="cantidadHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="valorunitario" class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0218') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <input type="text" class="form-control" id="valorunitario" name="valorunitario" maxlength="8" aria-describedby="valorunitarioHelp" onkeypress="return valideKey(event);" value="${respu.data.valor2}">
                                                <small id="valorunitarioHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="carac" class="form-label"><b>{{ trans('multi-new.0214')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0219') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <textarea class="" name="carac" id="carac" rows="10" style="height:150px !important;width:100%;resize:none;" maxlength="1000" aria-describedby="caracHelp">${respu.data.descriplarga}</textarea>
                                                <small id="caracHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label"><b>{{ trans('multi-new.0215')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0220') }}" data-html="true"></i></label>
                                                <input class="form-control" type="file" id="formFile" name="formFile" multiple accept=".png, .jpg, .jpeg, .pdf, .docx" aria-describedby="formFileHelp" >
                                                <small id="formFileHelp" class="form-text" style="color:red;"></small>
                                                <div id="errorContainer"></div>
                                                <ul id="fileList" class="file-list"></ul>
                                            </div>
                                            <div class="mb-3">
                                                <ul id="fileListadd" class="file-list">${$html}</ul>
                                            </div>
                                            <input type="hidden" id="idact" name="idact" value="${respu.idbus}">
                                            <input type="hidden" id="idus" name="idus" value="${respu.idus}">
                                            <input type="hidden" id="tipoop" name="tipoop" value="${tipo}">
                                            ${$btn}`);
                    $('#modalfootertwo').html(`<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
                    {{ trans('lang.cancelar')}}
                    </button>`); 
                    $('#staticBackdroptwo').modal('show');
                }
                if((tipo == 'veregresopersonal' || tipo == 'eliminaregresopersonal') && respu.status == "ok")
                {
                    
                    var $btn = "";
                    
                    if(parseInt(respu.tipoegreso, 10) == 6)
                    {
                        $('#staticBackdropLabeltwo').html("{{ trans('multi-new.0247')}} {{ trans('multi-new.0213')}}"); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 7)
                    {
                        $('#staticBackdropLabeltwo').html("{{ trans('multi-new.0247')}} {{ trans('multi-leng.a118')}}"); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 8)
                    {
                        $('#staticBackdropLabeltwo').html("{{ trans('multi-new.0247')}} {{ trans('multi-leng.a119')}}"); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 9)
                    {
                        $('#staticBackdropLabeltwo').html("{{ trans('multi-new.0247')}} {{ trans('multi-leng.a120')}}"); 
                    }
                    if(tipo == 'eliminaregresopersonal')
                    {
                        if(parseInt(respu.tipoegreso, 10) == 6)
                        {
                            $('#staticBackdropLabeltwo').html("{{ trans('lang.eliminar')}} {{ trans('multi-new.0213')}}"); 
                        }
                        if(parseInt(respu.tipoegreso, 10) == 7)
                        { 
                            $('#staticBackdropLabeltwo').html("{{ trans('lang.eliminar')}} {{ trans('multi-leng.a118')}}"); 
                        }
                        if(parseInt(respu.tipoegreso, 10) == 8)
                        { 
                            $('#staticBackdropLabeltwo').html("{{ trans('lang.eliminar')}} {{ trans('multi-leng.a119')}}"); 
                        }
                        if(parseInt(respu.tipoegreso, 10) == 9)
                        { 
                            $('#staticBackdropLabeltwo').html("{{ trans('lang.eliminar')}} {{ trans('multi-leng.a120')}}"); 
                        }
                        
                        var $btn = `<button role="button" class="btn btn-danger btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0242')}}" data-html="true" onclick="solicitaractas('${respu.idbus}', 'validareliminaritem', '${respu.idus}', '${respu.adic}', '${respu.tipoegreso}')">{{ trans('multi-new.0240')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>`;
                    }
                    if(respu.data1.length > 0)
                    {
                        

                        Object.keys(respu.data1).forEach(key => {

                            $html += `<li><a href="{{ asset('storage/adjuntos/docentes/presupuestos/') }}/${respu.data1[key].nomfile}" download="${respu.data1[key].nomfile}">Descargar ${respu.data1[key].nomfile}</a></li>`;
                            
                        });
                        
                    }
                    
                    $('#modalbodytwo').html(`<div class="mb-3">
                                                <label for="descripcion" class="form-label"><b>{{ trans('multi-leng.formerror26')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0216') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="200" aria-describedby="descripcionHelp" value="${respu.data.descri}" disabled>
                                                <small id="descripcionHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cantidad" class="form-label"><b>{{ trans('multi-leng.a123')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0217') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <input type="text" class="form-control" id="cantidad" name="cantidad" maxlength="6" aria-describedby="cantidadHelp" onkeypress="return valideKey(event);" value="${respu.data.valor1}" disabled>
                                                <small id="cantidadHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="valorunitario" class="form-label"><b>{{ trans('multi-leng.a124')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0218') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <input type="text" class="form-control" id="valorunitario" name="valorunitario" maxlength="8" aria-describedby="valorunitarioHelp" onkeypress="return valideKey(event);" value="${respu.data.valor2}" disabled>
                                                <small id="valorunitarioHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="carac" class="form-label"><b>{{ trans('multi-new.0214')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0219') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                <textarea class="" name="carac" id="carac" rows="10" style="height:150px !important;width:100%;resize:none;" maxlength="1000" aria-describedby="caracHelp" disabled>${respu.data.descriplarga}</textarea>
                                                <small id="caracHelp" class="form-text" style="color:red;"></small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label"><b>{{ trans('multi-new.0215')}}</b>&nbsp;&nbsp;<i style="color:#000;font-size:18px;" class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('multi-new.0220') }}" data-html="true"></i>&nbsp; <small style="color:red;font-size:10px;">(* {{ __('lang.infoobli') }})</small></label>
                                                
                                                <ul id="fileList" class="file-list">${$html}</ul>
                                            </div>
                                            <input type="hidden" id="idact" name="idact" value="${respu.idbus}">
                                            <input type="hidden" id="idus" name="idus" value="${respu.idus}">
                                            <input type="hidden" id="tipoop" name="tipoop" value="${tipo}">
                                            <input type="hidden" id="tipoegreso" name="tipoegreso" value="${respu.tipoegreso}">
                                            ${$btn}`);
                    $('#modalfootertwo').html(`<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">
                    {{ trans('lang.cancelar')}}
                    </button>`); 
                    $('#staticBackdroptwo').modal('show');
                }
                if(tipo == 'egresopersonal' && respu.status == "ok")
                {
                    if(parseInt(respu.tipoegreso, 10) == 6) 
                    {
                        $('#bodytablaperegr').html('');
                        $('#tablainicio2').DataTable().clear().destroy(); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 7) 
                    {
                        $('#bodytablacomegr').html('');
                        $('#tablainicio4').DataTable().clear().destroy(); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 8) 
                    {
                        $('#bodytablafunegr').html('');
                        $('#tablainicio6').DataTable().clear().destroy(); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 9) 
                    {
                        $('#bodytablaothegr').html('');
                        $('#tablainicio8').DataTable().clear().destroy(); 
                    }
                    if(respu.data.length > 0)
                    {
                        Object.keys(respu.data).forEach(key => {
                            
                            $html +=`<tr>
                                        <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;${respu.data[key].descri}</th>
                                                <td class="text-center">${respu.data[key].valor1}</td>
                                                <td class="text-center">${respu.data[key].valor2}</td>
                                                <td class="text-center">
                                                    <button role="button" class="btn btn-success btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0241')}}" data-html="true" onclick="solicitaractas('${respu.data[key].id}', 'veregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '${respu.adic}', '${respu.tipoegreso}')">{{ trans('multi-new.0239')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                    <button role="button" class="btn btn-warning btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0246')}}" data-html="true" onclick="solicitaractas('${respu.data[key].id}', 'editaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '${respu.adic}', '${respu.tipoegreso}')">{{ trans('multi-new.0245')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                    <button role="button" class="btn btn-danger btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0242')}}" data-html="true" onclick="solicitaractas('${respu.data[key].id}', 'eliminaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '${respu.adic}', '${respu.tipoegreso}')">{{ trans('multi-new.0240')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                </td>
                                                <td class="text-center">${respu.data[key].valor1 * respu.data[key].valor2}</td>
                                                
                                            </tr> 
                                            `;
                        });
                        if(parseInt(respu.tipoegreso, 10) == 6) 
                        {
                            $('#bodytablaperegr').html($html); 
                        }
                        if(parseInt(respu.tipoegreso, 10) == 7) 
                        {
                            $('#bodytablacomegr').html($html); 
                        }
                        if(parseInt(respu.tipoegreso, 10) == 8) 
                        {
                            $('#bodytablafunegr').html($html); 
                        }
                        if(parseInt(respu.tipoegreso, 10) == 9) 
                        {
                            $('#bodytablaothegr').html($html); 
                        }
                    }
                    
                    let num = parseInt(respu.adic, 10) - parseInt(respu.sumperegresos, 10);

                    if(parseInt(respu.tipoegreso, 10) == 6) 
                    {
                        $('#subtotaltablaperegresos').html(`$ ${num}`);

                        $('#tablainicio2').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        }); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 7) 
                    {
                        $('#subtotaltablacomegresos').html(`$ ${num}`);

                        $('#tablainicio4').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        }); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 8) 
                    {
                        $('#subtotaltablafunegresos').html(`$ ${num}`);

                        $('#tablainicio6').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        }); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 9) 
                    {
                        $('#subtotaltablaothegresos').html(`$ ${num}`);

                        $('#tablainicio8').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        }); 
                    }
                    $('#formFile').val('');
                    $('#staticBackdrop').modal('hide');
                    notificacion("{{ __('multi-new.0244') }}", "success", "{{ trans('multi-new.0243')}}");
                    
                }
                if(tipo == 'validareliminarfile' && respu.status == "ok")
                {
                    $("#li"+respu.id).remove();
                    notificacion("{{ __('multi-new.0248') }}", "success", "{{ trans('multi-new.0243')}}");
                    
                }
                if(tipo == 'validareditaritem' && respu.status == "ok")
                {
                    if(parseInt(respu.tipoegreso, 10) == 6) 
                    {
                        $('#bodytablaperegr').html('');
                        $('#tablainicio2').DataTable().clear().destroy(); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 7) 
                    {
                        $('#bodytablacomegr').html('');
                        $('#tablainicio4').DataTable().clear().destroy(); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 8) 
                    {
                        $('#bodytablafunegr').html('');
                        $('#tablainicio6').DataTable().clear().destroy(); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 9) 
                    {
                        $('#bodytablaothegr').html('');
                        $('#tablainicio8').DataTable().clear().destroy(); 
                    }
                    if(respu.data.length > 0)
                    {
                        Object.keys(respu.data).forEach(key => {
                            
                            $html +=`<tr>
                                        <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;${respu.data[key].descri}</th>
                                                <td class="text-center">${respu.data[key].valor1}</td>
                                                <td class="text-center">${respu.data[key].valor2}</td>
                                                <td class="text-center">
                                                    <button role="button" class="btn btn-success btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0241')}}" data-html="true" onclick="solicitaractas('${respu.data[key].id}', 'veregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '${respu.adic}', '${respu.tipoegreso}')">{{ trans('multi-new.0239')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                    <button role="button" class="btn btn-warning btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0246')}}" data-html="true" onclick="solicitaractas('${respu.data[key].id}', 'editaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '${respu.adic}', '${respu.tipoegreso}')">{{ trans('multi-new.0245')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                    <button role="button" class="btn btn-danger btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0242')}}" data-html="true" onclick="solicitaractas('${respu.data[key].id}', 'eliminaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '${respu.adic}', '${respu.tipoegreso}')">{{ trans('multi-new.0240')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                </td>
                                                <td class="text-center">${respu.data[key].valor1 * respu.data[key].valor2}</td>
                                                
                                            </tr> 
                                            `;
                        });
                        if(parseInt(respu.tipoegreso, 10) == 6) 
                        {
                            $('#bodytablaperegr').html($html); 
                        }
                        if(parseInt(respu.tipoegreso, 10) == 7) 
                        {
                            $('#bodytablacomegr').html($html); 
                        }
                        if(parseInt(respu.tipoegreso, 10) == 8) 
                        {
                            $('#bodytablafunegr').html($html); 
                        }
                        if(parseInt(respu.tipoegreso, 10) == 9) 
                        {
                            $('#bodytablaothegr').html($html); 
                        }
                    }
                        
                    let num = parseInt(respu.adic, 10) - parseInt(respu.sumperegresos, 10);

                    if(parseInt(respu.tipoegreso, 10) == 6) 
                    {
                        $('#subtotaltablaperegresos').html(`$ ${num}`);

                        $('#tablainicio2').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        }); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 7) 
                    {
                        $('#subtotaltablacomegresos').html(`$ ${num}`);

                        $('#tablainicio4').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        }); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 8) 
                    {
                        $('#subtotaltablafunegresos').html(`$ ${num}`);

                        $('#tablainicio6').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        }); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 9) 
                    {
                        $('#subtotaltablaothegresos').html(`$ ${num}`);

                        $('#tablainicio8').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        }); 
                    }
                    $('#formFile').val('');

                    $('#staticBackdroptwo').modal('hide');

                    notificacion("{{ trans('multi-new.0249')}}", "success", "{{ trans('multi-new.0243')}}");
                    
                }
                if(tipo == 'validareliminaritem' && respu.status == "ok")
                {
                    var sumatotal = parseInt(respu.adic, 10);

                    if(parseInt(respu.tipoegreso, 10) == 6) 
                    {
                        $('#bodytablaperegr').html('');
                        $('#tablainicio2').DataTable().clear().destroy();
                    }
                    if(parseInt(respu.tipoegreso, 10) == 7) 
                    {
                        $('#bodytablacomegr').html('');
                        $('#tablainicio4').DataTable().clear().destroy(); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 8) 
                    {
                        $('#bodytablafunegr').html('');
                        $('#tablainicio6').DataTable().clear().destroy(); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 9) 
                    {
                        $('#bodytablaothegr').html('');
                        $('#tablainicio8').DataTable().clear().destroy(); 
                    }
                    if(respu.data.length > 0)
                    {
                        Object.keys(respu.data).forEach(key => {
                            
                            $html +=`<tr>
                                        <th scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;${respu.data[key].descri}</th>
                                                <td class="text-center">${respu.data[key].valor1}</td>
                                                <td class="text-center">${respu.data[key].valor2}</td>
                                                <td class="text-center">
                                                    <button role="button" class="btn btn-success btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0241')}}" data-html="true" onclick="solicitaractas('${respu.data[key].id}', 'veregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '${respu.adic}', '${respu.temp}')">{{ trans('multi-new.0239')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                    <button role="button" class="btn btn-warning btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0246')}}" data-html="true" onclick="solicitaractas('${respu.data[key].id}', 'editaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '${respu.adic}', '${respu.temp}')">{{ trans('multi-new.0245')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                    <button role="button" class="btn btn-danger btn-sm btn-block mb-1" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ trans('multi-new.0242')}}" data-html="true" onclick="solicitaractas('${respu.data[key].id}', 'eliminaregresopersonal', '{{ Crypt::encrypt(Auth::user()->id) }}', '${respu.adic}', '${respu.temp}')">{{ trans('multi-new.0240')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                                </td>
                                                <td class="text-center">${respu.data[key].valor1 * respu.data[key].valor2}</td>
                                                
                                            </tr> 
                                            `;
                        });

                        if(parseInt(respu.tipoegreso, 10) == 6) 
                        {
                            $('#bodytablaperegr').html($html);
                        }
                        if(parseInt(respu.tipoegreso, 10) == 7) 
                        {
                            $('#bodytablacomegr').html($html); 
                        }
                        if(parseInt(respu.tipoegreso, 10) == 8) 
                        {
                            $('#bodytablafunegr').html($html); 
                        }
                        if(parseInt(respu.tipoegreso, 10) == 9) 
                        {
                            $('#bodytablaothegr').html($html); 
                        }
                    }

                    let num = parseInt(respu.adic, 10) - parseInt(respu.sumperegresos, 10);

                    if(parseInt(respu.tipoegreso, 10) == 6) 
                    {
                        $('#subtotaltablaperegresos').html(`$ ${num}`);
                        $('#tablainicio2').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        });
                    }
                    if(parseInt(respu.tipoegreso, 10) == 7) 
                    {
                        $('#subtotaltablacomegresos').html(`$ ${num}`);

                        $('#tablainicio4').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        }); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 8) 
                    {
                        $('#subtotaltablafunegresos').html(`$ ${num}`);

                        $('#tablainicio6').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        }); 
                    }
                    if(parseInt(respu.tipoegreso, 10) == 9) 
                    {
                        $('#subtotaltablaothegresos').html(`$ ${num}`);

                        $('#tablainicio8').DataTable({
                            //"dom": 'lfrtip'
                            "dom": '', 
                            fixedHeader: true,
                            responsive: true,
                            ordering: false,
                            "language": {
                                "url": "{{asset('json')}}/{{ trans('multi-leng.idioma')}}.json"
                            }
                        }); 
                    }
                    $('#staticBackdroptwo').modal('hide');

                    notificacion("{{ __('multi-new.0244') }}", "success", "{{ trans('multi-new.0243')}}");
                    
                }
                if( respu.status === "ok" && tipo === "emailteacher" )
                {
                    $('#staticBackdroptwo').modal('hide');
                    notificacion("{{ trans('multi-new.0270')}}", "success", "{{ trans('multi-new.0125')}}");
                    
                }
                if( respu.status === "ok" && tipo === "notificaciones" )
                {
                    var html = "";

                    if(respu.html.length > 0)
                    {
                        const obj = JSON.parse(respu.html);

                        Object.keys(obj).forEach(key => {

                            var btn = "";

                            var tipo = "{{ trans('multi-new.0273')}}";

                            if(obj[key].tipo == 'adminpresupuesto')
                            {
                                tipo = "{{ trans('multi-new.0273')}}";
                            }
                            
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
                                                <th scope="col" class="text-left" style="width:40%">{{ trans('multi-new.0272')}}</th>
                                                <th scope="col" class="text-left">${tipo}</th>
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
                else if( respu.status === "ok" && tipo === "respuestaemail" )
                {
                    $('#staticBackdroptwo').modal('hide');
                    notificacion("{{ trans('multi-new.0167')}}", "success", "{{ trans('multi-new.0271')}}");
                    
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                $('#staticBackdrop').modal('hide');
            }
        });
    }

    function verinformativo()
    {
        var arreglo = @json($not);
        var html = "";
        Object.entries(arreglo).forEach(([key, value]) => {
            
            html += `<p>
                        ${arreglo[key]['mens']}
                    </p>`;
        });
        console.log(html);
        $("#staticBackdropLabel").html('Estimado Usuario(a):');
        $("#modalbody").html(`${html}`);
        $("#footerbody").html('<button type="button" class="btn btn-success btn-md" data-dismiss="modal" aria-label="Close">Aceptar</button>');
        $("#staticBackdrop").modal('show');
        
    }
    
</script>
@endsection
