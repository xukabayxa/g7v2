@extends('layouts.main')
@section('page_title')
Trang chủ
@endsection


@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">

    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3 style="color: #fff; font-size: 18px">{{ number_format($data['bills']) }}</h3>
                <p>Hóa đơn bán trong ngày</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-invoice"></i>
            </div>
        </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3 style="color: #fff; font-size: 18px">{{ number_format($data['revenue_day']) }}</h3>
                <p>Doanh thu ngày</p>
            </div>
            <div class="icon">
                <i class="fas fa-receipt"></i>
            </div>
        </div>
    </div>


    <!-- ./col -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3 style="color: #fff; font-size: 18px">{{ number_format($data['revenue_month']) }}</h3>
                <p>Doanh thu tháng</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
        </div>
    </div>


    <!-- ./col -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3 style="color: #fff; font-size: 18px">{{ number_format($data['receipt_day']) }}</h3>
                <p>Tiền thu trong ngày</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3 style="color: #fff; font-size: 18px">{{ number_format($data['payment_day']) }}</h3>
                <p>Tiền chi trong ngày</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3 style="color: #fff; font-size: 18px">{{ number_format($data['reserve_fund'] ?? 0)}}</h3>
                <p>Tồn quỹ</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
<!-- Main row -->
<div class="row">
    <section class="col-lg-12 connectedSortable">
        <!-- BAR CHART -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">BÁO CÁO KINH DOANH THEO TUẦN</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <section class="col-lg-4 connectedSortable">
        <!-- TO DO List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    Bản tin G7 Autocare
                </h3>
            </div>
            <!-- /.card-header -->
            @php
            $post = App\Model\Uptek\Post::where('status',1)->orderBy('updated_at','desc')->first();
            @endphp
            <div class="card-body">
                <div class="banner-dash text-center">
                    @if($post)
                    <a href="{{ route('Post.show', $post->id) }}">
                        <img src="{{ $post->image->path }}" alt="">
                    </a>
                    <p class="text-center" style="margin-top: 15px"><a href="{{ route('Post.show', $post->id) }}" class="detail-link text-center text-uppercase text-bold" style="color: red">Click xem chi tiết</a></p>
                    @endif
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <section class="col-lg-4 connectedSortable">
        <!-- TO DO List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    Nhắc lịch hôm nay
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm">
                        <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                    </ul>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <ul class="todo-list" data-widget="todo-list" ng-controller="Reminders">
                    @foreach($reminders as $item)
                    <li>
                        <!-- drag handle -->
                        <span class="handle">
                            <i class="fas fa-angle-right"></i>
                            {{-- <i class="fas fa-ellipsis-v"></i> --}}
                        </span>
                        <!-- checkbox -->
                        {{-- <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="todo1" id="todoCheck1">
                            <label for="todoCheck1"></label>
                        </div> --}}
                        <!-- todo text -->
                        <span class="text">Xe: <strong style="color: blue">{{ $item->licensePlate->license_plate }}</strong> - <b>{{ $item->customers[0]->name }} - {{ $item->customers[0]->mobile }}</b></span>
                        <!-- Emphasis label -->
                        {{-- <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small> --}}
                        <!-- General tools such as edit or delete-->
                        <div class="tools detail-reminder" style="display:block" id="{{ $item->id }}">
                            <i class="fas fa-eye" id="{{ $item->id }}"></i>
                        </div>
                    </li>
                    @endforeach
                    </li>
                    @include('common.dashboard.show_reminder_detail')
                </ul>
            </div>
            <!-- /.card-body -->
            {{-- <div class="card-footer clearfix">
                <button type="button" class="btn btn-success float-right"><i class="fas fa-plus"></i> Thêm</button>
            </div> --}}
        </div>
        <!-- /.card -->
    </section>
    <section class="col-lg-4 connectedSortable" ng-controller="Log" ng-cloak>
        <!-- TO DO List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    Giao dịch trong ngày
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                {{-- Timeline --}}
                <div class="timeline">
                    <!-- timeline time label -->
                    <div class="time-label">
                        <span class="bg-success">Hôm nay: {{ \Carbon\Carbon::parse(now())->format('d/m/Y') }}</span>
                    </div>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <div ng-repeat="l in logs">
                        <i class="fas fa-user bg-green"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i>
                                <% calculateTime(l.time) %>
                            </span>
                            <h3 class="timeline-header no-border"><a href="#">
                                    <% l.user.name %>
                                </a>
                                <% l.content %>
                            </h3>
                        </div>
                    </div>
                    <!-- END timeline item -->
                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
                {{-- End timeline --}}
            </div>
        </div>
        <!-- /.card -->
    </section>
</div>
<!-- /.row (main row) -->
@endsection
@section('script')
@include('partial.classes.common.Car')
<script>
    app.controller('Reminders', function ($scope, $http) {
        $scope.form = {};

        $scope.dateReminderCheck = function(check) {
            console.log(check);
            var fDate,lDate,cDate;
            fDate = Date.parse(new Date());

            var ldate = new Date();
            ldate.setDate(ldate.getDate() + 10);

            lDate = Date.parse(ldate);
            cDate = Date.parse(check);

            if((cDate <= lDate && cDate >= fDate)) {
                return true;
            }
            return false;
        }

        /// Show Khách hàng
        $('.detail-reminder').on('click', function () {
            sendRequest({
                type: "GET",
                url: "/common/cars/" + $(this).attr('id') + "/getDataForShow",
                success: function(response) {
                    if (response.success) {
                        $scope.form = new Car(response.data, {scope: $scope});
                        $scope.$apply();
                        $('#show-reminder').modal('show');
                    } else {
                        toastr.warning(response.message);
                        $scope.errors = response.errors;
                    }
                }
            }, $scope);
        });
    })
</script>
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script>
    var today = new Date();

    function minusDays(dateObj, numDays) {
        dateObj.setDate(dateObj.getDate() - numDays);
        return dateObj;
    }

    function formatDate(date) {
        var dd = String(date.getDate()).padStart(2, '0');
        var mm = String(date.getMonth() + 1).padStart(2, '0');
        var yyyy = date.getFullYear();
        today = dd + '/' + mm + '/' + yyyy;
        return today;
    }

    var weeks = [];
    for(i = 0; i < 7; i++) {
        let now = new Date();
        day = minusDays(now, i);
        today = formatDate(day);
        weeks[i] = today;
    }
    weeks = weeks.reverse();
    let sales = @json($sales);
    let sale_data = weeks.map(w => {
        let exist = sales.find(val => dateGetter(val.day) == w);
        if (exist) return exist.cost_after_sale;
        return 0;
    })

    let total_receipt = @json($total_receipt);
    let receipt_data = weeks.map(w => {
        let exist = total_receipt.find(val => dateGetter(val.day) == w);
        if (exist) return exist.value;
        return 0;
    })

    var areaChartData = {
      labels  : weeks,
      datasets: [
        {
          label               : 'Doanh số ngày',
          backgroundColor     : 'rgb(38, 115, 215,0.9)',
          borderColor         : 'rgb(38, 115, 215,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgb(38, 115, 215,0.8)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgb(38, 115, 215,0.8)',
          data                : sale_data
        },
        {
          label               : 'Thu trong ngày',
          backgroundColor     : 'rgba(29, 187, 144, 1)',
          borderColor         : 'rgba(29, 187, 144, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(29, 187, 144, 1)',
          pointStrokeColor    : '#1DBB90',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(29, 187, 144,1)',
          data                : receipt_data
        }
      ]
    }
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp0
    barChartData.datasets[1] = temp1

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

	app.controller('Log', function ($scope, $http, $sce) {
        $scope.logs = @json(App\Model\Common\ActivityLog::getForDisplay());
    })
</script>
@endsection