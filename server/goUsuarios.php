<?php 
	
	//php_value display_errors 1

	ini_set('display_errors',1);
	error_reporting(E_ALL);

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
		$smarty->assign('datos',$data); 
		$smarty->assign('count',$count);
		$smarty->assign('grupos',$arr);
		//$smarty->display('usuarios.html');
		$smarty->display('users.html');
		}
	}else{
		header('Location:login.php');
	}

?>