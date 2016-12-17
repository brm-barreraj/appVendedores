<?php 
require 'db/requires.php';
$gen = new General();
if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login']) ) {
	$cook = base64_decode($_COOKIE['login']);
	$cook= explode('+', $cook);
	$smarty->assign('user',$cook);//nombre usuaro logueado
	$smarty->display('create-category.html');
}else{
	header('Location:login.php');
}
?>