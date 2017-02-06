<?php 
require 'db/requires.php';
$error = -1;
$data="";
ini_set('max_file_uploads', 5000);
if (isset($_POST['accion']) && !empty($_POST['accion']) ) {
	
	$accion = $_POST['accion'];
	$General = new General();
	
	switch ($accion) {
		
		/* Usuarios */

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
						$camposUsuario['nombre'] = ltrim(trim(rtrim(utf8_encode($data -> sheets[0]['cells'][$i][1]))));
						$camposUsuario['apellido'] = ltrim(trim(rtrim(utf8_encode($data -> sheets[0]['cells'][$i][2]))));
						$camposUsuario['email'] = ltrim(trim(rtrim(utf8_encode($data -> sheets[0]['cells'][$i][3]))));
						$camposUsuario['usuario'] = ltrim(trim(rtrim(utf8_encode($data -> sheets[0]['cells'][$i][5]))));
						$camposUsuario['contrasena'] = ltrim(trim(rtrim(utf8_encode($data -> sheets[0]['cells'][$i][6]))));
						$camposUsuario['puntos'] = ltrim(trim(rtrim(utf8_encode($data -> sheets[0]['cells'][$i][7]))));
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
		
		/* Fin  Usuarios */

		/*Categoría*/

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

		/* Fin Categoría*/

		/* Noticia */

			/* Inserta una noticia */
			case 'setNoticia':
				if (isset($_POST['idSubCategoria']) && (int) $_POST['idSubCategoria'] > 0 &&
					isset($_POST['idUsuarioAdmin']) && (int) $_POST['idUsuarioAdmin'] > 0 &&
					isset($_POST['titulo']) && $_POST['titulo'] != "" &&
					isset($_POST['subtitulo']) && $_POST['subtitulo'] != "" &&
					isset($_POST['fechaDesde']) && $_POST['fechaDesde'] != "" &&
					isset($_POST['fechaHasta']) && $_POST['fechaHasta'] != "" &&
					isset($_POST['contenido']) && 
					isset($_FILES['image']) && isset($_FILES['image']['tmp_name']) && trim($_FILES['image']['tmp_name']) != "" &&
					isset($_POST['tipoTemplate']) && (int) $_POST['tipoTemplate'] > 0) {
					$idSubCategoria = $_POST['idSubCategoria'];
					$idUsuarioAdmin = $_POST['idUsuarioAdmin'];
					$nNoticias = $General->countRows("VenNoticia");
					if (isset($_FILES['video']) && isset($_FILES['video']['tmp_name']) && trim($_FILES['video']['tmp_name']) != "") {
						$video = $General->moveFile($_FILES['video'],"video/noticias/",$nNoticias);
					}else{
						$video = "";
					}
					if (isset($_FILES['pdf']) && isset($_FILES['pdf']['tmp_name']) && trim($_FILES['pdf']['tmp_name']) != "") {
						$pdf = $General->moveFile($_FILES['pdf'],"pdf/noticias/",$nNoticias);
					}else{
						$pdf = "";
					}
					if (isset($_POST['idProducto']) && (int) $_POST['idProducto'] > 0) {
						$idProducto = $_POST['idProducto'];
					}else{
						$idProducto = null;
					}
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
						$Noticia->idProducto=$idProducto;
						$Noticia->titulo=$_POST['titulo'];
						$Noticia->subtitulo=$_POST['subtitulo'];
						$Noticia->contenido=$_POST['contenido'];
						$Noticia->imagen=$imagen;
						$Noticia->video=$video;
						$Noticia->pdf=$pdf;
						$Noticia->tipoTemplate=$_POST['tipoTemplate'];
						$Noticia->fechaDesde=$_POST['fechaDesde'];
						$Noticia->fechaHasta=$_POST['fechaHasta'];
						$Noticia->estado='A';
						$Noticia->fechaMod = date("Y-m-d H:i:s");
						$idNoticia = $Noticia->setInstancia('VenNoticia');
						if ($idNoticia > 0) {
							$Notification = new Notification;
							$Notification->sendMessageAndroid($idNoticia, $_POST['titulo']);
							// Inserta Secciones a la noticia
							foreach ($_FILES as $key => $value) {
								if ($key != "image" && $key != "pdf" && $key != "video") {
									$keySeccion = explode("image", $key);
									$idFoto = $keySeccion[1];
									$keyContent = 'contenido'.$keySeccion[1];
									if ((isset($_FILES[$key]) && isset($_FILES[$key]['tmp_name']) && trim($_FILES[$key]['tmp_name']) != "") || (isset($_POST[$keyContent]) && trim($_POST[$keyContent]) != "")) {
										$SeccionNoticia = new General();
										$imagenTemp = $General->moveFile($_FILES[$key],"img/noticias/",$idFoto.$nNoticias);
										$SeccionNoticia->idNoticia=$idNoticia;
										$SeccionNoticia->imagen=$imagenTemp;
										$SeccionNoticia->contenido=$_POST[$keyContent];
										$SeccionNoticia->estado='A';
										$SeccionNoticia->fechaMod = date("Y-m-d H:i:s");
										$idSeccionNoticia = $SeccionNoticia->setInstancia('VenSeccionNoticia');
									}
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
						$SeccionNoticia->contenido=$_POST['contenido'];
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
					$nNoticias = $General->countRows("VenNoticia");
					if (isset($_POST['idSubCategoria']) && $_POST['idSubCategoria'] != "") {
						$camposUpdate['idCategoria'] = $_POST['idSubCategoria'];
					}
					if (isset($_POST['idUsuarioAdmin']) && $_POST['idUsuarioAdmin'] != "") {
						$camposUpdate['idUsuarioAdmin'] = $_POST['idUsuarioAdmin'];
					}
					if (isset($_POST['idProducto']) && $_POST['idProducto'] > 0) {
						$camposUpdate['idProducto'] = $_POST['idProducto'];
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
					if (isset($_FILES['image']) && isset($_FILES['image']['tmp_name']) && trim($_FILES['image']['tmp_name']) != "") {
						printVar("Entroo 2");
						$imagen = $General->moveFile($_FILES['image'],"img/noticias/",'up-'.$nNoticias);
						// Crop Imagen
						$imagenFinArr = explode(".",$imagen);
						$rutaImagen2 = $imagenFinArr[0]."-crop.".$imagenFinArr[1];
						$General->cropImage("img/noticias/".$imagen, "img/noticias/".$rutaImagen2,80,80);
						// Fin Crop Imagen
						$camposUpdate['imagen'] = $imagen;
					}
					if (isset($_FILES['video']) && isset($_FILES['video']['tmp_name']) && trim($_FILES['video']['tmp_name']) != "") {
						printVar("Entroo 1");
						$video = $General->moveFile($_FILES['video'],"video/noticias/",'up-'.$nNoticias);
						$camposUpdate['video'] = $video;
					}
					if (isset($_FILES['pdf']) && isset($_FILES['pdf']['tmp_name']) && trim($_FILES['pdf']['tmp_name']) != "") {
						$pdf = $General->moveFile($_FILES['pdf'],"pdf/noticias/",'up-'.$nNoticias);
						$camposUpdate['pdf'] = $pdf;
					}
					if (isset($_POST['tipoTemplate']) && $_POST['tipoTemplate'] != "") {
						$camposUpdate['tipoTemplate'] = $_POST['tipoTemplate'];
					}
					if (isset($_POST['fechaDesde']) && $_POST['fechaDesde'] != "") {
						$camposUpdate['fechaDesde'] = $_POST['fechaDesde'];
					}
					if (isset($_POST['fechaHasta']) && $_POST['fechaHasta'] != "") {
						$camposUpdate['fechaHasta'] = $_POST['fechaHasta'];
					}
					if (isset($_POST['estado']) && $_POST['estado'] != "") {
						$camposUpdate['estado'] = $_POST['estado'];
					}
					if (count($camposUpdate) > 0) {
						$idMod = $General->setUpdateInstancia("VenNoticia",$camposUpdate,array("idNoticia"=>$idNoticia));
						if ($idMod > 0) {
							// Actualiza y agrega nuevas secciones a una noticia
							foreach ($_FILES as $key => $value) {
								$camposUpdate = array();
								if ($key != "image" && $key != "pdf" && $key != "video") {
									$exp = explode("-",$key);
									if (count($exp) > 1) {
										// Insertar secciones nuevas
										$keySeccion = explode("image-e", $key);
										$idFoto = $keySeccion[1];
										$keyContent = 'contenido-e'.$keySeccion[1];
										$SeccionNoticia = new General();
										$imagenTemp = $General->moveFile($_FILES[$key],"img/noticias/",$idFoto.$nNoticias);
										$SeccionNoticia->idNoticia=$idNoticia;
										$SeccionNoticia->imagen=$imagenTemp;
										$SeccionNoticia->contenido=$_POST[$keyContent];
										$SeccionNoticia->estado='A';
										$SeccionNoticia->fechaMod = date("Y-m-d H:i:s");
										$idSeccionNoticia = $SeccionNoticia->setInstancia('VenSeccionNoticia');
									}else{
										// Editar secciones
										$keySeccion = explode("image", $key);
										$idTupla = $keySeccion[1];
										$keyContenido = 'contenido'.$idTupla;
										if (isset($_POST[$keyContenido])) {
											$camposUpdate['contenido'] = $_POST[$keyContenido];
										}
										$keyTitulo = 'titulo'.$idTupla;
										if (isset($_POST[$keyTitulo]) && $_POST[$keyTitulo] != "") {
											$camposUpdate['titulo'] = $_POST[$keyTitulo];
										}
										if (isset($_FILES[$key]) && isset($_FILES[$key]['tmp_name']) && trim($_FILES[$key]['tmp_name']) != "") {
											$nSeccionesNoticias = $General->countRows("VenSeccionNoticia");
											$imagen = $General->moveFile($_FILES[$key],"img/noticias/",'up-'.$nSeccionesNoticias);
											$camposUpdate['imagen'] = $imagen;
										}
										$idMod = $General->setUpdateInstancia("VenSeccionNoticia",$camposUpdate,array("idSeccionNoticia"=>$idTupla));
									}
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

		/* Fin Noticia */

		/* Producto */

			// inserta un producto
			case 'setProducto':
				if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
					$Producto = new General();
					$Producto->nombre = $_POST['nombre'];
					$Producto->estado='A';
					$Producto->fechaMod = date("Y-m-d H:i:s");
					$idProducto = $Producto->setInstancia('VenProducto');
					if ($idProducto > 0) {
						$data = $idProducto;
						$error = 1;
					} else {
						$error = 0;
					}
				}else{
					$error=3;
				}
			break;

			/* Lista productos */
			case 'getProductos':
				$productos = $General->getTotalDatos('VenProducto',null,array('estado'=>'A'));
				if (count($productos) > 0) {
					$data = $productos;
					$error = 1;
				}else{
					$error = 2;
				}
			break;

			/* Actualiza campos de un producto */
			case 'updateProducto':
				if (isset($_POST['idProducto']) && $_POST['idProducto'] != "") {
					$idProducto = $_POST['idProducto'];
					$camposUpdate = array();
					if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
						$camposUpdate['nombre'] = $_POST['nombre'];
					}
					if (isset($_POST['estado']) && ($_POST['estado'] == "A" || $_POST['estado'] == "I")) {
						$camposUpdate['estado'] = $_POST['estado'];
					}
					if (count($camposUpdate) > 0) {
						$idMod = $General->setUpdateInstancia("VenProducto",$camposUpdate,array("idProducto"=>$idProducto));
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
			case 'deleteProducto':
				if (isset($_POST['idProducto']) && $_POST['idProducto'] != "") {
					$idProducto = $_POST['idProducto'];
					$idMod = $General->setUpdateInstancia("VenProducto",array("estado" => "I"),array("idCategoria"=>$idCategoria));
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

		/* Fin Producto */
			
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