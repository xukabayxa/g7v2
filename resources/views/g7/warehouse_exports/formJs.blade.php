$scope.loading = {};

$scope.getBills = function() {
    sendRequest({
        type: 'GET',
        url: "{{ route('Bill.getDataForFinalAdjust') }}",
        success: function(response) {
            if (response.success) {
                $scope.form.bills = response.data;
            } else toastr.warning(response.message);
        }
    }, $scope)
}

let product_options = {
    title: "Vật tư",
    ajax: {
        url: "{!! route('Product.searchData') !!}",
        data: function (d, context) {
            DATATABLE.mergeSearch(d, context);
            d.status = 1;
        }
    },
    columns: [
        {data: 'DT_RowIndex', orderable: false, title: "STT"},
        {data: 'code', title: "Mã vật tư"},
        {data: 'name', title: "Tên vật tư"},
    ],
    search_columns: [
        {data: 'code', search_type: "text", placeholder: "Mã vật tư"},
        {data: 'name', search_type: "text", placeholder: "Tên vật tư"},
        {
            data: 'product_category_id', search_type: "select", placeholder: "Loại vật tư",
            column_data: @json(\App\Model\Common\ProductCategory::getForSelect())
        }
    ]
};

$scope.searchProduct = new BaseSearchModal(
    product_options,
    function(obj) {
        $scope.chooseProduct(obj);
    }
);

$scope.chooseProduct = function(obj) {
    sendRequest({
        type: 'GET',
        url: `/common/products/${obj.id}/getData`,
        success: function(response) {
            if (response.success) {
                $scope.form.addDetail(response.data);
                toastr.success('Thêm thành công');
                $scope.$applyAsync();
            }
        }
    });
}
