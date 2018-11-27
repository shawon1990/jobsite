<?php
/**
 * Created by IntelliJ IDEA.
 * User: omar
 * Date: 12/14/16
 * Time: 4:31 PM
 */

namespace App\Http\Controllers\coreBaseClass;


class ErrorObj{
    public $params;
    public $msg;

    /**
     * ErrorManager constructor.
     * @param $msg
     * @param $status
     */

    function __construct() {
        $this->params = "";
        $this->msg = "";
    }
}