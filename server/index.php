<?php 
require 'db/requires.php';
$gen = new General();
if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login'])){
	$general = new General();
	$countUsuarios=$general->countRows('VenUsuario',"estado='A'");
	$countNoticias=$general->countRows('VenNoticia',"estado='A'");
	$countCategorias=$general->countRows('VenCategoria',"estado='A' and idPadre > 0");
	//printVar($countUsuarios,'los count');
	$cook = base64_decode($_COOKIE['login']);
	$cook= explode('+', $cook);
	$smarty->assign('seccion','home');//nombre de la seccion en la que estamos actualmente
	$smarty->assign('countUsuarios',$countUsuarios);//nombre usuaro logueado
	$smarty->assign('countNoticias',$countNoticias);//nombre usuaro logueado
	$smarty->assign('countCategorias',$countCategorias);//nombre usuaro logueado
	$smarty->assign('user',$cook);//nombre usuaro logueado
	$smarty->display('home.html');
}else{
	header('Location:login.php');
}
?>