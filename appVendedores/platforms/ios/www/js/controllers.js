angular.module('app.controllers', ['ionic'])
  
.controller('loginCtrl', ['$scope', '$stateParams', '$ionicLoading', '$ionicPopup', '$timeout', '$state', 'ServiceGeneral',
function($scope, $stateParams, $ionicLoading, $ionicPopup, $timeout, $state, ServiceGeneral) {
	$scope.login = function(usuario){
		if (usuario && usuario.user && usuario.user != "" && usuario.pass && usuario.pass != "") {
			$ionicLoading.show({
				template: 'Cargando...'
			});
			//var placa = $scope.placa;
			var parameters = {
				accion : "login",
				usuario : usuario.user,
				contrasena : usuario.pass
			};
			ServiceGeneral.post(parameters)
			.then(function(result){
				$ionicLoading.hide();
				if(result.error == 1){
					window.localStorage.setItem('us3r4pp', JSON.stringify(result.data));
					$state.go('menu.main');
				}else if(result.error == 2){
					$ionicPopup.alert({
						title: 'Usuario incorrecto',
						template: 'El usuario no es correcto'
					});
				}
			},function(err){
				$ionicLoading.hide();
			});
		}else{
			$ionicPopup.alert({
				title: 'Datos incorrectos',
				template: 'Por favor ingrese Usuario y contraseña'
			});
		}
	}
}])

.controller('menuCtrl', ['$scope', '$stateParams', '$ionicLoading', '$state', 'ServiceGeneral',
function ($scope, $stateParams, $ionicLoading, $state, ServiceGeneral) {
	// Trae Los datos del usuario
	var userData = JSON.parse( window.localStorage.getItem('us3r4pp'));
	$scope.nombreUsuario = userData.nombre + " " + userData.apellido;
	$scope.puntosUsuario = userData.puntos;
	$scope.cargoUsuario = userData.cargo;
	// Carga las 2 primeras categorías de la base de datos
	$ionicLoading.show({
		template: 'Cargando...'
	});
	var parameters = {
		accion : "getCategorias"
	};
	ServiceGeneral.post(parameters)
	.then(function(result){
		$ionicLoading.hide();
		if(result.error == 1){
			$scope.categoria1 = {
				idCategoria: result.data[0].idCategoria,
				nombre: result.data[0].nombre
			}
			$scope.categoria2 = {
				idCategoria: result.data[1].idCategoria,
				nombre: result.data[1].nombre
			}
			$scope.categorias = result.data;
		}else{
			console.log("error","Ocurrio un error");
		}
	},function(err){
		$ionicLoading.hide();
	});

	// Selecciona la categoria y redirige a las subcategorias
	$scope.selMenuCategoria = function(categoria){
		$state.go('menu.subcategoria',categoria);
	}

	// Cerrar sesión
	$scope.loguot = function(){
		localStorage.removeItem('us3r4pp');
		$state.go('login');
	}
}])

.controller('mainCtrl', ['$scope', '$stateParams', '$ionicLoading', '$state', 'ServiceGeneral',
function ($scope, $stateParams, $ionicLoading, $state, ServiceGeneral) {
	// Si el usuario no esta logueado lo redirigue al login
	var userData = JSON.parse( window.localStorage.getItem('us3r4pp'));
	if (userData == null || userData.idUsuario == "") {
		$state.go('login');
	};
	
	// Carga las 2 primeras categorías de la base de datos
	$ionicLoading.show({
		template: 'Cargando...'
	});
	var parameters = {
		accion : "getCategorias"
	};
	ServiceGeneral.post(parameters)
	.then(function(result){
		$ionicLoading.hide();
		if(result.error == 1){
			$scope.categoria1 = {
				idCategoria: result.data[0].idCategoria,
				nombre: result.data[0].nombre
			}
			$scope.categoria2 = {
				idCategoria: result.data[1].idCategoria,
				nombre: result.data[1].nombre
			}
			$scope.categorias = result.data;
		}else{
			console.log("error","Ocurrio un error");
		}
	},function(err){
		$ionicLoading.hide();
	});

	// Selecciona la categoria y redirige a las subcategorias
	$scope.selCategoria = function(categoria){
		$state.go('menu.subcategoria',categoria);
	}
}])

.controller('subcategoriaCtrl', ['$scope', '$stateParams', '$ionicLoading', '$state', 'ServiceGeneral',
function ($scope, $stateParams, $ionicLoading, $state, ServiceGeneral) {
	var idCategoria = $stateParams.idCategoria;
	var nombreCategoria = $stateParams.nombre;
	$ionicLoading.show({
		template: 'Cargando...'
	});
	var parameters = {
		accion : "getSubcategorias",
		idCategoria : idCategoria
	};
	ServiceGeneral.post(parameters)
	.then(function(result){
		$ionicLoading.hide();
		if(result.error == 1){
			var nDiv = 1;
			var subcategorias = result.data;
			for (var i = 0; i < subcategorias.length; i++) {
				subcategorias[i].nDiv = nDiv;
				if (subcategorias[i].nombre.length >= 21) {
					subcategorias[i].nombre = subcategorias[i].nombre.substring(0,21)+"...";
				};
				nDiv++;
				if (nDiv == 6) {nDiv = 1};
			};
			$scope.categoria = nombreCategoria;
			$scope.subcategorias = subcategorias;
			console.log("subcategorias",subcategorias);
		}else{
			console.log("error","Ocurrio un error");
		}
	},function(err){
		$ionicLoading.hide();
	});

	// Selecciona la categoria y redirige a las subcategorias
	$scope.selSubcategoria = function(subcat){
		var subcategoria = {
			categoria: nombreCategoria,
			idCategoria: idCategoria,
			idSubcategoria: subcat.idCategoria,
			nombreSubcategoria: subcat.nombre,
			fechaSubcategoria: subcat.fechaMod
		}
		console.log(subcategoria);
		$state.go('menu.listanoticias', subcategoria);
	}
}])

.controller('listaNoticiasCtrl', ['$scope', '$stateParams', '$ionicLoading', '$state', 'ServiceGeneral',
function ($scope, $stateParams, $ionicLoading, $state, ServiceGeneral) {
	$scope.categoria = $stateParams.categoria;
	$scope.nombreSubcategoria = $stateParams.nombreSubcategoria;
	$scope.fechaSubcategoria = $stateParams.fechaSubcategoria;
	var idSubcategoria = $stateParams.idSubcategoria;
	$ionicLoading.show({
		template: 'Cargando...'
	});
	var parameters = {
		accion : "getNoticias",
		idSubcategoria : idSubcategoria
	};
	ServiceGeneral.post(parameters)
	.then(function(result){
		$ionicLoading.hide();
		if(result.error == 1){
			$scope.noticias = result.data;
			console.log("lista noticias",result.data);
		}else{
			console.log("error","Ocurrio un error");
		}
	},function(err){
		$ionicLoading.hide();
	});

	// Carga las 2 primeras categorías de la base de datos
	$ionicLoading.show({
		template: 'Cargando...'
	});
	parameters = {
		accion : "getCategorias"
	};
	ServiceGeneral.post(parameters)
	.then(function(result){
		$ionicLoading.hide();
		if(result.error == 1){
			$scope.categoria1 = {idCategoria: result.data[0].idCategoria}
			$scope.categoria2 = {idCategoria: result.data[1].idCategoria}
		}else{
			console.log("error","Ocurrio un error");
		}
	},function(err){
		$ionicLoading.hide();
	});

	// Selecciona la categoria y redirige a las subcategorias
	$scope.selCategoria = function(categoria){
		$state.go('menu.subcategoria',categoria);
	}

	// Selecciona la nonticia y redirige al detalle de la noticia
	$scope.selNoticia = function(idNoticia){
		$state.go('menu.detalle',{idNoticia:idNoticia});
	}
}])

.controller('detalleCtrl', ['$scope', '$stateParams', '$ionicLoading', '$state', 'ServiceGeneral',
function ($scope, $stateParams, $ionicLoading, $state, ServiceGeneral) {
	var idNoticia = $stateParams.idNoticia;

	$ionicLoading.show({
		template: 'Cargando...'
	});
	var parameters = {
		accion : "getNoticia",
		idNoticia : idNoticia
	};
	ServiceGeneral.post(parameters)
	.then(function(result){
		$ionicLoading.hide();
		if(result.error == 1){
			$scope.detalleNoticia = result.data;
		}else{
			console.log("error","Ocurrio un error n. "+result.error );
		}
	},function(err){
		$ionicLoading.hide();
	});
}])