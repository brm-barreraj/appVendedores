<?php 
	
	//php_value display_errors 1

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	require 'db/requires.php';
	
	if(isset($_COOKIE['login']) ){

		if (isset($_POST['control'])) {
			
			switch ($_POST['control']) {
				case 'paginar':
					$usr = new Usuario();
					$ini = $_POST['pagina'];
					$ini = ((int)$ini == 1)? ((int)$ini-1) :( ( (int)$ini  * (int)$usr->getLimit() )- (int)$usr->getLimit() );	
					//printVar($ini);			
					
					$pagina = $usr->getUsuariosLimitRange($ini);
					echo json_encode($pagina);
					exit();
					break;
				
				default:
					# code...
					break;
			}

		}else{


		$obj= new Usuario();
		$count = $obj->getCountUsuarios(); 
		$data = $obj->getUsuariosLimit();

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
		//$smarty->assing('nom',$no);//nombre usuaro logueado
		//$smarty->assing('ape',$ap);//apelido de usario logueado
		//$smarty->assing('ema',$em); //email del usuario logueado
		$smarty->assign('datos',$data); //primeros 10 usuaros
		$smarty->assign('count',$count);//numero total de usaurios
		$smarty->assign('grupos',$arr);//arreglo para pintar los numeros del paginador
		//$smarty->display('usuarios.html');
		$smarty->display('users.html');
		}
	}else{
		header('Location:login.php');
	}

?>