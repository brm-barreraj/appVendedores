<?php
/**
 * Table Definition for ven_categoria
 */

class DataObject_VenCategoria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ven_categoria';                   // table name
    public $idCategoria;                     // int(11)  not_null primary_key auto_increment
    public $nombre;                          // string(150)  
    public $imagen;                          // string(150)  
    public $idPadre;                         // int(11)  
    public $estado;                          // string(1)  enum
    public $fechaMod;                        // datetime(19)  binary
    public $fecha;                           // datetime(19)  binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObject_VenCategoria',$k,$v); }

    function table()
    {
         return array(
             'idCategoria' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'nombre' =>  DB_DATAOBJECT_STR,
             'imagen' =>  DB_DATAOBJECT_STR,
             'idPadre' =>  DB_DATAOBJECT_INT,
             'estado' =>  DB_DATAOBJECT_STR,
             'fechaMod' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
             'fecha' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
         );
    }

    function keys()
    {
         return array('idCategoria');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('idCategoria', true, false);
    }

    function defaults() // column default values 
    {
         return array(
             'nombre' => '',
             'imagen' => '',
             'estado' => 'A',
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
