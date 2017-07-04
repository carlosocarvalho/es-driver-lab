<?php 
namespace Modalnetworks\EsModal\EsAbcd;

use Modalnetworks\EsModal\Exceptions\NotFound;
use Modalnetworks\EsModal\Exceptions\EmptyValue;

class UpFile {

    protected $path;
    
    protected $filename;

    
    public function setPath( $path ){
        if(empty( $path) )
              throw new \Modalnetworks\EsModal\Exceptions\EmptyValue('Path is empty');
        $this->path = $path;
        return $this;
    }


    public function setFile( $filename ){
         if(empty( $filename) )
              throw new EmptyValue("Filename {$filename} is empty");
         $this->filename = $filename;
         return $this;
    }

    public function up( $callback  = null ){

      $this->path = trim($this->path, '/');
      $filename = "{$this->path}/{$this->filename}";   
           if( !file_exists($filename) ) throw new NotFound("Filename {$filename} not found");
         
      $handler = fopen($filename, 'r');
      $i = 0;
      while(!feof( $handler)){
           $row = fgets($handler);
           $row = utf8_encode($row);
           $data = (new \Modalnetworks\EsModal\EsAbcd\Register($row, $i))->build();
           if( is_callable ($callback) )
                 call_user_func($callback,$data, $i);
             $i+=1;     
      }

      fclose($handler);   

    }

     
}