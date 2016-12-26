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
	if (userData != null && userData.idUsuario != "") {
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
	}
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
	}else{
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
	}

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
		$state.go('menu.listanoticias', subcategoria);
	}
}])

.controller('listaNoticiasCtrl', ['$scope', '$stateParams', '$ionicLoading', '$state', 'ServiceGeneral',
function ($scope, $stateParams, $ionicLoading, $state, ServiceGeneral) {
	var idProducto = 0
	$scope.categoria = $stateParams.categoria;
	$scope.nombreSubcategoria = $stateParams.nombreSubcategoria;
	$scope.fechaSubcategoria = $stateParams.fechaSubcategoria;
	$scope.noticia1 = [];
	$scope.noticias = [];
	$scope.estadoScroll = false;
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
			$scope.categoria1 = {
				idCategoria: result.data[0].idCategoria,
				nombre: result.data[0].nombre
			}
			$scope.categoria2 = {
				idCategoria: result.data[1].idCategoria,
				nombre: result.data[1].nombre
			}
	}else{
			console.log("error","Ocurrio un error");
		}
	},function(err){
		$ionicLoading.hide();
	});

	// Trae el listado de productos
	$ionicLoading.show({
		template: 'Cargando...'
	});
	var parameters = {accion : "getProductos"};
	ServiceGeneral.post(parameters)
	.then(function(result){
		$ionicLoading.hide();
		if(result.error == 1){
			$scope.productos = result.data;
			$scope.productos.unshift({
				idProducto: 0,
				nombre: "Productos"
			});
			$scope.productoModel = result.data[0];
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
	
	// Reduce el tamaño de los titulos del listado de noticias
	$scope.reducirTamTitle = function(str){
		return (str.length > 64) ? str.substring(0,64)+"..." : str;
	}
	
	// Scroll
	$scope.loadMore = function() {
		listNoticias(false);
		$scope.$broadcast('scroll.infiniteScrollComplete');
	};

	// Refresh
	$scope.doRefresh = function() {
		listNoticias(true);
	};
	
	// Lista las noticas
	var listNoticias = function(reiniciar) {
		console.log("length",$scope.noticias);

		if (reiniciar || $scope.noticias.length == 0) {
			$scope.noticia1 = [];
			$scope.noticias = [];
			$scope.estadoScroll = false;
			desde = 0;
		}else{
			desde = ($scope.noticias.length+1);
		};
		
		// Trae el listado de noticias de un producto
		var idSubcategoria = $stateParams.idSubcategoria;
		$ionicLoading.show({
			template: 'Cargando...'
		});
		var parameters = {
			accion : "getNoticias",
			idSubcategoria : idSubcategoria,
			idProducto: idProducto,
			desde : desde
		};
		ServiceGeneral.post(parameters)
		.then(function(result){
			$ionicLoading.hide();
			$scope.$broadcast('scroll.refreshComplete');
			if(result.error == 1){
				var noticias = result.data;
				if (!noticias) {
					$scope.estadoScroll = true;
				}else{
					if (reiniciar || $scope.noticias.length == 0) {
						$scope.noticia1 = result.data[0];
						noticias.shift();
						$scope.noticias = noticias;
					}else{
						for (var i = 0; i < noticias.length; i++) {
							$scope.noticias.push(noticias[i]);
						};
					};
				};
				
			}else{
				console.log("error","Ocurrio un error");
			}
		},function(err){
			$ionicLoading.hide();
		});
	};

	// Evento al seleccionar el producto
	$scope.selectedProd = function(idProd){
		idProducto = idProd;
		listNoticias(true);
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