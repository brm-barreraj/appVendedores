<?php 
require 'db/requires.php';
$error = -1;
$data="";
$General = new General();





	
	
	
	if (isset($_POST['accion']) && !empty($_POST['accion']) ) {
		
		$accion = $_POST['accion'];
		$General = new General();
		
		switch ($accion) {
			
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

			/* Inserta categorías y subcategorías */
			case 'setCategoria':
				if (isset($request->nombre) && $request->nombre != "" && 
					isset($request->imagen) && $request->imagen != "") {
					$Categoria = new General();
					$Categoria->nombre = $request->nombre;
					$Categoria->imagen = $request->imagen;
					$Categoria->idPadre = (isset($request->idCategoria) && $request->idCategoria > 0) ? $request->idCategoria : 0;
					$Categoria->estado='A';
					$Categoria->fechaMod = date("Y-m-d H:i:s");
					$idCategoria = $Categoria->setInstancia('VenCategoria');
					if ($idCategoria > 0) {
						$data = $idCategoria;
						$error = 1;
					} else {
						$error = 0;
					}
				}else{
					$error=3;
				}
			break;

			/* Lista categorías */
			case 'getCategorias':
				$categorias = $General->getTotalDatos('VenCategoria',null,array('idPadre'=>0,'estado'=>'A'));
				if (count($categorias) > 0) {
					$data = $categorias;
					$error = 1;
				}else{
					$error = 2;
				}
			break;

			/* Inserta una noticia */
			case 'setNoticia':
				if (isset($request->idSubCategoria) && $request->idSubCategoria > 0 &&
					isset($request->idUsuarioAdmin) && $request->idUsuarioAdmin > 0 &&
					isset($request->titulo) && $request->titulo != "" &&
					isset($request->subtitulo) && $request->subtitulo != "" &&
					isset($request->contenido) && $request->contenido != "" &&
					isset($request->imagen) && $request->imagen != "" &&
					isset($request->tipoTemplate) && $request->tipoTemplate != "") {
					$idSubCategoria = $request->idSubCategoria;
					$idUsuarioAdmin = $request->idUsuarioAdmin;
					$Noticia = new General();
					$Noticia->idCategoria=$idSubCategoria;
					$Noticia->idUsuarioAdmin=$idUsuarioAdmin;
					$Noticia->titulo=utf8_encode($request->titulo);
					$Noticia->subtitulo=utf8_encode($request->subtitulo);
					$Noticia->contenido=utf8_encode($request->contenido);
					$Noticia->imagen=$request->imagen;
					$Noticia->tipoTemplate=$request->tipoTemplate;
					$Noticia->estado='A';
					$Noticia->fechaMod = date("Y-m-d H:i:s");
					$idNoticia = $Noticia->setInstancia('VenNoticia');
					sendMessageAndroid($request->titulo);
					if ($idNoticia > 0) {
						$data = $idNoticia;
						$error = 1;
					}else{
						$error = 0;
					}
				} else {
					$error = 3;
				}
			break;

			/* Lista todas las noticias */
			case 'getNoticias':
				if (isset($request->idSubcategoria) && $request->idSubcategoria > 0) {
					$idSubcategoria = $request->idSubcategoria;
					$noticia = $General->getTotalDatos('VenNoticia',array('idNoticia','imagen','titulo'),array('idCategoria'=>$idSubcategoria,'estado'=>'A'));
					if (count($noticia) > 0) {
						$data = $noticia;
						$error = 1;
					}else{
						$error = 2;
					}
				} else {
					$error = 3;
				}
			break;

				/* Lista detalle de una noticia */
			case 'getNoticia':
				if (isset($request->idNoticia) && $request->idNoticia > 0) {
					$idNoticia = $request->idNoticia;
					$noticia = $General->getTotalDatos('VenNoticia',null,array('idNoticia'=>$idNoticia,'estado'=>'A'));

					if (count($noticia) > 0) {
						$secciones = $General->getTotalDatos('VenSeccionNoticia',null,array('idNoticia'=>$idNoticia,'estado'=>'A'));
						$data = $noticia[0];
						if ($secciones) {
							$data->secciones = $secciones;
						}
						
						$error = 1;
					}else{
						$error = 2;
					}
				} else {
					$error = 3;
				}
			break;

			// Trae todos los 
			case 'getPaginadorUsuario':
					$usr = new Usuario();
					$ini = $_POST['pagina'];
					$ini = ((int)$ini == 1)? ((int)$ini-1) :( ( (int)$ini  * (int)$usr->getLimit() )- (int)$usr->getLimit() );	
					//printVar($ini);
					$pagina = $usr->getUsuariosLimitRange($ini);
					echo json_encode($pagina);
					exit();
			break;
				
		}//end switch
	}//end if 

	$result['data'] = $data;
	$result['error'] = $error;
	echo json_encode($result);
?>