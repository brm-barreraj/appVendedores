angular.module('app.services', [])

.factory('BlankFactory', [function(){

}])

.service('ServiceGeneral', function ($http, $q){
	this.post = function(parameters) {
		var dfd = $q.defer();
		// http://127.0.0.1/ionic/appCiti/server/
		// http://127.0.0.1/appVendedores/
		// http://fbapp.brm.com.co/fbappFundacion/appVendedores/
		$http.post('http://localhost:8080/appVendedores/server/serviceApp.php',parameters,{ headers: {'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8'}})
		.success(function(data) {
			dfd.resolve(data);
		})
		.error(function(data) {
			dfd.reject(data);
		});
		return dfd.promise;
	};
});