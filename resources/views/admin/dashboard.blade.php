@extends('home')

@section('title')
{{ Auth::user()->name }}
@endsection

@section('extra-css')
@endsection

@section('index')
<div class="content">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">

        <div class="card card-stats">
        <a href="{{ route('users.index') }}">
            <div class="card-body ">
            <div class="row">
                <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-warning">
                    <i class="nc-icon nc-globe text-warning"></i>
                </div>
                </div>
                <div class="col-7 col-md-8">
                <div class="numbers">
                    <p class="card-category">{{ trans('multi-new.0297')}}</p>
                    <p class="card-title">{{ App\User::userCount() }}
                    <p>
                </div>
                </div>
            </div>
            </div>
            <div class="card-footer ">
            <hr>
            <div class="stats">
                <i class="fa fa-refresh"></i>
            </div>
            </div>
            </a>
        </div>

        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
        <a href="#">
            <div class="card-body ">
            <div class="row">
                <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-warning">
                    <i class="nc-icon nc-money-coins text-success"></i>
                </div>
                </div>
                <div class="col-7 col-md-8">
                <div class="numbers">
                    <p class="card-category">{{ trans('multi-new.0298')}}</p>
                    <p class="card-title">{{ App\Competitions::getCount() }}
                    <p>
                </div>
                </div>
            </div>
            </div>
            </a>
            <div class="card-footer ">
            <hr>
            <div class="stats">
                <i class="fa fa-calendar-o"></i>
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
        <a href="{{ route('login-activities') }}">
            <div class="card-body ">
            <div class="row">
                <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-warning">
                    <i class="nc-icon nc-vector text-danger"></i>
                </div>
                </div>
                <div class="col-7 col-md-8">
                <div class="numbers">
                    <p class="card-category">{{ trans('multi-new.0291')}}</p>
                    <p class="card-title">
                    <p>
                </div>
                </div>
            </div>
            </div>
        </a>
            <div class="card-footer ">
            <hr>
            <div class="stats">
                <i class="fa fa-clock-o"></i> {{ trans('multi-new.0295')}}
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-body ">
            <div class="row">
                <div class="col-5 col-md-4">
                <div class="icon-big text-center icon-warning">
                    <i class="nc-icon nc-favourite-28 text-primary"></i>
                </div>
                </div>
                <div class="col-7 col-md-8">
                <div class="numbers">
                    <p class="card-category">{{ trans('multi-new.0296')}}</p>
                    <p class="card-title">{{ App\Tracker::getCount() }}
                    <p>
                </div>
                </div>
            </div>
            </div>
            <div class="card-footer ">
            <hr>
            <div class="stats">
                <i class="fa fa-refresh"></i>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        <div class="card ">
            <div class="card-header ">
            <h5 class="card-title">Actividad Usuarios</h5>
            <p class="card-category">ïndice Mensual</p>
            </div>
            <div class="card-body ">
            <canvas id=chartHours width="400" height="100"></canvas>
            </div>
            <div class="card-footer ">
            <hr>
            <div class="stats">
                <i class="fa fa-history"></i> Esta información se actualiza cada 1 hora.
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title">Usuarios</h5>
                    <p class="card-category">Perfiles de Usuario</p>
                </div>
                <div class="card-body">
                    <canvas id="chartEmail"></canvas>
                </div>
                <div class="card-footer">
                    <hr/>
                    <div class="stats">
                        <i class="fa fa-calendar"></i> Número de usuarios por perfil
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title">Actividad Foros</h5>
                    <p class="card-category">Registro de Actividad Usuarios</p>
                </div>
                <div class="card-body">
                    <canvas id="speedChart" style="width:auto;"></canvas>
                </div>
                <div class="card-footer">
                    <div class="chart-legend">
                        <i class="fa fa-circle text-info"></i>
                        <i class="fa fa-circle text-warning"></i>
                    </div>
                    <hr/>
                    <div class="card-stats">
                        <i class="fa fa-check"></i> Esta información se actualiza cada 10 minutos
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalgenerico" tabindex="-1" role="dialog" aria-labelledby="modaltitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modaltitulo" style="color:#fff;"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalbody">
                
            </div>
            <div class="modal-footer" id="modalfooter">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    chartColor = "#FFFFFF";

    ctx = document.getElementById('chartHours').getContext("2d");

    myChart = new Chart(ctx, {
      type: 'line',

      data: {
        labels: ["ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC"],
        datasets: [{
            label: 'Administrador',
            borderColor: "#4ca750",
            backgroundColor: "#4ca750",
            pointRadius: 0,
            pointHoverRadius: 0,
            borderWidth: 3,
            data: [100, 110, 116, 122, 130, 106, 150, 95, 0, 0, 0, 0]
          },
          {
            label: 'Estudiantes',
            borderColor: "#f17e5d",
            backgroundColor: "#f17e5d",
            pointRadius: 0,
            pointHoverRadius: 0,
            borderWidth: 3,
            data: [320, 340, 365, 360, 370, 385, 390, 384, 0, 0, 0, 0]
          },
          {
            label: 'Docentes',
            borderColor: "#fcc468",
            backgroundColor: "#fcc468",
            pointRadius: 0,
            pointHoverRadius: 0,
            borderWidth: 3,
            data: [370, 394, 415, 409, 425, 445, 460, 450, 0, 0, 0, 0]
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Actividad Usuarios'
          }
        },

        tooltips: {
          enabled: false
        },

        scales: {
          yAxes: [{

            ticks: {
              fontColor: "#9f9f9f",
              beginAtZero: false,
              maxTicksLimit: 5,
              //padding: 20
            },
            gridLines: {
              drawBorder: false,
              zeroLineColor: "#ccc",
              color: 'rgba(255,255,255,0.05)'
            }

          }],

          xAxes: [{
            barPercentage: 1.6,
            gridLines: {
              drawBorder: false,
              color: 'rgba(255,255,255,0.1)',
              zeroLineColor: "transparent",
              display: false,
            },
            ticks: {
              padding: 20,
              fontColor: "#9f9f9f"
            }
          }]
        },
      }
    });
    //ctx = document.getElementById('chartEmail').getContext("2d");

    var oilCanvas = document.getElementById("chartEmail");

    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 10;

    var oilData = {
        labels: [
            "Admin.",
            "Doc.",
            "Est.",
            "Rev.",
            "Cor."
        ],
        datasets: [
            {
                data: [1, 1940, 1460, 10, 2],
                backgroundColor: [
                    '#1abed2',
                    '#fc9209',
                    '#e8403d',
                    '#E3E3E3',
                    '#4ca750'
                ]
            }]
    };

    var pieChart = new Chart(oilCanvas, {
    type: 'pie',
    data: oilData
    });

    var speedCanvas = document.getElementById("speedChart");

    var dataFirst = {
      data: [0, 19, 15, 20, 30, 40, 40, 50, 0, 0, 0, 0],
      fill: false,
      borderColor: '#fc9209',
      backgroundColor: 'transparent',
      pointBorderColor: '#fc9209',
      pointRadius: 4,
      pointHoverRadius: 4,
      pointBorderWidth: 8,
    };

    var dataSecond = {
      data: [0, 5, 10, 12, 20, 27, 30, 34, 0, 0, 0, 0],
      fill: false,
      borderColor: '#51CACF',
      backgroundColor: 'transparent',
      pointBorderColor: '#51CACF',
      pointRadius: 4,
      pointHoverRadius: 4,
      pointBorderWidth: 8
    };

    var speedData = {
      labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Agp", "Sep", "Oct", "Nov", "Dic"],
      datasets: [dataFirst, dataSecond]
    };

    var chartOptions = {
      legend: {
        display: false,
        position: 'top'
      }
    };

    var lineChart = new Chart(speedCanvas, {
      type: 'line',
      hover: false,
      data: speedData,
      options: chartOptions
    });
</script>
@endsection
