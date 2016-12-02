<?php

namespace Modalnetworks\EsModal\SearchOptions;

use Modalnetworks\EsModal\Contracts\SearchOptionContract;


class ByAll implements SearchOptionContract {





    public function handle($query){
        return  [
            'query_string'=> [
                'fields'=> $query['fields'] ,
                'query' => preg_replace('#\s+#',' '.$query['operator'].' ',trim($query['query']))
            ]
        ];
    }



}