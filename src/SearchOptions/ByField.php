<?php 

namespace Modalnetworks\EsModal\SearchOptions;

use Modalnetworks\EsModal\Contracts\SearchOptionContract;

class ByField implements SearchOptionContract {
    

    
    
    public function handle($query){

          $fields = $query['fields'];
          if(empty($fields))
             throw new Modalnetworks\EsModal\Exceptiosn\EmptyValue("Fields not set in Search ByField");

          $fields = preg_split('#,#', $fields);   
          return  [
                 'query_string' => [
                       'fields'=>$fields,
                       'query' =>  $query['query'],
                       'analyze_wildcard'=> true,
                       'default_operator' => $query['operator']

                ]
          ];
            
    }
    


}