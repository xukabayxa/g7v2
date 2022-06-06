@extends('layouts.main')

@section('css')
@endsection

@section('title')
Danh mục nhắc lịch CSKH
@endsection

@section('buttons')
<a class="btn btn-outline-success" data-toggle="modal" href="javascript:void(0)" data-target="#create-reminder" class="btn btn-info" ng-click="errors = null"><i class="fa fa-plus"></i> Thêm mới</a>
<a href="javascript:void(0)" target="_blank" data-href="{{ route('CalendarReminder.exportExcel') }}" class="btn btn-info export-button"><i class="fas fa-file-excel"></i> Xuất file excel</a>
<a href="javascript:void(0)" target="_blank" data-href="{{ route('CalendarReminder.exportPDF') }}" class="btn btn-warning export-button"><i class="far fa-file-pdf"></i> Xuất file pdf</a>
@endsection
@section('content')
<div ng-cloak>
    <div class="row" ng-controller="CalendarReminder">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table-list">
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Form tạo mới --}}
    @include('g7.calendar_reminders.create_reminder')
    @include('g7.calendar_reminders.edit_reminder')
</div>
@endsection

@section('script')
@include('partial.classes.g7.CalendarReminder')
<script>
    let datatable = new DATATABLE('table-list', {
		ajax: {
			url: '{!! route('CalendarReminder.searchData') !!}',
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
			}
		},
		columns: [
			{data: 'DT_RowIndex', orderable: false, title: "STT"},
			{data: 'customer', orderable: false, title: "Khách hàng"},
            {data: 'car', title: 'Xe'},
            {data: 'reminder_date', title: 'Ngày đặt lịch'},
            {data: 'type', title: 'Loại nhắc lịch'},
            {data: 'note', title: 'Ghi chú'},
            {
				data: 'status',
				title: "Trạng thái",
				render: function (data) {
					return getStatus(data, @json(App\Model\G7\CalendarReminder::STATUSES));
				}
			},
			// {data: 'updated_by', title: "Người tạo"},
			{data: 'action', orderable: false, title: "Hành động"}
		],
		search_columns: [

            {
				data: 'type_id', search_type: "select", placeholder: "Loại nhắc lịch",
				column_data: @json(\App\Model\G7\CalendarReminder::TYPES)
			},
            {
				data: 'customer_id', search_type: "select", placeholder: "Khách hàng",
				column_data: @json(\App\Model\Common\Customer::getForSelect())
			},

            {
				data: 'status', search_type: "select", placeholder: "Trạng thái",
				column_data: @json(\App\Model\G7\CalendarReminder::STATUSES)
			}
		],
		search_by_time: true,
	}).datatable;

    createReminderCallback = (response) => {
        datatable.ajax.reload();

    }

    app.controller('CalendarReminder', function ($scope, $rootScope, $http) {
        $scope.loading = {};
        // Check Confirmed
        $('#table-list').on('click', '.confirmed', function () {
            $scope.data = getRowData(this, datatable);

            swal({
                title: "Xác nhận đã xử lý",
                text: "Bạn chắc chắn lịch hẹn đã hoàn thành?",
                type: "success",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Có",
                cancelButtonClass: "btn-danger",
                cancelButtonText: "Không",
                closeOnConfirm: true
            }, function(isConfirm) {
                if (isConfirm) {
                    sendRequest({
                        type: "GET",
                        url: "/g7/calendar-reminders/"+$scope.data.id+"/conFirmed",
                        success: function(response) {
                            if (response.success) {
                                if(datatable) datatable.ajax.reload();
                                toastr.success(response.message);
                            }
                        }
                    }, $scope);

                } else {
                    if(datatable) datatable.ajax.reload();
                }
            })
        });
        // Sửa
        $('#table-list').on('click', '.edit', function () {
            $scope.data = getRowData(this, datatable);
            sendRequest({
                type: "GET",
                url: "/g7/calendar-reminders/"+$scope.data.id+"/getDataForEdit",
                success: function(response) {
                    if (response.success) {
                        if (response.success) {
                            $rootScope.$emit("editReminder", response.data);
                        } else {
                            toastr.warning(response.message);
                            $scope.errors = response.errors;
                        }
                    }
                }
            }, $scope);


        });
    })

    $(document).on('click', '.export-button', function(event) {
        event.preventDefault();
        let data = {};
        mergeSearch(data, datatable.context[0]);
        window.location.href = $(this).data('href') + "?" + $.param(data);
    })
</script>
@include('partial.confirm')
@endsection
