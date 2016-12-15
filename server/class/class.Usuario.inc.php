<?php 
	class Usuario{

		/*metodos para los usuarios*/

		//obtiene todos los usuarios 
		function getAllUsuarios(){
			DB_DataObject::debugLevel(1);
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
			printVar($data,'getAllUsuarios');
			return $data;
		}

		function getUsuariosLimit(){
			DB_DataObject::debugLevel(1);
			$obj = DB_DataObject::Factory('VenUsuario');
			$obj->limit(5);
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
			printVar($data,'getAllUsuarios');
			return $data;
		}

	/*medotos para los cargos*/

	//obtiene un cargo por su id
		function getCargoById($idCargo){
			DB_DataObject::debugLevel(1);
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
			printVar($data,'getCargoById');
			return $data;
		}

		//obtiene todos los cargos
		function getAllCargos(){
			DB_DataObject::debugLevel(1);
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
			printVar($data,'getAllCargos');
			return $data;
		}

	}
?>