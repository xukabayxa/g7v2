<div class="card" style="max-width: 1000px; margin: 0 auto;">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="form-group">
					<label class="form-label required-label">Tỉ lệ quy đổi thành điểm</label>
					<div class="custom-form-control">
						<input class="form-control text-right mr-2" ng-model="form.value_to_point_rate" type="text">
						<div class="des-label"><span> = 1 điểm</span></div>
					</div>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.value_to_point_rate[0] %></strong>
					</span>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">

				<div class="form-group">
					<label class="form-label required-label">Tỉ lệ quy đổi điểm thành tiền</label>
					<div class="custom-form-control">
						<div class="des-label"><span>1 điểm = </span></div>
						<input class="form-control text-right" ng-model="form.point_to_money_rate" type="text">
					</div>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.point_to_money_rate[0] %></strong>
					</span>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="form-group">
					<div class="form-check">
						<input id="allow-pay" class="form-check-input" type="checkbox" ng-model="form.allow_pay">
						<label for="allow-pay" class="form-check-label">Cho phép thanh toán bằng điểm</label>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="form-group">
					<div class="form-check">
						<input id="accumulate_pay_point" class="form-check-input" type="checkbox" ng-model="form.accumulate_pay_point">
						<label for="accumulate_pay_point" class="form-check-label">Tích lũy khi thanh toán bằng điểm</label>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="form-group">
					<div class="custom-control custom-radio">
					  <input class="custom-control-input" value="1" type="radio" id="customRadio1" ng-model="form.type" ng-checked="form.type == 1">
					  <label for="customRadio1" class="custom-control-label">Tích lũy theo giá trị hóa đơn</label>
					</div>
				  </div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="form-group">
					<div class="custom-control custom-radio">
					  <input class="custom-control-input" value="2" type="radio" id="customRadio2" ng-model="form.type"  ng-checked="form.type == 2">
					  <label for="customRadio2" class="custom-control-label">Tích lũy theo hàng hóa/dịch vụ</label>
					</div>
				  </div>
			</div>
		</div>
	</div>
</div>
<hr>
<div class="text-right">
	<button type="submit" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
		<i ng-if="!loading.submit" class="fa fa-save"></i>
		<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
		Lưu
	</button>
</div>