<?php 
	
	//php_value display_errors 1

	require 'db/requires.php';
	$gen = new General();
	if(isset($_COOKIE['login']) && $gen->validaCookie($_COOKIE['login']) ) {

		if (isset($_POST['accion'])) {
			
			switch ($_POST['accion']) {
					case 'buscadorUsuario':
					$usr = new Usuario();
					$termino = $_POST['termino'];
					$result = $usr->serchTermUser($termino);
					if (count($result) > 0) {
					$data = $result;
					$error = 1;
				}else{
					$error = 2;
				}
				$result['data']=$result;
				$result['error']=$error;
				echo json_encode($result);
					exit();
					break;

			}

		}else{


		$obj= new Usuario();
		$count = $obj->getCountUsuarios(); 
		$data = $obj->getUsuariosLimit();
		//$data = $obj->getAllUsuarios();

		$grupos = ceil((int)$count/$obj->getLimit());
		$arr = array();

		for ($i=1; $i <=$grupos ; $i++) { 
			array_push($arr, $i);
		}
		//printVar($arr);
		$cook = base64_decode($_COOKIE['login']);
		$cook= explode('+', $cook);
		$no=$cook[0];
	    $ap=$cook[1];
		$em=$cook[2];

		//printVar($cook);
		
		$smarty->assign('user',$cook);//nombre usuaro logueado
		$smarty->assign('seccion','usuario');//nombre de la seccion en la que estamos actualmente
		$smarty->assign('datos',$data); //primeros 10 usuaros
		$smarty->assign('count',$count);//numero total de usaurios
		$smarty->assign('grupos',$arr);//arreglo para pintar los numeros del paginador
		//$smarty->display('usuarios.html');
		$smarty->display('users.html');
		//$smarty->display('usuarios.html');
		}
	}else{
		header('Location:login.php');
	}

?>