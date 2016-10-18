<?php 


if(! function_exists('extractArgument')){
    
    
    function extractArgument( & $data, $arg){
     
     if (is_object($data) === true) { $data = (array) $data; }
         if (isset($data[$arg]) === true) {
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
