<?php 
require 'db/requires.php';
if(isset($_COOKIE['login']) ){
	$cook = base64_decode($_COOKIE['login']);
	$cook= explode('+', $cook);
	$smarty->assign('user',$cook);//nombre usuaro logueado
	$smarty->display('create-new.html');
}else{
	header('Location:login.php');
}
?>