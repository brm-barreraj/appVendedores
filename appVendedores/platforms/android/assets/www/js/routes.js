angular.module('app.routes', [])

.config(function($stateProvider, $urlRouterProvider) {

  // Ionic uses AngularUI Router which uses the concept of states
  // Learn more here: https://github.com/angular-ui/ui-router
  // Set up the various states which the app can be in.
  // Each state's controller can be found in controllers.js
  $stateProvider
    

  .state('menu.listanoticias', {
    url: '/listanoticias/:categoria/:idCategoria/:idSubcategoria/:nombreSubcategoria/:fechaSubcategoria/',
    views: {
      'side-menu21': {
        templateUrl: 'templates/listanoticias.html',
        controller: 'listaNoticiasCtrl'
      }
    }
  })


  .state('menu.detalle', {
    url: '/detalle/:idNoticia',
    views: {
      'side-menu21': {
        templateUrl: 'templates/detalle.html',
        controller: 'detalleCtrl'
      }
    }
  })

  .state('menu.main', {
    url: '/main',
    views: {
      'side-menu21': {
        templateUrl: 'templates/main.html',
        controller: 'mainCtrl'
      }
    }
  })

  .state('menu.subcategoria', {
    url: '/subcategoria/:idCategoria/:nombre/',
    views: {
      'side-menu21': {
        templateUrl: 'templates/subcategoria.html',
        controller: 'subcategoriaCtrl'
      }
    }
  })

  .state('menu', {
    url: '/menu',
    templateUrl: 'templates/menu.html',
    controller: 'menuCtrl'
  })

  .state('login', {
    url: '/login',
    templateUrl: 'templates/login.html',
    controller: 'loginCtrl'
  })

$urlRouterProvider.otherwise('/menu/main')

  

});