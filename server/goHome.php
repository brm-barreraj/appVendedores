<?php 

	require 'db/requires.php';
	
	if(isset($_COOKIE['login']) ){
	$smarty->display('home.html');
	}else{
		header('Location:login.php');
	}
 ?>