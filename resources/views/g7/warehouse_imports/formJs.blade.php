$scope.loading = {};

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
                $scope.form.addProduct(response.data);
                toastr.success('Thêm thành công');
                $scope.$applyAsync();
            }
        }
    });
}

createCustomerCallback = (response) => {
    $('select[name="customer_id"]').append('<option value="' + response.data.id + '" selected = "selected">' + response.data.name + '</option>');
    $('select[name="customer_id"]').val(response.data.id).trigger('change');
}

createSupplierCallBack = (response) => {
    $scope.form.suppliers.push(response);
    $scope.form.supplier_id = response.id;
}

$scope.addSupplier = function()
{
    $('#create-supplier').modal('show');
}