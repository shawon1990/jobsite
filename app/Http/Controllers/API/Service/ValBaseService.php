<?php
/**
 * Created by PhpStorm.
 * User: mi
 * Date: 11/19/15
 * Time: 3:34 PM
 */

namespace App\Http\Controllers\API\Service;
use App\Http\Controllers\coreBaseClass\ServiceResponse;

use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;



class ValBaseService extends Controller
{

    public $serviceResponse;
    public $pageDate;
    /**
     * CabAdvBaseService constructor.
     */
    public function __construct()
    {
        $this->serviceResponse = new ServiceResponse();
        $this->pageDate = [];
    }
    public function response(){
        if($this->serviceResponse->responseStat->status!=false){
            $this->serviceResponse->responseStat->status=!($this->haveError());
        }
       return response()->json($this->serviceResponse);
    }
    public function setErrorMsg($param,$errMsg){
        $errorObj = new \stdClass();
        $errorObj->params =$param;
        $errorObj->msg =$errMsg;
        array_push($this->serviceResponse->responseStat->requestError,$errorObj);
    }
    public function setError($errorArray){
        $this->serviceResponse->responseStat->requestError = array_merge($this->serviceResponse->responseStat->requestError,$errorArray);
    }
    public function haveError(){
        return (count($this->serviceResponse->responseStat->requestError)>0)?true:false;
    }
    public function isSessionExpired(){
        return  ($this->serviceResponse->responseStat->isLogin)?false:true;
    }
}