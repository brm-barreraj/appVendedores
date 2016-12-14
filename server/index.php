<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require("db/requires.php");
include("notificacion.php");
$General = new General();
$error=-1;
$data="";

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
if ($request==null) {
	foreach ($_POST as $key => $value) {
		$request->$key = $value;
	}
}

switch ($request->accion) {

	/* Inserta categorías y subcategorías */
	case 'setCategoria':
		if (isset($request->nombre) && $request->nombre != "" && 
			isset($request->imagen) && $request->imagen != "") {
			$Categoria = new General();
			$Categoria->nombre = $request->nombre;
			$Categoria->imagen = $request->imagen;
			$Categoria->idPadre = (isset($request->idCategoria) && $request->idCategoria > 0) ? $request->idCategoria : 0;
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

	/* Lista subcategorías */
	case 'getSubcategorias':
		if (isset($request->idCategoria) && $request->idCategoria > 0) {
			$idCategoria = $request->idCategoria;
			$subcategorias = $General->getTotalDatos('VenCategoria',null,array('idPadre'=>$idCategoria,'estado'=>'A'));
			if (count($subcategorias) > 0) {
				$data = $subcategorias;
				$error = 1;
			}else{
				$error = 2;
			}
		} else {
			$error = 3;
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
	
	/* Login */
	case 'login':
		if (isset($request->usuario) && $request->usuario != "" &&
			isset($request->contrasena) && $request->contrasena != "") {
			$usuario=$request->usuario;
			$contrasena=$request->contrasena;
			$user = $General->getTotalDatos('VenUsuario',null,array('usuario'=>$usuario,'contrasena'=>$contrasena,'estado'=>'A'));
			if (!$user) {
			  	$error = 2;
			}else{
				$cargo = $General->getTotalDatos('VenCargo',null,array('idCargo'=>$user[0]->idCargo,'estado'=>'A'));
			  	$user[0]->cargo = $cargo[0]->nombre;
			  	$data = $user[0];
				$error = 1;
			}
		} else {
			$error = 3;
		}
	break;
}

/* 

	// Errores

	-1 = No se existe la acción
	0 = No se realizó la acción correctamente
	1 = La acción se realizó correctamente
	2 = La acción se realizó correctamente pero no hay datos
	3 = Campos incorrectos 

*/
$result['data'] = $data;
$result['error'] = $error;
echo json_encode($result);