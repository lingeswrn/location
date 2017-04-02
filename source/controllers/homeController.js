app.controller("homeController" , function($scope, $http){
    $scope.searchType = '0';
    $scope.chooseSearch = function(type){
        if( type === '2' ){
            $scope.districtHolder = true;
            $scope.collegeHolder = false;
        }else if( type === '1' ){
            $scope.districtHolder = false;
            $scope.collegeHolder = true;
        }
    };
    
    $scope.getAllColleges = function(){
        $http.post('modals/index.php',{type: 'districts'}).then( function(response){
            console.log(response)
        });
        //this.colleges = 
    };
    $scope.getAllColleges();
});
