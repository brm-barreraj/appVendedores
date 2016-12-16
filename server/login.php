<?php 
	require 'db/requires.php';
	if (isset($_COOKIE['login'])) {
		header('Location:index.php');
	}else{
	$smarty->display('login.html');
		
	}
?>