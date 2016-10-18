<?php 

namespace Modalnetworks\EsModal\SearchOptions;

use Modalnetworks\EsModal\Contracts\SearchOptionContract;

class ByOrder implements SearchOptionContract {
    

    
    
    public function handle($query){

          $fields = $query['fields'];
          if(empty($fields))
             throw new Modalnetworks\EsModal\Exceptiosn\EmptyValue("Fields not set in Search ByField");

           //$fields = array_combine($fields, $fields);  
          return  [
                  'sort' => array_map( function($order){
                           return ['order'=> $order];
                  }, $fields)
      
          ];
            
    }
    


}