@extends('home')



@section('title')

{{ Auth::user()->name }}

@endsection



@section('extra-css')

<style>

    #nocat

    {

       color: red;

    }

</style>

@endsection



@section('index')

<div class="content">

    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="card">

                <div class="">

                    <h3>{{ trans('multi-leng.a290')}}</h3>
                    @role('admin')
                    <a href="{{ route('acciones.foro.publico.administrador') }}" class="btn btn-success btn-sm">{{ trans("lang.volver")}}</a>
                    @endrole
                    @hasanyrole('docente|user')

                        <a href="{{ route('ver-contenido-foro-publico-usuario-registrado') }}" class="btn btn-success btn-sm">{{ trans("lang.volver")}}</a>
                        
                    @endhasanyrole
                </div>

                <div class="card-body">

                    

                </div>

            </div>

        </div>

    </div>

</div>

<div class="modal" tabindex="-1" role="dialog" id="modaliframe">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header" style="color:#fff;padding:9px 15px;border-bottom:1px solid #eee;background-color: #5cb85c; -webkit-border-top-left-radius: 5px;

            -webkit-border-top-right-radius: 5px;-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;border-top-left-radius: 5px;

            border-top-right-radius: 5px;">

                <h5 class="modal-title" id="modaltitle">Modal title</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body" id="modalbody">

                

            </div>

            <div class="modal-footer" id="modalfooter">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lang.cancelar') }}</button>

            </div>

        </div>

    </div>

</div>

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

