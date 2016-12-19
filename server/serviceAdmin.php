<?php 
require 'db/requires.php';
$error = -1;
$data="";
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
				//printVar($usuario);
				if ($usuario) {
					$data = $usuario;							
					$error = 1;
					/*
						valor de la cookie = $nombre+$apellido+email
					*/
					$string = base64_encode($data[0]->nombre.'+'.$data[0]->apellido.'+'.$data[0]->email);
					//var_dump($string);
					setcookie("login", $string, time()+(3600*24*7) );

				}else{
					$error = 2;
				}
			} else {
				$error = 3;
			}
			//echo "Salio";
		break;

		case 'logout':
			setcookie("login","",time()-1);
			header('Location:login.php');
		break;		

		/* buscador usuario--------- Falta */
		case 'buscadorUsuario':
			if (isset($_POST['nombre']) && $_POST['nombre'] != "" && 
				isset($_POST['imagen']) && $_POST['imagen'] != "") {
				$Categoria = new General();
				$Categoria->nombre = $_POST['nombre'];
				$Categoria->imagen = $_POST['imagen'];
				$Categoria->idPadre = (isset($_POST['idCategoria']) && $_POST['idCategoria'] > 0) ? $_POST['idCategoria'] : 0;
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

		/* buscador categoria--------- Falta */
		case 'buscadorCategoria':
			if (isset($_POST['nombre']) && $_POST['nombre'] != "" && 
				isset($_POST['imagen']) && $_POST['imagen'] != "") {
				$Categoria = new General();
				$Categoria->nombre = $_POST['nombre'];
				$Categoria->imagen = $_POST['imagen'];
				$Categoria->idPadre = (isset($_POST['idCategoria']) && $_POST['idCategoria'] > 0) ? $_POST['idCategoria'] : 0;
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

		/* buscador noticia--------- Falta */
		case 'buscadorNoticia':
			if (isset($_POST['nombre']) && $_POST['nombre'] != "" && 
				isset($_POST['imagen']) && $_POST['imagen'] != "") {
				$Categoria = new General();
				$Categoria->nombre = $_POST['nombre'];
				$Categoria->imagen = $_POST['imagen'];
				$Categoria->idPadre = (isset($_POST['idCategoria']) && $_POST['idCategoria'] > 0) ? $_POST['idCategoria'] : 0;
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

		/* Inserta Usuario */
		case 'setUsuario':
			if (isset($_POST['idCargo']) && $_POST['idCargo'] != "" && 
				isset($_POST['nombre']) && $_POST['nombre'] != "" && 
				isset($_POST['apellido']) && $_POST['apellido'] != "" && 
				isset($_POST['email']) && $_POST['email'] != "" && 
				isset($_POST['usuario']) && $_POST['usuario'] != "" && 
				isset($_POST['contrasena']) && $_POST['contrasena'] != "" && 
				isset($_POST['puntos']) && $_POST['puntos'] != "") {
				$Usuario = new General();
				$Usuario->idCargo = $_POST['idCargo'];
				$Usuario->nombre = $_POST['nombre'];
				$Usuario->apellido = $_POST['apellido'];
				$Usuario->email = $_POST['email'];
				$Usuario->usuario = $_POST['usuario'];
				$Usuario->contrasena = $_POST['contrasena'];
				$Usuario->puntos = $_POST['puntos'];
				$Usuario->estado='A';
				$Usuario->fechaMod = date("Y-m-d H:i:s");
				$idUsuario = $Usuario->setInstancia('VenUsuario');
				if ($idUsuario > 0) {
					$data = $idUsuario;
					$error = 1;
				} else {
					$error = 0;
				}
			}else{
				$error=3;
			}
		break;

		/* Lista Usuarios */
		case 'getUsuarios':
			if (isset($_POST['pagina']) && $_POST['pagina'] > 0) {
				$usr = new Usuario();
				$ini = $_POST['pagina'];
				$ini = ((int)$ini == 1)? ((int)$ini-1) :( ( (int)$ini  * (int)$usr->getLimit() )- (int)$usr->getLimit() );	
				$pagina = $usr->getUsuariosLimitRange($ini);
				if (count($pagina) > 0) {
					$data = $pagina;
					$error = 1;
				}else{
					$error = 2;
				}
			}else{
				$error = 3;
			}
		break;

		/* Actualiza campos de un Usuario */
		case 'updateUsuario':
			if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != "") {
				$idUsuario = $_POST['idUsuario'];
				$camposUpdate = array();
				if (isset($_POST['idCargo']) && $_POST['idCargo'] != "") {
					$camposUpdate['idCargo'] = $_POST['idCargo'];
				}
				if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
					$camposUpdate['nombre'] = $_POST['nombre'];
				}
				if (isset($_POST['apellido']) && $_POST['apellido'] != "") {
					$camposUpdate['apellido'] = $_POST['apellido'];
				}
				if (isset($_POST['email']) && $_POST['email'] != "") {
					$camposUpdate['email'] = $_POST['email'];
				}
				if (isset($_POST['usuario']) && $_POST['usuario'] != "") {
					$camposUpdate['usuario'] = $_POST['usuario'];
				}
				if (isset($_POST['contrasena']) && $_POST['contrasena'] != "") {
					$camposUpdate['contrasena'] = $_POST['contrasena'];
				}
				if (isset($_POST['puntos']) && $_POST['puntos'] != "") {
					$camposUpdate['puntos'] = $_POST['puntos'];
				}
				if (isset($_POST['estado']) && ($_POST['estado'] == "A" || $_POST['estado'] == "I")) {
					$camposUpdate['estado'] = $_POST['estado'];
				}
				if (count($camposUpdate) > 0) {
					$idMod = $General->setUpdateInstancia("VenUsuario",$camposUpdate,array("idUsuario"=>$idUsuario));
					if ($idMod > 0) {
						$data = $idMod;
						$error = 1;
					}else{
						$error = 0;
					}
				}else{
					$error = 3;
				}
			}else{
				$error = 3;
			}
		break;

		/* Elimina una Usuario */
		case 'deleteUsuario':
			if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != "") {
				$idUsuario = $_POST['idUsuario'];
				$idMod = $General->setUpdateInstancia("VenUsuario",array("estado" => "I"),array("idUsuario"=>$idUsuario));
				if ($idMod > 0) {
					$data = $idMod;
					$error = 1;
				}else{
					$error = 0;
				}
			}else{
				$error = 3;
			}
		break;

		/* Inserta categorías y subcategorías */
		case 'setCategoria':
			if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
				$Categoria = new General();
				$Categoria->nombre = $_POST['nombre'];
				$Categoria->imagen = $_POST['imagen'];
				$Categoria->idPadre = (isset($_POST['idCategoria']) && $_POST['idCategoria'] > 0) ? $_POST['idCategoria'] : 0;
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

		/* Actualiza campos de una categoria */
		case 'updateCategoria':
			if (isset($_POST['idCategoria']) && $_POST['idCategoria'] != "") {
				$idCategoria = $_POST['idCategoria'];
				$camposUpdate = array();
				if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
					$camposUpdate['nombre'] = $_POST['nombre'];
				}
				if (isset($_POST['idPadre']) && $_POST['idPadre'] != "") {
					$camposUpdate['idPadre'] = $_POST['idPadre'];
				}
				if (isset($_POST['imagen']) && $_POST['imagen'] != "") {
					$camposUpdate['imagen'] = $_POST['imagen'];
				}
				if (isset($_POST['estado']) && ($_POST['estado'] == "A" || $_POST['estado'] == "I")) {
					$camposUpdate['estado'] = $_POST['estado'];
				}
				if (count($camposUpdate) > 0) {
					$idMod = $General->setUpdateInstancia("VenCategoria",$camposUpdate,array("idCategoria"=>$idCategoria));
					if ($idMod > 0) {
						$data = $idMod;
						$error = 1;
					}else{
						$error = 0;
					}
				}else{
					$error = 3;
				}
			}else{
				$error = 3;
			}
		break;

		/* Elimina una categoria */
		case 'deleteCategoria':
			if (isset($_POST['idCategoria']) && $_POST['idCategoria'] != "") {
				$idCategoria = $_POST['idCategoria'];
				$idMod = $General->setUpdateInstancia("VenCategoria",array("estado" => "I"),array("idCategoria"=>$idCategoria));
				if ($idMod > 0) {
					$data = $idMod;
					$error = 1;
				}else{
					$error = 0;
				}
			}else{
				$error = 3;
			}
		break;

		/* Inserta una noticia */
		case 'setNoticia':
			if (isset($_POST['idSubCategoria']) && (int) $_POST['idSubCategoria'] > 0 &&
				isset($_POST['idUsuarioAdmin']) && (int) $_POST['idUsuarioAdmin'] > 0 &&
				isset($_POST['titulo']) && $_POST['titulo'] != "" &&
				isset($_POST['subtitulo']) && $_POST['subtitulo'] != "" &&
				isset($_POST['contenido']) &&
				isset($_FILES['image']) && $_FILES['image'] != "" &&
				isset($_POST['tipoTemplate']) && (int) $_POST['tipoTemplate'] > 0) {
				$idSubCategoria = $_POST['idSubCategoria'];
				$idUsuarioAdmin = $_POST['idUsuarioAdmin'];
				$nNoticias = $General->countRows("VenNoticia");
				$imagen = $General->moveFile($_FILES['image'],"img/noticias/",$nNoticias);
				if ($imagen) {
					$Noticia = new General();
					$Noticia->idCategoria=$idSubCategoria;
					$Noticia->idUsuarioAdmin=$idUsuarioAdmin;
					$Noticia->titulo=utf8_encode($_POST['titulo']);
					$Noticia->subtitulo=utf8_encode($_POST['subtitulo']);
					$Noticia->contenido=utf8_encode($_POST['contenido']);
					$Noticia->imagen=$imagen;
					$Noticia->tipoTemplate=$_POST['tipoTemplate'];
					$Noticia->estado='A';
					$Noticia->fechaMod = date("Y-m-d H:i:s");
					$idNoticia = $Noticia->setInstancia('VenNoticia');
					$Notification = new Notification;
					$Notification->sendMessageAndroid($_POST['titulo']);
					//sendMessageAndroid($_POST['titulo']);
					if ($idNoticia > 0) {
						$data = $idNoticia;
						$error = 1;
					}else{
						$error = 0;
					}
				}else{
					$error = 4;
				}
			} else {
				$error = 3;
			}
		break;

		/* Lista todas las noticias */
		case 'getNoticias':
			if (isset($_POST['idSubcategoria']) && $_POST['idSubcategoria'] > 0) {
				$idSubcategoria = $_POST['idSubcategoria'];
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

		/* Actualiza campos de una noticia */
		case 'updateNoticia':
			if (isset($_POST['idNoticia']) && $_POST['idNoticia'] != "") {
				$idNoticia = $_POST['idNoticia'];
				$camposUpdate = array();
				if (isset($_POST['idCategoria']) && $_POST['idCategoria'] != "") {
					$camposUpdate['idCategoria'] = $_POST['idCategoria'];
				}
				if (isset($_POST['idUsuarioAdmin']) && $_POST['idUsuarioAdmin'] != "") {
					$camposUpdate['idUsuarioAdmin'] = $_POST['idUsuarioAdmin'];
				}
				if (isset($_POST['titulo']) && $_POST['titulo'] != "") {
					$camposUpdate['titulo'] = $_POST['titulo'];
				}
				if (isset($_POST['subtitulo']) && $_POST['subtitulo'] != "") {
					$camposUpdate['subtitulo'] = $_POST['subtitulo'];
				}
				if (isset($_POST['imagen']) && $_POST['imagen'] != "") {
					$camposUpdate['imagen'] = $_POST['imagen'];
				}
				if (isset($_POST['tipoTemplate']) && $_POST['tipoTemplate'] != "") {
					$camposUpdate['tipoTemplate'] = $_POST['tipoTemplate'];
				}
				if (isset($_POST['estado']) && $_POST['estado'] != "") {
					$camposUpdate['estado'] = $_POST['estado'];
				}
				if (count($camposUpdate) > 0) {
					$idMod = $General->setUpdateInstancia("VenNoticia",$camposUpdate,array("idNoticia"=>$idNoticia));
					if ($idMod > 0) {
						$data = $idMod;
						$error = 1;
					}else{
						$error = 0;
					}
				}else{
					$error = 3;
				}
			}else{
				$error = 3;
			}
		break;

		/* Elimina una noticia */
		case 'deleteNoticia':
			if (isset($_POST['idNoticia']) && $_POST['idNoticia'] != "") {
				$idNoticia = $_POST['idNoticia'];
				$idMod = $General->setUpdateInstancia("VenNoticia",array("estado" => "I"),array("idNoticia"=>$idNoticia));
				if ($idMod > 0) {
					$data = $idMod;
					$error = 1;
				}else{
					$error = 0;
				}
			}else{
				$error = 3;
			}
		break;
			
	}//end switch
}//end if 


/* 

	// Errores

	-1 = No existe la acción
	0 = No se realizó la acción correctamente
	1 = La acción se realizó correctamente
	2 = La acción se realizó correctamente pero no hay datos
	3 = Campos incorrectos 
	4 = Imagen no subio correctamente

*/

$result['data'] = $data;
$result['error'] = $error;
echo json_encode($result);
?>