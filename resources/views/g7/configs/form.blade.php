<div class="card" style="max-width: 1000px; margin: 0 auto;">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="form-group">
					<label class="form-label required-label">Số ngày nhắc lịch</label>
					<input class="form-control" ng-model="form.date_reminder" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.date_reminder[0] %></strong>
					</span>
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