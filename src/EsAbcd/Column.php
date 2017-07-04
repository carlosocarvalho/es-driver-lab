<?php 

namespace Modalnetworks\EsModal\EsAbcd;
use Modalnetworks\EsModal\Config;

class Column  {

      protected $separator = '|';
     
      /**
       * key name
       * @var string
       */  
      private $name =  null;
      
      /**
       * value data 
       *
       * @var string
       */
      private $value;

      /**
       * data 
       *
       * @var string
       */ 
      private $str;
      
      public function __construct( $str = null )
      {       
             if ( $str )  
             $this->str = trim($str, $this->separator);
             //$this->name = trim($this->str, PHP_EOL) != "" ? trim($this->str, PHP_EOL) : null ;
             if ( preg_match('#\\'.$this->separator.'#', $this->str )) 
                 list( $this->name, $this->value) = explode($this->separator, $this->str);  
              
      }
      /**
       * return custom value
       *
       * @return string|object|array
       */
      public function getValue(){
             return $this->buildFieldValue();
      }
      
      /**
       * Undocumented function
       *
       * @param [type] $value
       * @return void
       */
      public function setValue($value){
          $this->value = $value;
          return $this;

      }
      /**
       * add customName
       *
       * @param [type] $name
       * @return void
       */
      public function setName($name){
          $this->name = $name;
          return $this;
      }

      /**
       * return key name 
       *
       * @return string
       */
      public function getName(){
             return $this->name;
      }  
      private function buildFieldValue(){
            return  $this->validateValueField($this->name, $this->value);
      }
      /**
       * 
       * @return void
       */   
      private function validateValueField($field,$value){
            $config = Config::get('elasticmapping');
            $callbacks = $config['callbacks'];
            if( ! $callbacks OR !isset($callbacks[$field])) return $value;
               return $this->validateCallbackColumn($callbacks[$field], $value);    
      }

      /**
       * callback execute
       *
       * @param array $callbacks
       * @param string $value
       * @return string|array
       */
      private function validateCallbackColumn($callbacks , $value){
                if ( !$callbacks ) return $value;
                foreach($callbacks as $callable){
                       $value =  call_user_func($callable, $value);
                }   
                return $value;
      }

      
      
}