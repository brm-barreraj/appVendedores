<?php 
	require 'db/requires.php';
	$gen = new General();
	if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login']) ) {
		if (isset($_GET['idUsuario']) && (int) $_GET['idUsuario'] > 0) {
			$accion = "Editar";
			$usuario = $gen->getTotalDatos('VenUsuario',null,array('idUsuario'=> $_GET['idUsuario'],'estado'=>'A'));
			$smarty->assign('usuario',$usuario[0]);
		}else{			
			$accion = "Crear";
		}
		$cook = base64_decode($_COOKIE['login']);
		$cook = explode('+', $cook);
		$smarty->assign('user',$cook);
		
		$cargos = $gen->getTotalDatos('VenCargo',null,array('estado'=>'A'));
		$smarty->assign('cargos',$cargos);
		$smarty->assign('titleForm',$accion);
		$smarty->assign('seccion','usuario');//nombre de la seccion en la que estamos actualmente
		$smarty->display('users-form.html');
	}else{
		header('Location:login.php');
	}
?>