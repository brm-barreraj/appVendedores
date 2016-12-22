<?php 
require 'db/requires.php';
$gen = new General();
if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login'])){
	if (isset($_GET['idNoticia']) && (int) $_GET['idNoticia'] > 0) {
		$accion = "Editar";
		$noticia = $gen->getTotalDatos('VenNoticia',null,array('idNoticia'=> $_GET['idNoticia'],'estado'=>'A'));
		$categoria = $gen->getTotalDatos('VenCategoria',null,array('idCategoria'=> $noticia[0]->idCategoria));
		$subcategorias = $gen->getTotalDatos('VenCategoria',null,array('idPadre'=> $categoria[0]->idPadre));
		$secciones = $gen->getTotalDatos('VenSeccionNoticia',null,array('idNoticia'=> $noticia[0]->idNoticia));
		$noticia[0]->idPadre = $categoria[0]->idPadre;
		$smarty->assign('noticia',$noticia[0]);
		$smarty->assign('subcategorias',$subcategorias);
		$smarty->assign('secciones',$secciones);
	}else{			
		$accion = "Crear";
	}

	$cook = base64_decode($_COOKIE['login']);
	$cook= explode('+', $cook);
	$categorias = $gen->getTotalDatos('VenCategoria',null,array('idPadre'=>0,'estado'=>'A'));
	$smarty->assign('categorias',$categorias);//lista de categorias
	$smarty->assign('seccion','noticia');//nombre de la seccion en la que estamos actualmente
	$smarty->assign('user',$cook);//nombre usuaro logueado
	$smarty->display('create-new.html');
}else{
	header('Location:login.php');
}
?>