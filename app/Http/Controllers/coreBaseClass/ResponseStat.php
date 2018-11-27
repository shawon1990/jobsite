<?php

/**
 * Created by PhpStorm.
 * User: mi
 * Date: 3/11/16
 * Time: 5:10 PM
 */
namespace App\Http\Controllers\coreBaseClass;
class ResponseStat {
    public  $status;
    public  $isLogin;
    public $msg;
    public $requestError;

    function __construct() {
        $this->status = true;
        $this->isLogin = false;
        $this->msg = "";
        $this->requestError = [];

    }
}