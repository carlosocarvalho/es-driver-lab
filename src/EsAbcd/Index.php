<?php 

namespace Modalnetworks\EsModal\EsAbcd;
use Elasticsearch\ClientBuilder as Client;

//Index File
class Index{

    protected $config = [];
   
    protected $es;
    public function __construct( $es , $config){

        $this->es = $es;
        $this->config = $config;
    }  

    public function create( $forceDelete = false ){
         return $this->build($forceDelete);
                 
    }
    

    public function remap(){
    
         $config = $this->config;
        
        foreach ($config['indices'] as $key => $row) {
                 
             //if( ! $hasIndex OR $forceDelete ){
                   dump('remap index '. $key);        
                   $index = ['index'=> $key, 'type'=>  substr($key, 0, mb_strlen($key)-1 ), 'body'=>  $config['elasticsearchSettingIndex'] ];

                   
                   $this->es->indices()->putMapping( $index);
             //   }
         }
    }

    private function build( $forceDelete = false){
        $config = $this->config;

        
        foreach ($config['indices'] as $key => $row) {
             
             $hasIndex = $this->es->indices()->exists(['index'=> $key]);
             if($hasIndex && $forceDelete){
                     dump('delete '. $key);
                     $this->es->indices()->delete(['index'=> $key]);
             }
                 
             if( ! $hasIndex OR $forceDelete ){
                   dump('create index '. $key);
                   $this->es->indices()->create(['index'=> $key, 'body'=>  $config['elasticsearchSettingIndex']]);
                }
         }
    }  
    


    

}