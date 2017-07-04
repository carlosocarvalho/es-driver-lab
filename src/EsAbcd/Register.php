<?php 

namespace Modalnetworks\EsModal\EsAbcd;

use Modalnetworks\EsModal\EsAbcd\Row;
use \Everon\Component\Collection\Collection;
//register
class Register{
      protected $data;

      protected $column_separator = '||';
      
      public function __construct( $data  ){
             $this->data = $data;
            // return $this->build();
      }

      function build(){
          $row = $this->data;
          if(!$row) return [];  

          $row = trim($row, PHP_EOL);
          $row = trim($row, $this->column_separator); 
          $line = explode( $this->column_separator , $row);
            
            if($line){
               $register = (new Row($line))->data();
                if($register){
                    $index = extractArgument($register, 'index');
                    $type = extractArgument($register, 'type');
                    return  new Collection([
                        'index'=>strtolower(trim($index)),
                        'type'=>strtolower(trim($type)),
                        'body'=> $register
                        ]);
                }
               

            }
            return [];

     } 





}