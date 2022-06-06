
$scope.getPayer = function() {
    payer_type_id = $scope.form.payer_type_id;
    $scope.form.payer_id = '';
    if (!$scope.form.payer_type_id) $scope.form.payer_id = null;
    sendRequest({
        type: "GET",
        url: "/g7/funds/receipt-vouchers/" + $scope.form.payer_type_id + "/get-payer",
        success: function(response) {
            if (response.success) {
                $scope.form.payers = response.data;
            }
        }
    }, $scope);
}


$scope.getBills = function() {
    customer_id = $scope.form.customer_id;
    $scope.form.bills = '';
    if (!$scope.form.customer_id) $scope.form.bill_id = null;
    sendRequest({
        type: "GET",
        url: "/g7/bills/" + customer_id + "/getDataByCustomer",
        success: function(response) {
            if (response.success) {
                $scope.form.bills = response.data;
            }
        }
    }, $scope);
}


$scope.getBillDetail = function() {
    bill_id = $scope.form.bill_id;
    $scope.form.bill = null;
    sendRequest({
        type: "GET",
        url: "/g7/bills/" + bill_id + "/getDataForShow2",
        success: function(response) {
        if (response.success) {
        $scope.form.value = response.data.cost_after_vat - response.data.payed_value;
        }
    }
    }, $scope);
}
