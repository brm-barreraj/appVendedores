<?php 
	class Usuario{

		private $limite=10;
		
		/*metodos para los usuarios*/

		function getLimit(){
			return $this->limite;
		}

		function getCountUsuarios(){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenUsuario');
			
			$ret = $obj->count();
			//printVar($ret);
			return $ret;
		}

		//obtiene todos los usuarios 
		function getAllUsuarios(){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenUsuario');
			$obj->find();
			$i = 0;
			$data='';
			while($obj->fetch()){
				$data[$i]['idUsuario']=$obj->idUsuario;
				$data[$i]['idCargo']=$obj->idCargo;
				
				$nombreCargo=$this->getCargoById($obj->idCargo);
				$nombreCargo=$nombreCargo['nombre'];
				$data[$i]['cargo']= $nombreCargo;

				$data[$i]['nombre']=$obj->nombre;
				$data[$i]['apellido']=$obj->apellido;
				$data[$i]['email']=$obj->email;
				$data[$i]['usuario']=$obj->usuario;
				
				$data[$i]['contrasena']=$obj->contrasena;
				$data[$i]['puntos']=$obj->puntos;
				$data[$i]['estado']=$obj->estado;
				$data[$i]['fechaMod']=$obj->fechaMod;
				$data[$i]['fecha']=$obj->fecha;
				$i++;
			}
			$obj->free();
			//printVar($data,'getAllUsuarios');
			return $data;
		}

		//llamada desde el goUsuarios.php
		function getUsuariosLimit(){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenUsuario');
			$obj->limit($this->limite);
			$obj->find();
			$i = 0;
			$data='';
			while($obj->fetch()){
				$data[$i]['idUsuario']=$obj->idUsuario;
				$data[$i]['idCargo']=$obj->idCargo;
				
				$nombreCargo=$this->getCargoById($obj->idCargo);
				$nombreCargo=$nombreCargo['nombre'];
				$data[$i]['cargo']= $nombreCargo;

				$data[$i]['nombre']=$obj->nombre;
				$data[$i]['apellido']=$obj->apellido;
				$data[$i]['email']=$obj->email;
				$data[$i]['usuario']=$obj->usuario;
				
				$data[$i]['contrasena']=$obj->contrasena;
				$data[$i]['puntos']=$obj->puntos;
				$data[$i]['estado']=$obj->estado;
				$data[$i]['fechaMod']=$obj->fechaMod;
				$data[$i]['fecha']=$obj->fecha;
				$i++;
			}
			$obj->free();
			//printVar($data,'getUsuariosLimit');
			return $data;
		}

		//llamado desde ajax para el paginador
		function getUsuariosLimitRange($ini){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenUsuario');
			$obj->limit($ini,$this->limite);
			$obj->find();
			$i = 0;
			$data='';
			while($obj->fetch()){
				$data[$i]['idUsuario']=$obj->idUsuario;
				$data[$i]['idCargo']=$obj->idCargo;
				
				$nombreCargo=$this->getCargoById($obj->idCargo);
				$nombreCargo=$nombreCargo['nombre'];
				$data[$i]['cargo']= $nombreCargo;

				$data[$i]['nombre']=$obj->nombre;
				$data[$i]['apellido']=$obj->apellido;
				$data[$i]['email']=$obj->email;
				$data[$i]['usuario']=$obj->usuario;
				
				$data[$i]['contrasena']=$obj->contrasena;
				$data[$i]['puntos']=$obj->puntos;
				$data[$i]['estado']=$obj->estado;
				$data[$i]['fechaMod']=$obj->fechaMod;
				$data[$i]['fecha']=$obj->fecha;
				$i++;
			}
			$obj->free();
			//printVar($data,'getUsuariosLimitRange');
			return $data;
		}

		function serchTermUser($termino){

			$control = (is_numeric($termino) )? 'numb': 'stri';

			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenUsuario');
			$data='';
			
			switch ($control) {
				case 'numb':
					$obj->whereAdd('puntos LIKE "'.$obj->escape($termino).'%"');
					//$obj->whereAdd('age > 30', 'OR');
					$obj->find();
					$i=0;
					while($obj->fetch()){
						$data[$i]['idUsuario']=$obj->idUsuario;
						$data[$i]['idCargo']=$obj->idCargo;

						$nombreCargo=$this->getCargoById($obj->idCargo);
						$nombreCargo=$nombreCargo['nombre'];
						$data[$i]['cargo']= $nombreCargo;
						
						$data[$i]['nombre']=$obj->nombre;
						$data[$i]['apellido']=$obj->apellido;
						$data[$i]['email']=$obj->email;
						$data[$i]['usuario']=$obj->usuario;
						$data[$i]['puntos']=$obj->puntos;
						$data[$i]['estado']=$obj->estado;
						$data[$i]['fechaMod']=$obj->fechaMod;
						$data[$i]['fecha']=$obj->fecha;

						$i++;
					}
					//printVar($data);
					return $data;
				break;

				case 'stri':
					$obj->whereAdd('nombre LIKE "'.$obj->escape($termino).'%"');
					$obj->whereAdd('apellido LIKE "'.$obj->escape($termino).'%"', 'OR');
					$obj->find();
					$i=0;
					while($obj->fetch()){
						$data[$i]['idUsuario']=$obj->idUsuario;
						$data[$i]['idCargo']=$obj->idCargo;

						$nombreCargo=$this->getCargoById($obj->idCargo);
						$nombreCargo=$nombreCargo['nombre'];
						$data[$i]['cargo']= $nombreCargo;
						
						$data[$i]['nombre']=$obj->nombre;
						$data[$i]['apellido']=$obj->apellido;
						$data[$i]['email']=$obj->email;
						$data[$i]['usuario']=$obj->usuario;
						$data[$i]['puntos']=$obj->puntos;
						$data[$i]['estado']=$obj->estado;
						$data[$i]['fechaMod']=$obj->fechaMod;
						$data[$i]['fecha']=$obj->fecha;

						$i++;
					}
					//printVar($data);
					$obj->free();
					return $data;
				break;
				
			}

			
			$obj->limit($ini,$this->limite);
			$obj->find();
			$i = 0;
			$data='';
			while($obj->fetch()){
		}
	}

	/*medotos para los cargos*/

	//obtiene un cargo por su id
		function getCargoById($idCargo){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenCargo');
			$data=false;
			$obj->idCargo=$idCargo;
			$obj->find();
			if($obj->fetch()){
				$data['idCargo']=$obj->idCargo;
				$data['nombre']=$obj->nombre;
				$data['estado']=$obj->estado;
				$data['fechaMod']=$obj->fechaMod;
				$data['fecha']=$obj->fecha;			
			}
			$obj->free();
			//printVar($data,'getCargoById');
			return $data;
		}

		//obtiene todos los cargos
		function getAllCargos(){
			DB_DataObject::debugLevel(0);
			$obj = DB_DataObject::Factory('VenCargo');
			$data=false;
			$obj->find();
			$i=0;
			while($obj->fetch()){
				$data[$i]['idCargo']=$obj->idCargo;
				$data[$i]['nombre']=$obj->nombre;
				$data[$i]['estado']=$obj->estado;
				$data[$i]['fechaMod']=$obj->fechaMod;
				$data[$i]['fecha']=$obj->fecha;	
				$i++;		
			}
			$obj->free();
			//printVar($data,'getAllCargos');
			return $data;
		}

	}
?>