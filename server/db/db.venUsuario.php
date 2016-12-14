<?php
/**
 * Table Definition for ven_usuario
 */

class DataObject_VenUsuario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ven_usuario';                     // table name
    public $idUsuario;                       // int(11)  not_null primary_key auto_increment
    public $idCargo;                         // int(11)  not_null multiple_key
    public $nombre;                          // string(75)  
    public $apellido;                        // string(75)  
    public $email;                           // string(45)  
    public $usuario;                         // string(45)  
    public $contrasena;                      // string(45)  
    public $puntos;                          // string(45)  
    public $estado;                          // string(1)  enum
    public $fechaMod;                        // datetime(19)  binary
    public $fecha;                           // datetime(19)  binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObject_VenUsuario',$k,$v); }

    function table()
    {
         return array(
             'idUsuario' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'idCargo' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'nombre' =>  DB_DATAOBJECT_STR,
             'apellido' =>  DB_DATAOBJECT_STR,
             'email' =>  DB_DATAOBJECT_STR,
             'usuario' =>  DB_DATAOBJECT_STR,
             'contrasena' =>  DB_DATAOBJECT_STR,
             'puntos' =>  DB_DATAOBJECT_STR,
             'estado' =>  DB_DATAOBJECT_STR,
             'fechaMod' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
             'fecha' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
         );
    }

    function keys()
    {
         return array('idUsuario');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('idCargo', true, false);
    }

    function defaults() // column default values 
    {
         return array(
             'nombre' => '',
             'apellido' => '',
             'email' => '',
             'usuario' => '',
             'contrasena' => '',
             'puntos' => '',
             'estado' => 'A',
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
