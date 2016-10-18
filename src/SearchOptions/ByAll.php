<?php 

namespace Modalnetworks\EsModal\SearchOptions;

use Modalnetworks\EsModal\Contracts\SearchOptionContract;


class ByAll implements SearchOptionContract {
    
    
    public function handle($query){
        return  [
                 'multi_match' => [
                       'fields'=> $query['fields'],
                       'query' => $query['query'],
                       'type'=> 'most_fields'
                ]
          ];
    }
    


}