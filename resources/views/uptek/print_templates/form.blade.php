<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="card-header">
				<h5>Chỉnh sửa mẫu in</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label">Tên mẫu</label>
							<span class="text-danger">(*)</span>
							<input class="form-control" ng-model="form.name" type="text">
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.name[0] %></strong>
							</span>
						</div>
						<div class="form-group">
							<label class="form-label">Mã</label>
							<span class="text-danger">(*)</span>
							<input class="form-control" ng-model="form.code" type="text">
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.code[0] %></strong>
							</span>
						</div>

						<div class="form-group">
							<label class="form-label">Mẫu in</label>
							<span class="text-danger">(*)</span>
							<textarea class="form-control" ck-editor ng-model="form.template" rows="7"></textarea>
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.template[0] %></strong>
							</span>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<hr>
<div class="text-right">
	<button type="submit" class="btn btn-success btn-cons" ng-click="submit(0)" ng-disabled="loading.submit">
		<i ng-if="!loading.submit" class="fa fa-save"></i>
		<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
		Lưu
	</button>
	<a href="{{ route('PrintTemplate.index') }}" class="btn btn-danger btn-cons">
		<i class="fa fa-remove"></i> Hủy
	</a>
</div>
