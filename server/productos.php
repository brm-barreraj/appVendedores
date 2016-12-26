<?php 
require 'db/requires.php';
	$gen = new General();
	if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login']) ) {
		$data = $gen->getTotalDatos('VenProducto',null,array('estado'=>'A'));
		//$data= array();
		$cook = base64_decode($_COOKIE['login']);
		$cook= explode('+', $cook);
		//printVar($data);
		$smarty->assign('user',$cook);//nombre usuaro logueado
		$smarty->assign('seccion','producto');//nombre de la seccion en la que estamos actualmente
		$smarty->assign('datos',$data); //primeros 10 usuaros
		$smarty->display('producto.html');
	}else{
		header('Location:login.php');
	}
?>