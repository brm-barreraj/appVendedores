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
				$data[$i]['contenido']=$obj->contenido;
				$data[$i]['idCategoria']=$obj->idCategoria;
				
				$nombreCategoria=$this->getCategoriaById($obj->idCategoria);
				$nombre=$nombreCategoria['nombre'];
				$data[$i]['categoria']= $nombre;

				//obteniendo el array con secciones

				$data['secciones']=$this->getSecciones($obj->idNoticia);

				$data[$i]['idUsuarioAdmin']=$obj->idUsuarioAdmin;
				$data[$i]['titulo']=$obj->titulo;
				$data[$i]['subtitulo']=$obj->subtitulo;
				$data[$i]['imagen']=$obj->imagen;
				
				$data[$i]['tipoTemplate']=$obj->tipoTemplate;
				$data[$i]['estado']=$obj->estado;
				$data[$i]['fechaMod']=$obj->fechaMod;
				$data[$i]['fecha']=$obj->fecha;
				$i++;
			}
			$obj->free();
			printVar($data,'getAllNoticias');
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
			if($find>0){
				$data['idNoticia']=$obj->idNoticia;
				$data['contenido']=$obj->contenido;
				$data['idCategoria']=$obj->idCategoria;
				
				$nombreCategoria=$this->getCategoriaById($obj->idCategoria);
				$nombre=$nombreCategoria['nombre'];
				$data['categoria']= $nombre;

				//obteniendo el array con secciones

				$data['secciones']=$this->getSecciones($obj->idNoticia);

				$data['idUsuarioAdmin']=$obj->idUsuarioAdmin;
				$data['titulo']=$obj->titulo;
				$data['subtitulo']=$obj->subtitulo;
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
			//printVar($data,'getCargoById');
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
				$data['idSeccionNoticia']=$obj->idSeccionNoticia ;
				$data['idNoticia']=$obj->idNoticia ;
				$data['titulo']=$obj->titulo ;
				$data['imagen']=$obj->imagen ;
				$data['contenido']=$obj->contenido ;
				$data['estado']=$obj->estado ;
				$data['fechaMod']=$obj->fechaMod ;
				$data['fecha']=$obj->fecha ;
				$i++;
			}
			$obj->free();
			return $data;
		}
	
	}

 ?>