<?php 


namespace Modalnetworks\EsModal\EsAbcd;



class Column{

    protected $fieldsNotApplyIndex = [
        'index','type','999','987','777','245A','245B','247A','247B','260C','260D','260M','260D','260S','263A','263M','263D','773T','21','13','thumbnail'
    ];
    protected $fieldsTimeStamps = ['777'];
    
    protected $column_separator = '|';

    protected $data;
   
    public function __construct( $data ) {
         $this->getColumnsFromLine($data);
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
                        if(empty($key)) continue;
                        if(in_array($key, $this->fieldsTimeStamps))
                          $ivalue = $this->replaceValidDate($ivalue);
                          
                          $data[$key] =  $ivalue ;//mb_convert_encoding(utf$ivalue,'UTF-8');

                        if(!in_array($key, $this->fieldsNotApplyIndex ,true)){
                            $arrayDataOnSave = array_map('trim', explode(';', $ivalue));
                            $data[$key] = $arrayDataOnSave;
                        }

                    }

                }

             $this->data = $data;    

    }


    private function clearArrayData(& $data){

       return $data;
        if(! $data OR !is_array($data)) return $data;
        foreach($data as $key => $value){
            $value = trim($value);
            if(mb_strlen($value) == 0)
                unset($data[$key]);
        }

        return $data;
    }


   private function replaceValidDate($date){
      if(empty($date)) return "";
       $date = str_replace('.', '0', $date);
        $explode_array = explode('-', $date);
        $year = (int) $explode_array['0'];
        $month = (int) (isset($explode_array['1']) ? $explode_array['1'] : 1);
        $day =  (int) (isset($explode_array['2']) ? $explode_array['2'] : 1);
        if($month > 12)
             $month = 1;
        if($day > 31)
            $day = 1;
       
       $date =  $year.'-'.$month.'-'.$day;
       $d = new \DateTime($date);

      return $d->format('Y-m-d');  

    }
}