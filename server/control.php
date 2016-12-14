<?php 
	
	ini_set('display_errors', '1');
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	require 'db/requires.php';
	
	$error = -1;
	$data="";
	
	if (isset($_POST['control']) && !empty($_POST['control']) ) {
		
		$control = $_POST['control'];
		$General = new General();
		
		switch ($control) {
			
			//doLogin, comprueba datos de inicio de sesión para el administrador, crea cookie 'login' 
			case 'doLogin':
				$user = $_POST['usuario'];	
				$pass = $_POST['pass'];	
				if (isset($user) && !empty($user) && !empty($pass)  ) {	
					$usuario = $General->getTotalDatos('VenUsuarioAdmin',null,array('email'=>$user,'contrasena'=>$pass) );
					if ($usuario) {
						$data = $usuario;
						
						$error = 1;
						/*
							valor de la cookie = $nombre+$apellido+email
						*/
						$string = base64_encode($data[0]->nombre.'+'.$data[0]->apellido.'+'.$data[0]->email);
						setcookie("login", $string, time()+(3600*24*7) );
					}else{
						$error = 2;
					}
				} else {
					$error = 3;
				}
			break;
			
			case '':
				
				break;

			case '':
				
				break;

			case '':
				
				break;

			case '':
				
				break;

			case '':
				
				break;

			case '':
				
				break;

			case '':
				
				break;

			case '':
				
				break;
		}//end switch
	}//end if 

	$result['data'] = $data;
	$result['error'] = $error;
	echo json_encode($result);
?>