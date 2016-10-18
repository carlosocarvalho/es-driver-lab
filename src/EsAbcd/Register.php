<?php 

namespace Modalnetworks\EsModal\EsAbcd;

use Modalnetworks\EsModal\EsAbcd\Column;
use \Everon\Component\Collection\Collection;

class Register{
      protected $data;

      protected $column_separator = '||';
      
      public function __construct( $data ){
             $this->data = $data;
      }

     public function build(){
          $row = $this->data;
          if(!$row) return [];  

          $row = trim($row, '\n');
          $row = trim($row, $this->column_separator); 
          $line = explode( $this->column_separator , $row);
            
            if($line){
               $register = (new Column($line))->data();
                if($register){
                    //$register = $register->toArray();
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