<?php 
	require 'db/requires.php';
	$gen = new General();
	$not = new Noticia();
	if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login']) ) {
		if (isset($_GET['idNoticia']) && (int) $_GET['idNoticia'] > 0) {
			$accion = "Editar";
			$noticia=$not->getNoticiaById($_GET['idNoticia']);
			//printVar($noticia);
			//$usuario = $gen->getTotalDatos('VenNoticia',null,array('idUsuario'=> $_GET['idUsuario'],'estado'=>'A'));
			
			$smarty->assign('noticia',$noticia);
		}else{
			header('Location:noticias.php');
			exit();
		}
		$cook = base64_decode($_COOKIE['login']);
		$cook = explode('+', $cook);
		$smarty->assign('user',$cook);
		
		//$cargos = $gen->getTotalDatos('VenCargo',null,array('estado'=>'A'));
		//$smarty->assign('cargos',$cargos);
		$smarty->assign('seccion','noticia');//nombre de la seccion en la que estamos actualmente
		$smarty->assign('titleForm',$accion);
		$smarty->display('news-form.html');
	}else{
		header('Location:login.php');
	}
?>