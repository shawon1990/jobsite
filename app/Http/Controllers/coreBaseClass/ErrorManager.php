<?php
/**
 * Created by IntelliJ IDEA.
 * User: omar
 * Date: 12/14/16
 * Time: 4:23 PM
 */

namespace App\Http\Controllers\coreBaseClass;


class ErrorManager{
    public $errorObj;
    /**
     * ErrorManager constructor.
     * @param $errorObj
     */
    public function __construct(){
        $this->errorObj = [];

    }
}