<?php 
require 'db/requires.php';
	$gen = new General();
	if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login']) ) {
		$obj= new Categoria();
		$count = $obj->getCountCategorias(); 
		$data = $obj->getCategoriasLimit();

		$grupos = ceil((int)$count/$obj->getLimit());
		$arr = array();

		for ($i=1; $i <=$grupos ; $i++) { 
			array_push($arr, $i);
		}
		$cook = base64_decode($_COOKIE['login']);
		$cook= explode('+', $cook);
		//printVar($data);
		$smarty->assign('user',$cook);//nombre usuaro logueado
		$smarty->assign('seccion','usuario');//nombre de la seccion en la que estamos actualmente
		$smarty->assign('datos',$data); //primeros 10 usuaros
		$smarty->assign('count',$count);//numero total de usaurios
		$smarty->assign('grupos',$arr);//arreglo para pintar los numeros del paginador
		$smarty->display('category.html');
	}else{
		header('Location:login.php');
	}
?>