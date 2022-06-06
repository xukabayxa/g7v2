$scope.loading = {};

$scope.searchAsset = new BaseSearchModal(
    {
		title: "Tài sản cố định",
		ajax: {
			url: "{!! route('G7FixedAsset.searchData') !!}",
			data: function (d, context) {
				DATATABLE.mergeSearch(d, context);
				d.status = 1;
			}
		},
		columns: [
			{data: 'code', title: "Mã"},
			{data: 'name', title: "Tên"},
		],
		search_columns: [
			{data: 'code', search_type: "text", placeholder: "Mã"},
			{data: 'name', search_type: "text", placeholder: "Tên"},
		]
	},
    function(obj) {
        $scope.chooseAsset(obj);
    }
);

$scope.chooseAsset = function(obj) {
    sendRequest({
        type: 'GET',
        url: `/g7/g7_fixed_assets/${obj.id}/getData`,
        success: function(response) {
            if (response.success) {
				console.log(response.data);
                $scope.form.addDetail(response.data);
                toastr.success('Thêm thành công');
                $scope.$applyAsync();
            }
        }
    });
}

createSupplierCallBack = (response) => {
    $scope.form.suppliers.push(response);
    $scope.form.supplier_id = response.id;
}

$scope.addSupplier = function()
{
    $('#create-supplier').modal('show');
}