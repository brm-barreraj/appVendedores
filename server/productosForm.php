<?php 
	require 'db/requires.php';
	$gen = new General();
	if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login']) ) {
		if (isset($_GET['idProducto']) && (int) $_GET['idProducto'] > 0) {
			$accion = "Editar";
			$productos = $gen->getTotalDatos('VenProducto',null,array('idProducto'=> $_GET['idProducto'],'estado'=>'A'));
			$smarty->assign('productos',$productos[0]);
		}else{
			$accion = "Crear";
		}
		$cook = base64_decode($_COOKIE['login']);
		$cook = explode('+', $cook);
		$smarty->assign('user',$cook);
		$smarty->assign('titleForm',$accion);
		$smarty->assign('seccion','producto');//nombre de la seccion en la que estamos actualmente
		$smarty->display('producto-form.html');
	}else{
		header('Location:login.php');
	}
?>