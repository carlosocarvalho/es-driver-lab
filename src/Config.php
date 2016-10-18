<?php 

namespace Modalnetworks\EsModal;

use \Everon\Component\Collection\Collection;

class Config{
     
     protected static $config;

     
     public static function set($key , $value){
              self::$config[$key] = $value;
     }
     
     /**
     *  get Config item
     */
     public static function get( $key ){
       $config = self::$config;
       if(isset($config[$key]))
          return self::_collectionItem($config[$key]);
          return false;
     }



      
     private static function _collectionItem($data){
            return new Collection($data);
     }

}