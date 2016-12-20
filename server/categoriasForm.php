<?php 
	require 'db/requires.php';
	$gen = new General();
	if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login']) ) {
		if (isset($_GET['idCategoria']) && (int) $_GET['idCategoria'] > 0) {
			$accion = "Editar";
			$subcategoria = $gen->getTotalDatos('VenCategoria',null,array('idCategoria'=> $_GET['idCategoria'],'estado'=>'A'));
			$smarty->assign('subcategoria',$subcategoria[0]);
		}else{
			$accion = "Crear";
		}
		$cook = base64_decode($_COOKIE['login']);
		$cook = explode('+', $cook);
		$smarty->assign('user',$cook);
		
		$categoria = $gen->getTotalDatos('VenCategoria',null,array('estado'=>'A'));
		$smarty->assign('categoria',$categoria);
		$smarty->assign('titleForm',$accion);
		$smarty->display('users-form.html');
	}else{
		header('Location:login.php');
	}
?>