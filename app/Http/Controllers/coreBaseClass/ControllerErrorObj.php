<?php
/**
 * Created by PhpStorm.
 * User: mi
 * Date: 3/11/16
 * Time: 5:11 PM
 */

namespace App\Http\Controllers\coreBaseClass;

class ControllerErrorObj{
    public $params;
    public $msg;
    function __construct() {
        $this->params = "";
        $this->msg = "";
    }
}