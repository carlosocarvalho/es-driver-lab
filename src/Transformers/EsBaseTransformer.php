<?php 

namespace Modalnetworks\EsModal\Transformers;

use \Modalnetworks\EsModal\Contracts\TransformerContract;
use \Modalnetworks\EsModal\Repositories\EsBase;
use League\Fractal;

class EsBaseTransformer extends Fractal\TransformerAbstract implements TransformerContract{


    public function transform(  $es ){
             
            $body =  extractArgument($es, '_source');
            $data =  [
                    'index' => $es['_index'],
                    'type'  => $es['_type'],
                    'es_id' => $es['_id'],
                    'author'   => isset($body['993']) ?  $body['993'] : [],                    
                    'title'    => isset($body['245A']) && is_string($body['245A']) ? $body['245A'] : ( isset($body['245A']) && is_array($body['245A']) ? implode('',$body['245A']): ''),
                    
                    
            ]  ;   

             return array_merge_recursive_one($data , $body);
           
    }
}