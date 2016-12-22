<?php 
	/**
	* 
	*/
	class Noticia
	{
		
		function getAllNoticias(){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenNoticia');
			$obj->estado='A';
			$obj->find();
			$i = 0;
			$data='';
			while($obj->fetch()){
				$data[$i]['idNoticia']=$obj->idNoticia;
				$data[$i]['contenido']=utf8_encode($obj->contenido);
				$data[$i]['idCategoria']=$obj->idCategoria;
				
				$nombreCategoria=$this->getCategoriaById($obj->idCategoria);
				$nombre=utf8_encode($nombreCategoria['nombre']);
				$data[$i]['categoria']= $nombre;

				//obteniendo el array con secciones

				$data['secciones']=$this->getSecciones($obj->idNoticia);

				$data[$i]['idUsuarioAdmin']=$obj->idUsuarioAdmin;
				$data[$i]['titulo']=utf8_encode($obj->titulo);
				$data[$i]['subtitulo']=utf8_encode($obj->subtitulo);
				$data[$i]['imagen']=$obj->imagen;
				
				$data[$i]['tipoTemplate']=$obj->tipoTemplate;
				$data[$i]['estado']=$obj->estado;
				$data[$i]['fechaMod']=$obj->fechaMod;
				$data[$i]['fecha']=$obj->fecha;
				$i++;
			}
			$obj->free();
			//printVar($data,'getAllNoticias');
			//return $data;
		}

		function getNoticiaById($idNoticia){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenNoticia');
			$obj->estado='A';
			$obj->idNoticia=$idNoticia;
			$find=$obj->find();
			//printVar($obj);
			$data='';
			if($obj->fetch()){
				$data['idNoticia']=$obj->idNoticia;
				$data['contenido']=utf8_encode($obj->contenido);
				$data['idCategoria']=$obj->idCategoria;
				
				$nombreCategoria=$this->getCategoriaById($obj->idCategoria);
				$data['categoria']= $nombreCategoria;

				//obteniendo el array con secciones

				$data['secciones']=$this->getSecciones($obj->idNoticia);

				$data['idUsuarioAdmin']=$obj->idUsuarioAdmin;
				$data['titulo']=utf8_encode($obj->titulo);
				$data['subtitulo']=utf8_encode($obj->subtitulo);
				$data['imagen']=$obj->imagen;
				
				$data['tipoTemplate']=$obj->tipoTemplate;
				$data['estado']=$obj->estado;
				$data['fechaMod']=$obj->fechaMod;
				$data['fecha']=$obj->fecha;
			}
			$obj->free();
			return $data;
		}

		function getCategoriaById($idC){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenCategoria');

			$data=false;
			$obj->idCategoria=$idC;

			$obj->find();
			if($obj->fetch()){
				$data=$obj->nombre;
			}
			$obj->free();
			//printVar($data ,'getCargoById');
			return $data;
		}

		function getSecciones($idNoticia){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenSeccionNoticia');

			$obj->idNoticia=$idNoticia;
			$obj->estado='A';
			$obj->find();
			$i=0;
			$data='';
			while($obj->fetch()){
				$data[$i]['idSeccionNoticia']=$obj->idSeccionNoticia ;
				$data[$i]['idNoticia']=$obj->idNoticia ;
				$data[$i]['titulo']=$obj->titulo ;
				$data[$i]['imagen']=$obj->imagen ;
				$data[$i]['contenido']=$obj->contenido ;
				$data[$i]['estado']=$obj->estado ;
				$data[$i]['fechaMod']=$obj->fechaMod ;
				$data[$i]['fecha']=$obj->fecha ;
				$i++;
			}
			$obj->free();
			return $data;
		}
	
	}

 ?>