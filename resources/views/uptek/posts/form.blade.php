<div class="row">
	<div class="col-md-9 col-sm-8 col-xs-12">
		<div class="card">
			<div class="card-header">
				<h5>Thông tin chung</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label">Tiêu đề bài viết</label>
							<span class="text-danger">(*)</span>
							<input class="form-control" ng-model="form.name" type="text">
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.name[0] %></strong>
							</span>
						</div>
						<div class="form-group">
							<label class="form-label">Tóm tắt nội dung</label>
							<textarea id="my-textarea" class="form-control" ng-model="form.intro" rows="3"></textarea>
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.intro[0] %></strong>
							</span>
						</div>
						<div class="form-group">
							<label class="form-label">Nội dung bài viết</label>
							<span class="text-danger">(*)</span>
							<textarea id="editor" class="form-control" ck-editor ng-model="form.body" rows="7"></textarea>
							<span class="invalid-feedback d-block" role="alert">
								<strong><% errors.body[0] %></strong>
							</span>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-4 col-xs-12">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<h5>Ảnh đại diện bài viết</h5>
				<div class="text-danger ml-1">(*)</div>
			</div>
			<div class="card-body">
				<div class="form-group text-center">
					<div class="main-img-preview">
						<p class="help-block-img">* Ảnh định dạng: jpg, png không quá 2MB.</p>
						<img class="thumbnail img-preview" ng-src="<% form.image.path %>">
					</div>
					<div class="input-group" style="width: 100%; text-align: center">
						<div class="input-group-btn" style="margin: 0 auto">
							<div class="fileUpload fake-shadow cursor-pointer">
								<label class="mb-0" for="<% form.image.element_id %>">
									<i class="glyphicon glyphicon-upload"></i> Chọn ảnh
								</label>
								<input class="d-none" id="<% form.image.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
							</div>
						</div>
					</div>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.image[0] %></strong>
					</span>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<h5>Trạng thái</h5>
				<div class="text-danger ml-1">(*)</div>
			</div>
			<div class="card-body">
				<div class="form-group">
					<select id="my-select" class="form-control custom-select" ng-model="form.status">
						<option value="">Chọn trạng thái</option>
						<option ng-repeat="s in form.statuses" ng-value="s.id" ng-selected="form.status == s.id"><% s.name %></option>
					</select>
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
	<button type="submit" class="btn btn-success btn-cons" ng-click="submit(1)" ng-disabled="loading.submit || form.status != 1">
		<i ng-if="!loading.submit" class="fa fa-save"></i>
		<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
		Lưu & Thông báo
	</button>
	<a href="{{ route('Post.index') }}" class="btn btn-danger btn-cons">
		<i class="fa fa-remove"></i> Hủy
	</a>
</div>
