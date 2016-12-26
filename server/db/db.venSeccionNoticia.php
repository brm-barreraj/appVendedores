<?php
/**
 * Table Definition for ven_seccion_noticia
 */

class DataObject_VenSeccionNoticia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ven_seccion_noticia';             // table name
    public $idSeccionNoticia;                // int(11)  not_null primary_key auto_increment
    public $idNoticia;                       // int(11)  not_null multiple_key
    public $titulo;                          // string(150)  
    public $imagen;                          // string(150)  
    public $contenido;                       // blob(65535)  blob
    public $estado;                          // string(1)  enum
    public $fechaMod;                        // datetime(19)  binary
    public $fecha;                           // datetime(19)  binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObject_VenSeccionNoticia',$k,$v); }

    function table()
    {
         return array(
             'idSeccionNoticia' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'idNoticia' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'titulo' =>  DB_DATAOBJECT_STR,
             'imagen' =>  DB_DATAOBJECT_STR,
             'contenido' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_BLOB,
             'estado' =>  DB_DATAOBJECT_STR,
             'fechaMod' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
             'fecha' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
         );
    }

    function keys()
    {
         return array('idSeccionNoticia');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('idSeccionNoticia', true, false);
    }

    function defaults() // column default values 
    {
         return array(
             'titulo' => '',
             'imagen' => '',
             'contenido' => '',
             'estado' => 'A',
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
