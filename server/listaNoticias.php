<?php 
require 'db/requires.php';
$gen = new General();
if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login'])){
	$cook = base64_decode($_COOKIE['login']);
	$cook= explode('+', $cook);
	$noticias = $gen->getTotalDatos('VenNoticia',null,array('estado'=>'A'));
	$smarty->assign('datos',$noticias);//lista de categorias
	$smarty->assign('user',$cook);//nombre usuaro logueado
	$smarty->display('list-new.html');
}else{
	header('Location:login.php');
}
?>