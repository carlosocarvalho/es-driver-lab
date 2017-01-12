<?php 


namespace Modalnetworks\EsModal\EsAbcd;
use Modalnetworks\EsModal\Config;

class Column{

    protected $fieldsNotApplyIndex = [];
    protected $fieldsTimeStamps = ['777'];
    
    protected $column_separator = '|';

    protected $data;

    protected $columns = [];
   
    public function __construct( $data ) {
          
        $mapping = Config::get('elasticmapping');
      
        $this->fieldsNotApplyIndex = $mapping['fields_string'];

         $this->getColumnsFromLine($data);
        
          $this->columns = $mapping['fields_in'];
        


        
    }
    
    public function data(){
       return $this->data;
    }


    private function getColumnsFromLine($row){
          $data = [];
          //$row = utf8_encode($row);
          
          foreach ($row as  $value) {
                    if(preg_match('#\|#', $value)){
                        $ns = explode('|',$value);
                        $key = trim($ns['0']);
                        $ivalue = trim($ns['1']);
                        if(empty($key) OR ($this->columns && !in_array($key, $this->columns))) continue;
                        if(in_array($key, $this->fieldsTimeStamps))
                          $ivalue = $this->replaceValidDate($ivalue);
                          $data[$key] =  $ivalue ;//mb_convert_encoding(utf$ivalue,'UTF-8');
                        if(!in_array($key, $this->fieldsNotApplyIndex ,true)){
                            $arrayDataOnSave = array_map('trim', explode(';', $ivalue));
                            $data[$key] = $this->clearArrayData($arrayDataOnSave); /*array_filter($arrayDataOnSave, function($row){
                                   $row = trim($row);
                                   if(!empty($row)) return $row;
                            });*/
                        }

                    }

                }

             $this->data = $data;    

    }


    private function clearArrayData($data){


        if(! $data OR !is_array($data)) return $data;
        $new_data = [];
        foreach($data as $key => $value){
            $value = trim($value);
            if(!empty($value))
                   $new_data[] = $value;


        }
        return $new_data;
    }


   private function replaceValidDate($date , $key = null){
       $date = preg_replace('/[^0-9]+/i','', $date);
       if(preg_match('#\d#', $date)){
           return substr($date,0, 8);
       }
       return str_pad(rand(2,5),8,'0', STR_PAD_LEFT);

    }
}