<?php 
	require 'db/requires.php';
	
	if(isset($_COOKIE['login']) ){
		$obj= new Usuario();
		$data = $obj->getUsuariosLimit();
		$smarty->assign('datos',$data);
		$smarty->display('usuarios.html');
	}else{
		header('Location:login.php');
	}

?>