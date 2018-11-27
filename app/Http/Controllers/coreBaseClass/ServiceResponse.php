<?php

/**
 * Created by PhpStorm.
 * User: mi
 * Date: 3/11/16
 * Time: 5:09 PM
 */

namespace App\Http\Controllers\coreBaseClass;
class ServiceResponse {

    public $responseStat;
    public $responseData;

    function __construct() {
        $this->responseStat = new ResponseStat();
        $this->responseData = new \stdClass();
    }
}