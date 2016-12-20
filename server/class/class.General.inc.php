<?php
class General
{
	/**
	* Se crea la tupla en la tabla dada
	* @param tabla: Nombre del DBO de la tabla
	*/
	function setInstancia($tabla){
		//DB_DataObject::debugLevel(1);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		
		$campos = $objDBO->table();
		unset($campos["id"]);
		unset($campos["fecha"]);
		
		//Asigna los valores
		foreach($campos as $key => $value){
			$objDBO->$key = utf8_decode($this->$key);
		}
		$objDBO->fecha = date("Y-m-d H:i:s");
		$objDBO->find();
		if($objDBO->fetch()){
			$ret = $objDBO->id;
		}else{
			$ret = $objDBO->insert();
		}
		
		//Libera el objeto DBO
		$objDBO->free();
		

		return ($ret);
	}

/**
	* Actualiza o inserta la tupla con id dado en la tabla dada
	* @param tabla: Nombre del DBO de la tabla a actualizar
	* @param campos: campos de la tabla a actualizar o instertar
	* @param id: Id del registro a actualizar
	*/
	function setUpdateInstancia($tabla,$campos,$campoWhere){
		//DB_DataObject::debugLevel(5);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		if (is_array($campoWhere)) {
			foreach ($campoWhere as $key => $value) {
				$objDBO->$key = $value;
			}
		}elseif ($campoWhere!="") { 
			$objDBO->whereAdd($campoWhere);
		}
		//Asigna los valores
		$objDBO->find();
		if($objDBO->fetch()){
			foreach($campos as $key => $value){
				$objDBO->$key = $value;
			}
			$objDBO->fechaMod = date("Y-m-d H:i:s");
			$ret=$objDBO->update();
		}else{
			foreach($campos as $key => $value){
				$objDBO->$key = $value;
			}
			$objDBO->fecha = date("Y-m-d H:i:s");
			$ret = $objDBO->insert();
		}
		//Libera el objeto DBO
		$objDBO->free();

		return ($ret);
	}


	
	
	/**
	* Actualiza la tupla con id dado en la tabla dada
	* @param tabla: Nombre del DBO de la tabla a actualizar
	* @param id: Id del registro a actualizar
	*/
	function updateInstancia($tabla,$id){
		//DB_DataObject::debugLevel(1);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		
		$campos = $objDBO->table();
		unset($campos["id"]);
		unset($campos["password"]);
		unset($campos["fecha"]);

		$objDBO->id = $id;
		
		//Asigna los valores
		$objDBO->find();
		if($objDBO->fetch()){
			foreach($campos as $key => $value){
				$objDBO->$key = utf8_decode($this->$key);
			}
			$objDBO->fecha = date("Y-m-d H:i:s");
			$objDBO->update();
			$ret = true;
		}else{
			$ret = false;
		}
		
		//Libera el objeto DBO
		$objDBO->free();

		return ($ret);
	}
	
	/**
	* Trae la tupla de la tabla dada
	* @param tabla: Nombre del DBO de la tabla
	* @param campo: arreglo con la dupla campo y valor
	*/
	function getInstancia($tabla,$campo){
		//DB_DataObject::debugLevel(1);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		
		$campos = $objDBO->table();
		
		if(is_array($campo)){
			foreach($campo as $key => $value){
				$objDBO->$key = $value;
			}
		}
		
		$objDBO->find();
		if($objDBO->fetch()){
			//Asigna los valores
			foreach($campos as $key => $value){
				$ret->$key = cambiaParaEnvio($objDBO->$key);
			}
		}else{
			$ret = false;
		}
		
		//Libera el objeto DBO
		$objDBO->free();
		

		return ($ret);
	}
	/**
	* Trae la tupla de la tabla dada
	* @param tabla: Nombre del DBO de la tabla
	* @param campo: arreglo con la dupla campo y valor
	*/
	function getInstancia2($tabla,$campo=NULL){
		//DB_DataObject::debugLevel(5);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		if(is_array($campo)){
			foreach($campo as $key => $value){
				$objDBO->$key = $value;
			}
		}
		$contador = 0;
		$objDBO->find();
		$columna = $objDBO->table();
		while ($objDBO->fetch()) {
			foreach ($columna as $key => $value) {
				$ret[$contador]->$key = cambiaParaEnvio($objDBO->$key);
			}
			$contador++;
		}
		
		//Libera el objeto DBO
		$objDBO->free();

		return $ret;	
	}
	/**
	* Borrar la tupla con id dado en la tabla dada
	* @param tabla: Nombre del DBO de la tabla donde se va a borrar
	* @param id: Id del registro a borrar
	*/
	function unSetInstancia($tabla,$id){
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
			
		$campos = $objDBO->table();
		
		if(strpos($id,',') === false){
			$objDBO->get($id);
		}else{
			$datos = split(',',$id);
			$objDBO->get($datos[0],$datos[1]);
		}
		
		
		$ret = $objDBO->delete();
		
		//Libera el objeto DBO
		$objDBO->free();
		

		return ($ret);
	}

	/**
	* Trae el listado de campos sin id ni fecha
	* @param tabla: Nombre del DBO de la tabla 
	*/
	function getCampos($tabla){
		//DB_DataObject::debugLevel(5);
		//Crea una nueva instancia de $tabla a partir de DataObject
		$objDBO = DB_DataObject::Factory($tabla);
		
		$campos = $objDBO->table();
		
		unset($campos["id"]);
		unset($campos["fecha"]);
		
		//Libera el objeto DBO
		$objDBO->free();
		
		return ($campos);
	}
	function getTotalDatos($table = '',$fields = '',$conditions = '',$orden = '',$limiteInferior = -1,$limiteSuperior = -1,$notIn=''){
		//DB_DataObject::debugLevel(1);
		
		//printVar($table,"tabla");
		//printVar($fields,"Field");
		//printVar($conditions,"Cond");
		//printVar($orden);
		//printVar($limiteInferior);
		//printVar($limiteSuperior);
		//printVar($notIn);
		$objDBO = DB_DataObject::Factory($table);
		
		$rows = array();
		$ret=false;
		if(is_array($conditions)){ // como arreglo asociativo
			foreach($conditions as $key => $value){
				$objDBO->$key = $value;
			}
		}else{ // como cadena
			if($conditions != ''){
				$objDBO->whereAdd($conditions);
			}
		}
		
		if(is_array($fields)){
			$objDBO->selectAdd();
			foreach($fields as $key => $value){
				$objDBO->selectAdd($value);
			}
		}else{
			$fields = $objDBO->table();
			foreach($fields as $key => $value){
				$fields[$key] = $key;
			}
			/*printVar($fields);
			$fields = array_flip($fields);
			printVar($fields);*/
		}
		if($notIn!=""){
			$objDBO->whereAdd($notIn[0]." NOT IN(".$notIn[1].")");
		}
		//Si existe un limit, aumenta en el condicional de la consulta
		if( $limiteInferior >= 0 )
		{
			//$star_item = ($limiteInferior-1)*$limiteSuperior;
			$objDBO->limit($limiteInferior, $limiteSuperior);
		}
		
		
		if($orden != ""){
			$objDBO->orderBy($orden);
		}
		
		$objDBO->find();
		$cont = 0;
		
		while($objDBO->fetch()){
			//Asigna los valores
			$rows[$cont]->id = $objDBO->id;
			if(is_array($fields)){
				foreach($fields as $key => $value){
					$posCad = strpos($value, "AS");
					if($posCad !== FALSE){
						$value = substr($value,$posCad + 3);
					}
					//$rows[$cont]->$value = cambiaParaEnvio($objDBO->$value);
					$encoding= mb_detect_encoding($objDBO->$value, "auto");
					//printVar($encoding);
					if($encoding == 'UTF-8'){
						// Local
						$rows[$cont]->$value =  utf8_encode($objDBO->$value);
						// Servidor
						//$rows[$cont]->$value =  $objDBO->$value;
					}else{
						if($encoding == 'ASCII'){
							$rows[$cont]->$value = utf8_decode($objDBO->$value);
						}else{
							$rows[$cont]->$value = $objDBO->$value;
						}
					}
					
				}
			}
			$cont++;
			$ret = true;
		}
		
		//DB_DataObject::debugLevel(0);
		
		//Free DBO object
		$objDBO->free();
		if($ret){
			$ret = $rows;
		}
		return($ret);
	}

	function countRows($table,$conditions=""){
		$objDBO = DB_DataObject::Factory($table);
		if ($conditions!="") {
			$objDBO->whereAdd($conditions);
		}
		$total = $objDBO->count(DB_DATAOBJECT_WHEREADD_ONLY);
		$objDBO->free();
		return $total;
	}

	function query($tabla,$query){
		$objDBO = DB_DataObject::Factory($tabla);
		$objDBO->query($query);
		$rows=array();
		while($objDBO->fetch()){
			//Asigna los valores
			$rows[] = $objDBO->toArray();
		}
		$objDBO->free();
		return($rows);
	}

	function moveFile($file,$ruta,$id){
		$ext=explode('.',$file['name']);
		$temporal=$file['tmp_name'];
		$imgFinal=$id.'-'.date('Y_m_d_H_i_s').'.'.$ext[1];
		$urlDef=$ruta.$imgFinal;
		$guarda=move_uploaded_file($temporal, $urlDef);//$guarda true si guardo la factura en la carpeta recien creada
		if ($guarda) { //si guarda la imagen en la carpeta
			$res = $imgFinal;
		}else{// si no gurado la imagen en la carpeta
			$res = false;
		}
		return $res;
	}

	function validaCookie($val){
		$d = base64_decode($val);
		$d = explode('+', $d);
		$objDBO = DB_DataObject::Factory('VenUsuarioAdmin');
		$objDBO->nombre = $d[0];
		$objDBO->apellido = $d[1];
		$objDBO->email = $d[2];
		$objDBO->estado = 'A';
		$res = $objDBO->find();
		$ret=false;
		if($res > 0){
			$ret = true;
		}
		$objDBO->free();
		return $ret;
	}
}
?>