<?php

namespace App\Traits;


trait generalTrait
{
	function returnError($errNum, $msg){
        return response()->json([
            'status'    => false,
            'errNum'   => $errNum,
            'Message'   => $msg,
        ]);
    }

    function returnSuccessMessage($errNum = '', $msg = 'S000'){
        return response()->json([
            'status'    => true,
            'errNum'   => $errNum,
            'Message'   => $msg,
        ]);
    }

    function returnData($key, $value, $errNum = 'S000', $msg = 'Success Pass data'){
        return response()->json([
            'status'    => true,
            'errNum'   => $errNum,
            'Message'   => $msg,
            $key        => $value,
        ]);  
    }
}
?>