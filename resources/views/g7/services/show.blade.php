@extends('layouts.main')

@section('css')

@endsection

@section('title')
Chi tiết dịch vụ: {{ $object->name}}
@endsection
@section('content')
<div ng-controller="Service" ng-cloak>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Thông tin chung</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group custom-group">
                                <label class="form-label required-label">Tên dịch vụ</label>
                                <input class="form-control" ng-model="form.name" type="text" disabled="disabled">
                            </div>
                            <div class="form-group custom-group">
                                <label class="form-label required-label">Loại dịch vụ</label>
                                <div class="input-group mb-3">
                                    <ui-select remove-selected="false" ng-model="form.service_type_id" disabled="disabled">
                                        <ui-select-match placeholder="Chọn loại dịch vụ">
                                            <% $select.selected.name %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="t.id as t in (form.all_service_types | filter: $select.search)" ng-selected="t.id == form.service_type_id">
                                            <span ng-bind="t.name"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group text-center">
                                <div class="main-img-preview">
                                    <img class="thumbnail img-preview" ng-src="<% form.image.path %>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5>Vật tư tiêu hao theo nhóm dịch vụ</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên vật tư</th>
                                <th>Loại vật tư</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="p in form.products track by $index">
                                <td class="text-center"><% $index + 1 %></td>
                                <td><% p.product.name %></td>
                                <td><% p.product.category.name %></td>
                                <td>
                                    <input class="form-control" type="number" step=".01" ng-model="p._qty">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors['products.' + $index + '.qty'][0] %></strong>
                                    </span>
                                </td>
                            </tr>
                            <tr ng-if="!form.products.length">
                                <td colspan="5">Chưa khai báo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5>Giá dịch vụ</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-responsive" id="table-list">
                        <thead>
                            <tr>
                                <th style="width: 70px" rowspan="2">STT</th>
                                <th colspan="3">Dịch vụ</th>
                                <th colspan="3">Gói vật tư sử dụng</th>
                            </tr>
                            <tr>
                                <th style="width: 200px">Dòng xe</th>
                                <th style="width: 250px">Tên trên hóa đơn</th>
                                <th style="width: 150px">Giá dịch vụ</th>
                                <th style="width: 250px">Mã</th>
                                <th style="width: 250px">Tên</th>
                                <th style="width: 100px">Định mức</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat-start="v in form.service_vehicle_categories track by $index">
                                <td rowspan="<% v.rowspan %>" class="text-center"><% $index + 1 %></td>
                                <td rowspan="<% v.rowspan %>" style="width: 200px">
                                    <ui-select class="" remove-selected="false" ng-model="v.vehicle_category_id" disabled="disabled">
                                        <ui-select-match placeholder="Chọn dòng xe">
                                            <% $select.selected.name %>
                                        </ui-select-match>
                                        <ui-select-choices repeat="t.id as t in (v.available_categories | filter: $select.search)">
                                            <span ng-bind="t.name"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors['service_vehicle_categories.' + $index + '.vehicle_category_id'][0] %></strong>
                                    </span>
                                </td>
                                <td colspan="5" class="p-0 border-none"></td>
                            </tr>
                            <tr ng-repeat-start="g in v.groups">
                                <td class="text-center" rowspan="<% g.rowspan %>">
                                    <input class="form-control" type="text" step=".01" ng-model="g.name" disabled="disabled">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors['service_vehicle_categories.' + $parent.$index + '.groups.' + $index + '.name'][0] %></strong>
                                    </span>
                                </td>
                                <td rowspan="<% g.rowspan %>">
                                    <input class="form-control" type="text" ng-model="g.service_price" disabled="disabled">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong><% errors['service_vehicle_categories.' + $parent.$index + '.groups.' + $index + '.service_price'][0] %></strong>
                                    </span>
                                </td>
                                <td colspan="3" class="p-0 border-none"></td>
                            </tr>
                            <tr ng-repeat="p in g.products">
                                <td>
                                    <% p.product.code %>
                                </td>
                                <td><% p.product.name %></td>
                                <td>
                                    <input class="form-control" type="number" step=".01" ng-model="p._qty" disabled="disabled">
                                </td>
                            </tr>
                            <tr>

                            </tr>
                            <tr class="d-none" ng-repeat-end></tr>
                            <tr class="d-none" ng-repeat-end></tr>
                            <tr ng-if="!form.service_vehicle_categories.length">
                                <td colspan="8">Chưa có dữ liệu</td>
                            </tr>
                        </tbody>
                    </table>
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.service_vehicle_categories[0] %></strong>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="text-right">
        <a href="{{ route('Service.index') }}" class="btn btn-success btn-cons">
            <i class="fas fa-long-arrow-alt-left"></i> Quay về
        </a>
    </div>
</div>
@endsection
@section('script')
@include('partial.classes.uptek.Service')
<script>
    app.controller('Service', function ($scope, $http) {
    $scope.form = new Service(@json($object), {scope: $scope});
  });
</script>
@endsection