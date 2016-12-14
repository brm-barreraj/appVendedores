<?php 
	
	ini_set('display_errors', '1');
	//ini_set('display_errors', 1);
	error_reporting(E_ALL);
	require 'db/requires.php';
	
	if (isset($_POST['control']) && !empty($_POST['control']) ) {
		
		$control = $_POST['control'];
		$General = new General();
		switch ($control) {
			case 'doLogin':
				$user = $_POST['usuario'];	
				$pass = $_POST['pass'];	
				if (isset($user) && !empty($user) && !empty($pass)  ) {
					
					$usuario = $General->getTotalDatos('VenUsuarioAdmin',array('idUsuarioAdmin','nombre','apellido','email','usuario','contrasena'),array('email'=>$user,'contrasena',$pass));
					printVar($usuario);
					if (count($usuario) > 0) {
						$data = $usuario;
						$error = false;
					}else{
						$error = true;
					}
				} else {
					$error = true;
				}
				echo json_encode($error);
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
?>