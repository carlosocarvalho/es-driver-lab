<?php 

namespace Modalnetworks\EsModal;


use Elasticsearch\ClientBuilder as Client;

class ElasticRestore {
         
      
       protected $es;

       protected $esIndex;

       protected $up; 

       public function __construct( $logger ){


             $this->es =  $this->es = Client::create()
                         ->setHosts(\Modalnetworks\EsModal\Config::get('esabcd')->toArray())
                         ->setLogger($logger)
                         ->build();
             $this->esIndex = new \Modalnetworks\EsModal\EsAbcd\Index( $this->es, \Modalnetworks\EsModal\Config::get('elasticmapping'));


             $this->up =  new \Modalnetworks\EsModal\EsAbcd\UpFile();

       }


       function createIndex( $forceDelete = false){
            $this->esIndex->create($forceDelete);
              
       } 

       public function remapIndex(){
           $this->esIndex->remap();
       }

       public function save($data){
            try {

                  $data['client'] = [ 'ignore' => [404] ];
                  return  $this->es->index($data);        
            } catch (\Exceptions $exception) {
                  

                  dump($exception);

            }
          
       }

    public function bulk($data){
        try {

            $data['client'] = [ 'ignore' => [404] ];
            return  $this->es->bulk($data);
        } catch (\Exceptions $exception) {


            dump($exception);

        }

    }




       public function setLogger($logger){
            $this->es->setLogger($logger);
       }

       public function execute($path , $filename , $callback){
           return $this->up->setPath( $path )->setFile( $filename )->up($callback);

       }
}