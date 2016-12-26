<?php
/**
 * Table Definition for ven_noticia
 */

class DataObject_VenNoticia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ven_noticia';                     // table name
    public $idNoticia;                       // int(11)  not_null primary_key auto_increment
    public $idCategoria;                     // int(11)  not_null multiple_key
    public $idUsuarioAdmin;                  // int(11)  not_null multiple_key
    public $idProducto;                      // int(11)  not_null multiple_key
    public $titulo;                          // string(150)  
    public $subtitulo;                       // string(150)  
    public $imagen;                          // string(150)  
    public $video;                           // string(150)  
    public $pdf;                             // string(150)  
    public $contenido;                       // blob(65535)  blob
    public $tipoTemplate;                    // int(11)  
    public $fechaDesde;                      // datetime(19)  binary
    public $fechaHasta;                      // datetime(19)  binary
    public $estado;                          // string(1)  enum
    public $fechaMod;                        // datetime(19)  binary
    public $fecha;                           // datetime(19)  binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObject_VenNoticia',$k,$v); }

    function table()
    {
         return array(
             'idNoticia' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'idCategoria' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'idUsuarioAdmin' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'idProducto' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'titulo' =>  DB_DATAOBJECT_STR,
             'subtitulo' =>  DB_DATAOBJECT_STR,
             'imagen' =>  DB_DATAOBJECT_STR,
             'video' =>  DB_DATAOBJECT_STR,
             'pdf' =>  DB_DATAOBJECT_STR,
             'contenido' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_BLOB,
             'tipoTemplate' =>  DB_DATAOBJECT_INT,
             'fechaDesde' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
             'fechaHasta' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
             'estado' =>  DB_DATAOBJECT_STR,
             'fechaMod' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
             'fecha' =>  DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME,
         );
    }

    function keys()
    {
         return array('idNoticia');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('idNoticia', true, false);
    }

    function defaults() // column default values 
    {
         return array(
             'titulo' => '',
             'subtitulo' => '',
             'imagen' => '',
             'video' => '',
             'pdf' => '',
             'contenido' => '',
             'estado' => 'A',
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
