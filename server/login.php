<?php 
	require 'db/requires.php';
	$gen = new General();
	if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login']) ) {
		header('Location:index.php');
	}else{
	$smarty->display('login.html');
		
	}
?>