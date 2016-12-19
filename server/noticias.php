<?php 
require 'db/requires.php';
$gen = new General();
if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login'])){
	$cook = base64_decode($_COOKIE['login']);
	$cook= explode('+', $cook);
	$categorias = $gen->getTotalDatos('VenCategoria',null,array('idPadre'=>0,'estado'=>'A'));
	$smarty->assign('categorias',$categorias);//lista de categorias
	$smarty->assign('user',$cook);//nombre usuaro logueado
	$smarty->display('create-new.html');
}else{
	header('Location:login.php');
}
?>