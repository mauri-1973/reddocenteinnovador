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
    caption{
        color:#fff;
        caption-side: top;
        font-size:16px;
    }
</style>
@endsection
@section('index')
<div class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row justify-content-center mt-4">
                
                <div class="col-md-12">
                    <div class="card mb-4 bg-success shadow-sm">
                        <div class="card-body">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-white">
                                        <h4>{{ trans('multi-leng.a205') }} <strong class="statusval">{{ $text }}</strong></h4>
                                    </div>
                                    @if($count == 0)
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-white">
                                    <h5>Auditor(a) : <strong class="statusval">Sin auditores</strong></h5>
                                    </div>
                                    @endif
                                    @if($count == 1)
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-white">
                                        @foreach($arreglo as $arr)
                                        <h5>Auditor(a) : <strong class="statusval">{{ $arr->nombre }}</strong></h5>
                                        @endforeach
                                    </div>
                                    @endif
                                    @if($count > 1)
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-white">
                                        @foreach($arreglo as $arr)
                                        <h5>Auditores(as) : <strong class="statusval">{{ $arr->nombre }}</strong></h5>
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-white">
                                        @role('docente')

                                            <a href="{{ route('ver-formulario-docente-concurso-finalizado', $id ) }}" class="btn btn-warning btn-sm btn-block">{{ trans('lang.volver')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>
                                        
                                        @endrole
                                        @role('auditor')

                                            <a href="#" class="btn btn-warning btn-sm btn-block">{{ trans('lang.volver')}}&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>

                                        @endrole
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-white">
                                        
                                        <a href="#" role="button" id="imprimir" class="btn btn-warning btn-sm btn-block" @if($count == 0) disabled @endif>Imprimir Actas&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></a>

                                    </div> 
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-white">
                                        <button onclick="verinformativo()" role="button" id="informativo1" class="btn btn-danger btn-sm btn-block">Informativo Actas&nbsp;<i class="nc-icon nc-tap-01" style="font-size:15px;"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-1">
                    <div class="card mb-4 bg-success shadow-sm">
                        <div class="card-body">
                            <div class="content">
                                <div class="row">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-t-2 border-gray-600">
                            
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

<input type="hidden" id="idconc" name="idconc" value="">
<input type="hidden" id="idpost" name="idpost" value="">
<input type="hidden" id="idansw" name="idansw" value="">

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
