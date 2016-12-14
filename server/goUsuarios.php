<?php 
	require 'db/requires.php';
	
	if(isset($_COOKIE['login']) ){
	$smarty->display('usuarios.html');
	}else{
		header('Location:login.php');
	}

?>