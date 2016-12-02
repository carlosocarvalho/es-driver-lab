<?php 

namespace Modalnetworks\EsModal;

use Modalnetworks\EsModal\Config;
use Elasticsearch\ClientBuilder as Client;
use \Everon\Component\Collection\Collection;

class Search{

    protected $es;

    public function __construct($config ){


             $this->es = Client::create()
                         ->setHosts($config->toArray())
                         ->build();
     }

     
   public function es(){
      return $this->es;  
   } 
  
   public function __call($name, $args){
         $response = call_user_func_array([$this->es, $name], $args );
         try{
             return  $response;
         }catch(\Elasticsearch\Common\Exceptions $e){
            
         }
        
     }

    
    

}