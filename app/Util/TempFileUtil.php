<?php
namespace App\Util;
use App\Model\TempFileModel;
use phpDocumentor\Reflection\File;


/**
 * Created by PhpStorm.
 * User: mi_rafi
 * Date: 7/6/17
 * Time: 11:45 AM
 */
class TempFileUtil
{
    const _tempDir = "/public/tmp-file";
  //  const _destinationDir = "/public/uploaded/employee/profileimage";

    public function moveTempFileByToken($token,$destination){
        $tempFileModel = new TempFileModel();
        $tempFile = $tempFileModel->getByToken($token);
        if($tempFile->id==0){
            throw new \Exception("Token not found");
        }
        $tmpPath = base_path().TempFileUtil::_tempDir."/".$tempFile->filePath;
        $destinationPath = base_path().$destination."/".$tempFile->filePath;

        if(file_exists($tmpPath)){
            rename($tmpPath,$destinationPath);
        }else{
            throw new IOException("No file found with this token : ".$token);
        }
        $tempFileModel->deleteByToken($token);
        return $tempFile->filePath;
    }

    public function isFileExistByToken($token){
        $tempFileModel = new TempFileModel();
        $tempFile = $tempFileModel->getByToken($token);
        if($tempFile->id==0){
            throw new \Exception("Token not found :".$token);
        }
        $tmpPath = base_path().TempFileUtil::_tempDir."/".$tempFile->filePath;

        return (file_exists($tmpPath));
    }
}