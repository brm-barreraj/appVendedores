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
		
		$categorias = $gen->getTotalDatos('VenCategoria',null,array('idPadre'=>'0','estado'=>'A'));
		$smarty->assign('categorias',$categorias);
		$smarty->assign('titleForm',$accion);
		$smarty->assign('seccion','categoria');//nombre de la seccion en la que estamos actualmente
		$smarty->display('category-form.html');
	}else{
		header('Location:login.php');
	}
?>