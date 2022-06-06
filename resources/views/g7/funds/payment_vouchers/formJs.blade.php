
$scope.getRecipient = function() {
    recipient_type_id = $scope.form.recipient_type_id;
    $scope.form.recipient_id = '';
    if (!$scope.form.recipient_type_id) $scope.form.recipient_id = null;
    sendRequest({
        type: "GET",
        url: "/g7/funds/payment-vouchers/" + $scope.form.recipient_type_id + "/getRecipient",
        success: function(response) {
            if (response.success) {
                $scope.form.recipients = response.data;
            }
        }
    }, $scope);
}

$scope.getWarehouseImports = function() {
    supplier_id = $scope.form.supplier_id;
    $scope.form.warehouse_imports = '';
    if (!$scope.form.supplier_id) $scope.form.ware_house_import_id = null;
    sendRequest({
        type: "GET",
        url: "/g7/warehouse-imports/" + supplier_id + "/getDataBySupplier",
        success: function(response) {
            if (response.success) {
                $scope.form.warehouse_imports = response.data;
console.log($scope.form.warehouse_imports);
            }
        }
    }, $scope);
}
