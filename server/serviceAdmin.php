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

		// Se desloguea y mata cookie
		case 'logout':
			setcookie("login","",time()-1);
			header('Location:login.php');
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

		/* Inserta Usuarios Excel */
		case 'setUsuariosExcel':
			if (isset($_FILES['excel']) && $_FILES['excel'] != "") {

				$rutaExcel = "xls/".$General->moveFile($_FILES['excel'],"xls/","usuarios");

				require_once 'libs/phpexcel/Read/reader.php';

				$data = new Spreadsheet_Excel_Reader('.xls');
				$data -> setOutputEncoding('CP1251');
				$data -> read($rutaExcel);
				$nrows = $data -> sheets[0]['numRows'];
				$ncols = $data -> sheets[0]['numCols'];
				$nCorrectos = 0;
				$nIncorrectos = 0;
				for ($i = 2; $i <= $nrows; $i++) {
					$nombreCargo = ltrim(trim(rtrim(strtolower($data -> sheets[0]['cells'][$i][4]))));
					$cargo = $General->getTotalDatos('VenCargo',array("idCargo"),array('nombre'=>$nombreCargo));
					if ($cargo && is_array($cargo) && count($cargo) > 0) {
						$idCargo = $cargo[0]->idCargo;
					}else{
						$Cargo = new General();
						$Cargo->nombre = $nombreCargo;
						$Cargo->estado='A';
						$Cargo->fechaMod = date("Y-m-d H:i:s");
						$idCargo = $Cargo->setInstancia('VenCargo');
					}
					$camposUsuario = array();
					$camposUsuario['idCargo'] = $idCargo;
					$camposUsuario['nombre'] = ltrim(trim(rtrim(strtolower($data -> sheets[0]['cells'][$i][1]))));
					$camposUsuario['apellido'] = ltrim(trim(rtrim(strtolower($data -> sheets[0]['cells'][$i][2]))));
					$camposUsuario['email'] = ltrim(trim(rtrim(strtolower($data -> sheets[0]['cells'][$i][3]))));
					$camposUsuario['usuario'] = ltrim(trim(rtrim(strtolower($data -> sheets[0]['cells'][$i][5]))));
					$camposUsuario['contrasena'] = ltrim(trim(rtrim(strtolower($data -> sheets[0]['cells'][$i][6]))));
					$camposUsuario['puntos'] = ltrim(trim(rtrim(strtolower($data -> sheets[0]['cells'][$i][7]))));
					$campoWhere = array("email" => $camposUsuario['email']);
					$resUsuario = $General->setUpdateInstancia('VenUsuario',$camposUsuario,$campoWhere);
					if ($resUsuario > 0) {
						$nCorrectos++;
					}else{
						$nIncorrectos++;
					}
				}
				$data = array("nCorrectos"=>$nCorrectos,"nIncorrectos"=>$nIncorrectos);
				$error = 1;
			}else{
				$error=3;
			}
		break;

		/* Lista usuarios */
		case 'getUsuarios':
			$categorias = $General->getTotalDatos('VenUsuarios',null,array('estado'=>'A'));
			if (count($categorias) > 0) {
				$data = $categorias;
				$error = 1;
			}else{
				$error = 2;
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
				$Categoria->idPadre = (isset($_POST['idPadre']) && $_POST['idPadre'] > 0) ? $_POST['idPadre'] : 0;
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

		/* Lista subcategorías */
		case 'getSubcategorias':
			if (isset($_POST['idCategoria']) && (int) $_POST['idCategoria'] > 0) {
				$idCategoria = $_POST['idCategoria'];
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
				// Crop Imagen
				$imagenFinArr = explode(".",$imagen);
				$rutaImagen2 = $imagenFinArr[0]."-crop.".$imagenFinArr[1];
				$General->cropImage("img/noticias/".$imagen, "img/noticias/".$rutaImagen2,80,80);
				// Fin Crop Imagen
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
						// Set SeccionNoticia
						foreach ($_FILES as $key => $value) {
							if ($key != "image") {
								$keySeccion = split("image", $key);
								$idFoto = $keySeccion[1];
								$keyContent = 'contenido'.$keySeccion[1];
								$SeccionNoticia = new General();
								$imagenTemp = $General->moveFile($_FILES[$key],"img/noticias/",$idFoto.$nNoticias);
								$SeccionNoticia->idNoticia=$idNoticia;
								$SeccionNoticia->imagen=$imagenTemp;
								$SeccionNoticia->contenido=utf8_encode($_POST[$keyContent]);
								$SeccionNoticia->estado='A';
								$SeccionNoticia->fechaMod = date("Y-m-d H:i:s");
								$idSeccionNoticia = $SeccionNoticia->setInstancia('VenSeccionNoticia');
							}
							sleep(1);
						}
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

		/* Inserta una seccion de una noticia */
		case 'setSeccionNoticia':
			if (isset($_FILES['image']) && $_FILES['image'] != "" &&
				isset($_POST['contenido']) && $_POST['contenido'] != "" &&
				isset($_POST['idNoticia']) && $_POST['idNoticia'] > 0) {
				$idNoticia = $_POST['idNoticia'];
				$nSeccionesNoticias = $General->countRows("VenSeccionNoticia");
				$keyName = $idNoticia.'-'.$nSeccionesNoticias;
				$imagen = $General->moveFile($_FILES['image'],"img/noticias/",$keyName);
				if ($imagen) {
					$SeccionNoticia = new General();
					$SeccionNoticia->idNoticia=$idNoticia;
					$SeccionNoticia->imagen=$imagen;
					$SeccionNoticia->contenido=utf8_encode($_POST['contenido']);
					$SeccionNoticia->estado='A';
					$SeccionNoticia->fechaMod = date("Y-m-d H:i:s");
					$idSeccionNoticia = $SeccionNoticia->setInstancia('VenSeccionNoticia');
					if ($idSeccionNoticia > 0) {
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
				if (isset($_POST['contenido']) && $_POST['contenido'] != "") {
					$camposUpdate['contenido'] = $_POST['contenido'];
				}
				if (isset($_FILES['image']) && $_FILES['image'] != "") {
					$nNoticias = $General->countRows("VenNoticia");
					$imagen = $General->moveFile($_FILES['image'],"img/noticias/",'up-'.$nNoticias);
					// Crop Imagen
					$imagenFinArr = explode(".",$imagen);
					$rutaImagen2 = $imagenFinArr[0]."-crop.".$imagenFinArr[1];
					$General->cropImage("img/noticias/".$imagen, "img/noticias/".$rutaImagen2,80,80);
					// Fin Crop Imagen
					$camposUpdate['imagen'] = $imagen;
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

						// Set SeccionNoticia

						foreach ($_FILES as $key => $value) {
							if ($key != "image") {
								$keySeccion = split("image", $key);
								$idTupla = $keySeccion[1];
								$keyContenido = 'contenido'.$idTupla;
								if (isset($_POST[$keyContenido]) && $_POST[$keyContenido] != "") {
									$camposUpdate['contenido'] = $_POST[$keyContenido];
								}
								$keyTitulo = 'titulo'.$idTupla;
								if (isset($_POST[$keyTitulo]) && $_POST[$keyTitulo] != "") {
									$camposUpdate['titulo'] = $_POST[$keyTitulo];
								}
								$keyImage = 'image'.$idTupla;
								if (isset($_FILES[$keyImage]) && count($_FILES[$keyImage]) > 0) {
									$nSeccionesNoticias = $General->countRows("VenSeccionNoticia");
									$imagen = $General->moveFile($_FILES[$keyImage],"img/noticias/",'up-'.$nSeccionesNoticias);
									$camposUpdate['imagen'] = $imagen;
								}
								$idMod = $General->setUpdateInstancia("VenSeccionNoticia",$camposUpdate,array("idSeccionNoticia"=>$idTupla));
							}
							sleep(1);
						}
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

		//oculta seccion de noticia
		case 'ocultaSeccionNoticia':
			if (isset($_POST['idSeccionNoticia']) && $_POST['idSeccionNoticia'] != "") {
				$idSeccionNoticia = $_POST['idSeccionNoticia'];
				$idMod = $General->setUpdateInstancia("VenSeccionNoticia",array("estado" => "I"),array("idSeccionNoticia"=>$idSeccionNoticia));
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