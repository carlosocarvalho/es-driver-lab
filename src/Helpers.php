<?php 


if(! function_exists('extractArgument')){
    
    
    function extractArgument( & $data, $arg){
     
     if ( is_object($data) === true) { $data = (array) $data; }
         if ( is_array($data)  && isset($data[$arg]) === true) {
               
                $val = $data[$arg];
                
                
                unset($data[$arg]);
                return $val;
       }
       return null;
            
   }

}



function array_merge_recursive_one($paArray1, $paArray2)
{
    if (!is_array($paArray1) or !is_array($paArray2)) { return $paArray2; }
    foreach ($paArray2 as $sKey2 => $sValue2)
    {
        $key = (string) "$sKey2";
        $paArray1[$key] = $sValue2;//array_merge_recursive_one($paArray1[$sKey2], $sValue2);
    }
    return $paArray1;
}


if ( ! function_exists('toArrayABCD')){

    /**
     * transform string  to array
     *
     * @param string $str
     * @return array
     */
    function toArrayABCD($str){
       $data = [];
       $separator = ';';
       $str = trim($str, $separator);
       array_filter( array_map('trim', preg_split("#{$separator}#", $str) ) ,function($row) use ( & $data) {
            if( mb_strlen($row) > 0 )
                $data[] = $row;
        });
       return $data;
    }
}


if ( ! function_exists('validateToDateABCD')){
    $counter = 0; 
    function validateToDateABCD( $str){
        global $counter;
        $str = preg_replace('/[^0-9]+/i','', $str);
       if(preg_match('#\d#', $str)){
           return substr($str,0, 8);
       }
       $counter +=1;
       return str_pad($counter,7,'0', STR_PAD_LEFT);
    }
}