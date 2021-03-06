<?php
/**
 * Table Definition for ven_producto
 */

class DataObject_VenProducto extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ven_producto';                    // table name
    public $idProducto;                      // int(11)  not_null primary_key auto_increment
    public $nombre;                          // string(75)  
    public $estado;                          // string(1)  enum
    public $fechaMod;                        // datetime(19)  binary
    public $fecha;                           // datetime(19)  binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObject_VenProducto',$k,$v); }

    function table()
    {
         return array(
             'idProducto' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'nombre' =>  DB_DATAOBJECT_STR,
             'estado' =>  DB_DATAOBJECT_STR,
             'fechaMod' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
             'fecha' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
         );
    }

    function keys()
    {
         return array('idProducto');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('idProducto', true, false);
    }

    function defaults() // column default values 
    {
         return array(
             'nombre' => '',
             'estado' => 'A',
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
