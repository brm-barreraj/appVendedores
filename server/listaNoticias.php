<?php 
require 'db/requires.php';
$gen = new General();
if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login'])){
	$cook = base64_decode($_COOKIE['login']);
	$cook= explode('+', $cook);
	$noticias = $gen->getTotalDatos('VenNoticia',null,array('estado'=>'A'));
	// Agregar nombre de categoria a la noticia
	foreach ($noticias as $noticia) {
		$categoria = $gen->getTotalDatos('VenCategoria',array('nombre'),array('idCategoria'=>$noticia->idCategoria));
		$noticia->nombreCategoria = $categoria[0]->nombre;
	}
	$smarty->assign('datos',$noticias);//lista de categorias
	$smarty->assign('seccion','noticia');//nombre de la seccion en la que estamos actualmente
	$smarty->assign('user',$cook);//nombre usuaro logueado
	$smarty->display('list-new.html');
}else{
	header('Location:login.php');
}
?>