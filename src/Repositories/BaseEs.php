<?php 

namespace Modalnetworks\EsModal\Repositories;

//use \Everon\Component\Collection\Collection;

use \League\Fractal\Resource\Collection;

use \League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Pagination\Cursor;
use Modalnetworks\EsModal\EsAbcd\Paginator;
use Modalnetworks\EsModal\EsBuilder;
use Modalnetworks\EsModal\Contracts\TransformerContract;

class BaseEs extends \ArrayIterator{

   
   protected $es;
   protected $index;

   protected $type;

  protected $data = [];

   protected $query_dsl = [];
   
   protected $size = 20;

   protected $currentCursor = 0 ;

   protected $relevance = 100;

   protected $esBuilder;

   protected $fillable = [];
 

   protected $searchByWord = true; 


   protected $fieldsOrder = [];
   

   protected $fieldsBySearch = [];

   protected $transformer = null;

   public function __construct(){

       $mapping = \Modalnetworks\EsModal\Config::get('elasticmapping');
       $this->esBuilder = new EsBuilder;
       $this->fillable = $mapping['fields'];
       $this->es = new \Modalnetworks\EsModal\Search( \Modalnetworks\EsModal\Config::get('esabcd'));

   }
  
  public function setTransformer(TransformerContract $transformer){
        $this->transformer = $transformer;

  }

  protected function getTransformer(){
      if(! $this->transformer OR ( !is_callable($this->transformer) && !is_object($this->transformer) ) ) return function($row){ return $row;};
      return $this->transformer;
  }
  
  public function isPhrase(){
      $this->searchByWord = false;
      return $this;
  }

  public function isWord(){
      $this->searchByWord = true;
      return $this;
  }
  
   
   public function setCurrentPage( $page = 1 ){
       $this->currentCursor = (int) ceil($page - 1);
       return $this;
   }

   public function setLimit($limit = null ){
         if(!is_null($limit))
           $this->size = $limit;
       return $this;
   }

   public function setIndex($index){

          $this->index = $index;
   }

   public function setRelevance($relevance = null ){
         if(!is_null($relevance))
           $this->relevance = $relevance;
       return $this;
   }


   public function setOrderBy($field, $dir = 'asc'){
           $this->fieldsOrder[$field] = $dir;
       
   }
   public function byFields( $fields = []){
       $this->fillable = $fields;
       return $this;       
   }
    
   public function search($q){
        $params = [
             'query'    => $q ? $q : '*' ,
             'fields'   => $this->_getFields(),             
         ];

        if($this->searchByWord)
        $query = $this->esBuilder->build('ByAll', $params);
        if(!$this->searchByWord)
        $query = $this->esBuilder->build('ByAllPhrase', $params);

        $this->query_dsl = ['body'=> array_merge(['query' => $query], $this->getPaginatorParams() ) ]; 
        $this->_search();      
        return $this;

   }
   /**/
   public function result(){
       return $this->data;

   }
   /*
   *
   */
   public function hits(){
       return $this->data ;//new Collection($this->data['hits']);
   }

   
   public function lastParams(){

       return $this->query_dsl;
   }




   protected function getParams(){
           $params = [];
           if(! empty( $this->index ))
                $params['index'] = $this->index;

             if(! empty( $this->type ))
                $params['type'] = $this->type;     
          
          return $params;
   }


   
   private function _search(){
    
        
        $this->_builderOrderBy();
        $this->_builderHighLight();
        
        $data = $this->es->search($this->query_dsl)['hits'];
        
        $paginator = new Paginator($data['total'], $this->size, $this->currentCursor + 1);
        $cursor = new Cursor($paginator->getCurrentPage() , $paginator->getPrevPage(), $paginator->getNextPage() , $data['total'] );
        $data = $data = new Collection(  $data['hits']  , $this->getTransformer(), 'discovery');
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        
        $this->data = $manager->createData($data->setCursor($cursor))->toArray();
        $this->data['paginator'] = $paginator;   
        return $this;  
   }


   private function getPaginatorParams(){
       return [
           'size' => $this->size,
            'from' => $this->currentCursor * $this->size
       ];
   }
   


   private function _builderOrderBy(){

       if( ! $this->fieldsOrder) return;
        $this->query_dsl['body'] =  array_merge( $this->query_dsl['body'], $this->esBuilder->build('ByOrder', ['fields' => $this->fieldsOrder])) ; 

   }


  private function _builderHighLight(){

       //if( ! $this->fieldsOrder) return;
        
        $highlight = [
             'highlight'=>[
             'pre_tags' =>['<strong class="es-high">'],
             'post_tags' =>['</strong>'],
             "number_of_fragments" => 2,
             "fragment_size" => 150,
             'tag_schema' =>  'styled',
             'fields' => [
                 '_all' => ['pre_tags'=>['<strong>'],'post_tags'=>['</strong>']]
             ]
            ]
         ];

        $this->query_dsl['body'] =  array_merge( $this->query_dsl['body'], $highlight) ; 

   }



   private function _getFields(){
       if(!$this->fieldsBySearch)
            $this->fieldsBySearch = $this->fillable;
             
            $fields = $this->fieldsBySearch;
           foreach($this->fieldsBySearch as $field){
               $fields[] = "{$field}.folded";
           }    

            return $fields;
   }

}