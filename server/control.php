<?php 
require 'db/requires.php';
$error = -1;
$data="";
$General = new General();



$idSubCategoria="1";
$idUsuarioAdmin="1";
$titulo="titulo";
$subtitulo="subtitulo";
$contenido="contenido";
$imagen="6.jpg";
$tipoTemplate="1";

$idSubCategoria = $idSubCategoria;
$idUsuarioAdmin = $idUsuarioAdmin;
$Noticia = new General();
$Noticia->idCategoria=$idSubCategoria;
$Noticia->idUsuarioAdmin=$idUsuarioAdmin;
$Noticia->titulo=utf8_encode($titulo);
$Noticia->subtitulo=utf8_encode($subtitulo);
$Noticia->contenido=utf8_encode($contenido);
$Noticia->imagen=$imagen;
$Noticia->estado='A';
$Noticia->tipoTemplate=$tipoTemplate;
$Noticia->fechaMod = date("Y-m-d H:i:s");
$idNoticia = $Noticia->setInstancia('VenNoticia');
//sendMessageAndroid($request->titulo);
printVar($idNoticia);
if ($idNoticia > 0) {
	$data = $idNoticia;
	$error = 1;
}else{
	$error = 0;
}
die;


	
	
	
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
			
			//control de paginador para usuarios
			case 'nextUsuarios':
				
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