<?php 


namespace Modalnetworks\EsModal;



class EsBuilder {


   
    public function build(){
        $args =  func_get_args();
            $esSearchType =  extractArgument($args,0);

            $c =  "\\Modalnetworks\EsModal\\SearchOptions\\{$esSearchType}";
           // if(!class_exists($c))
                
            $builderParams = new $c;
            
        return  call_user_func_array([$builderParams, 'handle'], $args);  
           
    }


}