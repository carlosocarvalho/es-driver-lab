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

    protected $documentId= null;

    protected $filters = [];

    public function __construct(){

        $mapping = \Modalnetworks\EsModal\Config::get('elasticmapping');
        $this->esBuilder = new EsBuilder;
        $this->fillable = $mapping['fields'];
        $this->es = new \Modalnetworks\EsModal\Search( \Modalnetworks\EsModal\Config::get('esabcd'));

    }

    /**
     * @param TransformerContract $transformer
     */
    public function setTransformer(TransformerContract $transformer){
        $this->transformer = $transformer;

    }

    /**
     * @return callable|\Closure|null
     */
    protected function getTransformer(){
        if(! $this->transformer OR ( !is_callable($this->transformer) && !is_object($this->transformer) ) ) return function($row){ return $row;};
        return $this->transformer;
    }

    public function setFields($fields = []){
        $this->fieldsBySearch = $fields;
        return ($this);
    }
    /**
     * @return $this
     */
    public function isPhrase(){
        $this->searchByWord = false;
        return $this;
    }

    /**
     * @return $this
     */
    public function isWord(){
        $this->searchByWord = true;
        return $this;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function setCurrentPage( $page = 1 ){
        $this->currentCursor = (int) ceil($page - 1);
        return $this;
    }

    /**
     * @param null $limit
     * @return $this
     */
    public function setLimit($limit = null ){
        if(!is_null($limit))
            $this->size = $limit;
        return $this;
    }

    /**
     * @param $index
     * @return BaseEs
     */
    public function setIndex($index){

        $this->index = $index;
        return ($this);
    }

    /**
     * @param $type
     * @return BaseEs
     */
    public function setType($type){

        $this->type = $type;
        return ($this);
    }


    /**
     * @param null $relevance
     * @return $this
     */
    public function setRelevance($relevance = null ){
        if(!is_null($relevance))
            $this->relevance = $relevance;
        return $this;
    }

    /**
     * @param $field
     * @param string $dir
     * @return $this
     */
    public function setOrderBy($field, $dir = 'asc'){
        $this->fieldsOrder[$field] = $dir;

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function byFields( $fields = []){
        $this->fillable = $fields;
        return $this;
    }

    /**
     * @param $q
     * @return $this
     */
    public function search($q){
        $params = [
            'query'    => $q ? $q : '*' ,
            'fields'   => $this->_getFields(),
            'operator' =>'AND'
        ];

        if($this->searchByWord)
            $query = $this->esBuilder->build('ByAll', $params);
        if(!$this->searchByWord)
            $query = $this->esBuilder->build('ByAllPhrase', $params);

        $this->query_dsl = ['body'=> array_merge(['query' => $query], $this->getPaginatorParams() ) ];
        $this->_search();


        return $this;

    }


    public function count(){
        return $this->es->count( $this->getParamsForSearch());
    }

    /**
     * @return array
     */
    public function result(){
        return $this->data;

    }

    /**
     * @return array
     */
    public function hits(){
        return $this->data ;//new Collection($this->data['hits']);
    }
    /**
     * @return array
     */
    public function lastParams(){

        return $this->query_dsl;
    }

    /**
     * @param $term
     * @param $value
     * @return BaseEs
     */
    public function setFilterAnd( $term, $value){
        $this->filters[] = [$term , $value];
        return ($this);

    }
    /**
     * @return array
     */
    protected function getParams(){
        $params = [];
        if(! empty( $this->index ))
            $params['index'] = $this->index;

        if(! empty( $this->type ))
            $params['type'] = $this->type;

        return $params;
    }
    /**
     * @return $this
     */
    private function _search(){

        $this->getParamsForSearch();
        $params = array_merge($this->getPaginatorParams(), $this->query_dsl);
        $data = $this->es->search( $params )['hits'];
        $this->data = $this->transformData($data['hits'] , $data['total']);
        return $this;
    }


    private function getParamsForSearch(){
        $this->_builderOrderBy()
            ->_builderHighLight()
            ->_builderIndexAndType()
            ->_builderFilterBoolAnd();

          return $this->query_dsl;
    }


    /**
     * @return array
     */
    private function getPaginatorParams(){
        return [
            'size' => $this->size,
            'from' => $this->currentCursor * $this->size
        ];
    }


    /**
     * @return $this
     */
    private function _builderOrderBy(){
        if( $this->fieldsOrder)
           $this->query_dsl['body'] =  array_merge( $this->query_dsl['body'], $this->esBuilder->build('ByOrder', ['fields' => $this->fieldsOrder])) ;

        return ($this);
    }

    /**
     * @return $this
     */
    private function _builderIndexAndType(){
        $query  = $this->query_dsl;


        if($this->index)
             $query = array_merge( $query, ['index'=> $this->index]);
        if($this->type)
            $query = array_merge($query,  ['type'=> $this->type]);

        $this->query_dsl = $query;
        return $this;

    }

    /**
     * @return $this
     */
    private function _builderId(){
        $query  = $this->query_dsl;
        if($this->documentId)
               $query['id'] = $this->documentId;
        $this->query_dsl = $query;
        return $this;

    }

    /**
     * @return $this
     */
    private function _builderHighLight(){
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
        if(isset($this->query_dsl['body']))
            $this->query_dsl['body'] =  array_merge( $this->query_dsl['body'], $highlight) ;
        return $this;
    }

    /**
     * @return BaseEs
     */
    private function _builderFilterBoolAnd(){

        if(!isset($this->query_dsl['body']) OR !$this->filters) return($this);
        $terms = [];
        foreach($this->filters as $row){
                list($label, $value) = $row;
            if(!isset($terms[$label]))
                $terms[$label] = [];
            $terms[$label][] = $value;

        }
        $query = $this->query_dsl['body']['query'];
        $filtered = [
            'filtered'=>[
                 'query' => $query,
                 'filter'=>[
                     'and'=>
                         [
                              'filters'=>
                                  [
                                    ["terms" => $terms]
                                  ]
                         ]
                 ]

            ]
        ];
        $this->query_dsl['body']['query'] = $filtered;
        //dump($this->query_dsl);
        //exit;
        return ($this);
    }

    /**
     * @return array
     */
    private function _getFields(){
        if(!$this->fieldsBySearch)
            return $this->fieldsBySearch = ['_all','*.folded'];
        $fields = $this->fieldsBySearch;
        foreach($this->fieldsBySearch as $field){
            $fields[] = "{$field}.folded";
        }
        return $fields;
    }

    /**
     * @param $id
     * @return BaseEs
     */
    public  function setId($id){
        $this->documentId =  $id;
        return ($this);
    }

    /**
     * @param $index
     * @param $type
     * @param $id
     * @return array|Collection
     */
    public function document($index, $type , $id){

        $data = $this->es->get(['index'=> $index, 'type'=> $type, 'id' => $id, 'client'=>['ignore' => [404]]]);
        if(! isset($data['found']) OR !$data['found'] ) return false;
        return $this->transformData([$data]);
    }


    public function update($index, $type, $id , $data){
        $update = ['index' => $index, 'type'=> $type, 'id'=> $id, 'body'=> ['doc'=>$data]];
        return $this->es->update($update);
    }

    /**
     * @param $data
     * @param int $toTotal
     * @return array|Collection
     */
    private function transformData($data, $toTotal = 1){
        $paginator = new Paginator( $toTotal, $this->size, $this->currentCursor + 1);
        $data = $data = new Collection(  $data , $this->getTransformer(), 'discovery');
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $data = $manager->createData($data)->toArray();

        if($toTotal > 0){
            $data['cursor'] = [
                'pages'     => $paginator->getNumPages(),
                'current'   => $paginator->getCurrentPage(),
                'next'      => $paginator->getNextPage(),
                'prev'     => $paginator->getPrevPage(),
                'count'    => $paginator->getTotalItems()

            ];
        }
        return $data;

    }

}