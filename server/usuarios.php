<?php 
	require 'db/requires.php';
	$gen = new General();
	if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login']) ) {
		$obj= new Usuario();
		$data = $obj->getUsuariosLimit();
		$cook = base64_decode($_COOKIE['login']);
		$cook= explode('+', $cook);
		
		$smarty->assign('user',$cook);//nombre usuaro logueado
		$smarty->assign('seccion','usuario');//nombre de la seccion en la que estamos actualmente
		$smarty->assign('datos',$data); //primeros 10 usuaros
		$smarty->display('users.html');
	}else{
		header('Location:login.php');
	}

?>