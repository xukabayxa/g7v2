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
