$scope.loading = {};
$scope.getCustomers = function() {
    car_id = $scope.form.car_id;
    if(!car_id) $scope.form.customer_id = null;
    sendRequest({
        type: "GET",
        url: "/common/cars/" + car_id + "/getCustomers",
        success: function(response) {
            if (response.success) {
                $scope.form.customers = response.data;;
            }
        }
    }, $scope);
}