<?php 


namespace Modalnetworks\EsModal\EsAbcd;
use Modalnetworks\EsModal\Config;

class Row{

    /**
     * container data
     * @var array
     */
    protected $data;
    public function __construct( $data ) {
         $this->getColumnsFromLine($data);
    }
    
    /**
     * return data
     *
     * @return array
     */
    public function data(){
       return $this->data;
    }

    /**
     * build data for row
     *
     * @param string $register
     * @return array
     */  
    private function getColumnsFromLine($register){
          $data = [];
          foreach ($register as  $row) {
                    $column = new Column( trim($row, PHP_EOL) );
                    if ( ! $column->getName() ) continue;
                        $data[$column->getName()] = $column->getValue();
                }
              $this->addDefaultFields($data);  
             $this->data = $data;    
    }
   /**
    * @return void
    */ 
   private function addDefaultFields(& $data){
          
           $mapping = Config::get('elasticmapping');
           if ( !isset( $mapping['addDefaultFields']) ) return ;   
          
           foreach($mapping['addDefaultFields'] as $field => $row){
                   if(isset($data[$field])) continue;
                   $column = new Column( );
                   $column->setName($field)->setValue($row['defaultValue']);
                   $data[$field] =  $column->getValue();

           }

   }
}