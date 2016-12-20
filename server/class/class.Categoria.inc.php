<?php 
	class Categoria{

		private $limite=10;
		
		/*metodos para los Categorias*/

		function getLimit(){
			return $this->limite;
		}

		function getCountCategorias(){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenCategoria');
			$obj->whereAdd('idPadre > 0');
			$ret = $obj->count();
			//printVar($ret);
			return $ret;
		}

		//obtiene todos los Categorias 
		function getAllCategorias(){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenCategoria');
			$obj->whereAdd('idPadre > 0');
			$obj->find();
			$i = 0;
			$data='';
			while($obj->fetch()){
				$data[$i]['idCategoria']=$obj->idCategoria;
				$data[$i]['nombre']=$obj->nombre;
				$data[$i]['imagen']=$obj->imagen;

				$data[$i]['idPadre']=$obj->idPadre;
				$nomPa=$this->getCategoriaById($obj->idPadre);
				$data[$i]['padre']=$nomPa;

				$data[$i]['estado']=$obj->estado;				
				$data[$i]['fechaMod']=$obj->fechaMod;
				$data[$i]['fecha']=$obj->fecha;
				$i++;
			}
			$obj->free();
			//printVar($data,'getAllCategorias');
			return $data;
		}

		//llamada desde el goCategorias.php
		function getCategoriasLimit(){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenCategoria');
			$obj->whereAdd('idPadre > 0');
			//$obj->limit($this->limite);
			$obj->estado = 'A';
			$obj->find();
			$i = 0;
			$data='';
			while($obj->fetch()){
				$data[$i]['idCategoria']=$obj->idCategoria;
				$data[$i]['nombre']=utf8_encode($obj->nombre);
				$data[$i]['imagen']=$obj->imagen;
				$data[$i]['idPadre']=$obj->idPadre;


				$nomPa=$this->getCategoriaById($obj->idPadre);
				$data[$i]['padre']=$nomPa;

				$data[$i]['estado']=$obj->estado;			
				$data[$i]['fechaMod']=$obj->fechaMod;
				$data[$i]['fecha']=$obj->fecha;

				$i++;
			}
			$obj->free();
			//printVar($data,'getCategoriasLimit');
			return $data;
		}

		//llamado desde ajax para el paginador
		function getCategoriasLimitRange($ini){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenCategoria');
			$obj->whereAdd('idPadre > 0');
			$obj->limit($ini,$this->limite);
			$obj->find();
			$i = 0;
			$data='';
			while($obj->fetch()){
				$data[$i]['idCategoria']=$obj->idCategoria;
				$data[$i]['nombre']=$obj->nombre;
				$data[$i]['imagen']=$obj->imagen;
				$data[$i]['idPadre']=$obj->idPadre;
				$nomPa=$this->getCategoriaById($obj->idPadre);
				$data[$i]['padre']=$nomPa;
				$data[$i]['estado']=$obj->estado;				
				$data[$i]['fechaMod']=$obj->fechaMod;
				$data[$i]['fecha']=$obj->fecha;
				
				$i++;
			}
			$obj->free();
			//printVar($data,'getCategoriasLimitRange');
			return $data;
		}

		function serchTermCat($termino){

			$control = (is_numeric($termino) )? 'numb': 'stri';

			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenCategoria');
			$obj->whereAdd('idPadre > 0');
			$data='';
			
			switch ($control) {
				case 'numb':
					/*$obj->whereAdd('idPadre LIKE "'.$obj->escape($termino).'%"');
					//$obj->whereAdd('age > 30', 'OR');
					$obj->find();
					$i=0;
					while($obj->fetch()){
						$data[$i]['idCategoria']=$obj->idCategoria;
						$data[$i]['nombre']=$obj->nombre;
					
						$data[$i]['imagen']=$obj->imagen;
						$data[$i]['idPadre']=$obj->idPadre;
						$nomPa=$this->getCategoriaById($obj->idPadre);
				$data[$i]['padre']=$nomPa;
						$data[$i]['estado']=$obj->estado;
						$data[$i]['fecha']=$obj->fecha;
						
						$i++;
					}
					//printVar($data);
					return $data;*/
				break;

				case 'stri':
					$obj->whereAdd('nombre LIKE "'.$obj->escape($termino).'%"');
					//$obj->whereAdd('imagen LIKE "'.$obj->escape($termino).'%"', 'OR');
					$obj->find();
					$i=0;
					while($obj->fetch()){
						$data[$i]['idCategoria']=$obj->idCategoria;
						$data[$i]['nombre']=utf8_encode($obj->nombre);
						$data[$i]['imagen']=$obj->imagen;
						$data[$i]['idPadre']=$obj->idPadre;
						$nomPa=$this->getCategoriaById($obj->idPadre);
						$data[$i]['padre']=$nomPa;
						$data[$i]['estado']=$obj->estado;
						$data[$i]['fecha']=$obj->fecha;
						

						$i++;
					}
					//printVar($data);
					$obj->free();
					return $data;
				break;
				
			}
			/*$obj->limit($ini,$this->limite);
			$obj->find();
			$i = 0;
			$data='';
			while($obj->fetch()){
			}*/
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

	}
?>