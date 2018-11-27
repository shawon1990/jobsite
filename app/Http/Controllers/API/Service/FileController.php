<?php
/**
 * Created by PhpStorm.
 * User: mi_rafi
 * Date: 6/30/17
 * Time: 7:22 PM
 */

namespace App\Http\Controllers\API\Service;


use App\Dao\ResumeImageDao;
use App\Http\Controllers\Controller;
use App\Model\TempFileModel;
use App\Util\TempFileUtil;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class FileController extends Controller
{
    public function __construct()
    {
        $this->serviceResponse=new ValBaseService();
        $this->resumeImageDao=new ResumeImageDao();
    }

    const _FILE_SIZE_LIMIT = 1500000;

    public function saveTempProfileImage(Request $request){

        $supportedImageMime = array("image/jpeg","image/png","image/bmp");
        /*= == === ==== Validation Started ==== === == = */
        /**
         * File Existence
         */
        $file = $request->file("advtImg");
        if($file==''){
            $file = $request->file("profileImg");
        }
        if($file==null){
            $this->serviceResponse->serviceResponse->responseStat->status = false;
            $this->serviceResponse->responseStat->msg = "No file found";
            return  $this->serviceResponse->response();
        }
        $fileExtension = $file->getClientOriginalExtension();

        /**
         * File Extension
         */
        if($fileExtension==null || $fileExtension == ""){
            $this->serviceResponse->serviceResponse->responseStat->status = false;
            $this->serviceResponse->serviceResponse->responseStat->msg = "No file found";
            return  $this->serviceResponse->response();
        }

        /**
         * File Size
         */

        if($file->getSize()>FileController::_FILE_SIZE_LIMIT){
            $this->serviceResponse->serviceResponse->responseStat->status = false;
            $this->serviceResponse->serviceResponse->responseStat->msg = "File size exceeds limit 1.5MB";
            return  $this->serviceResponse->response();
        }

        /**
         * File Type Ony Image
         */
        if (!in_array($file->getMimeType(),$supportedImageMime)){
            $this->serviceResponse->serviceResponse->responseStat->status = false;
            $this->serviceResponse->serviceResponse->responseStat->msg = "Only image file are allowed";
            $this->serviceResponse->serviceResponse->responseData = $file->getSize();
            return  $this->serviceResponse->response();
        }
        /*= == === ==== Validation Ends ==== === == = */


        $token = time().md5(uniqid(rand(), true));

        $fileName = $token;
        $fileName.=".".$fileExtension;
        $filePath = base_path() . '/public/tmp-file';
        $file->move($filePath, $fileName);

        chmod($filePath.'/'.$fileName,0777);

        $tempFileModel = new TempFileModel();
        $tempFileModel->token = $token;
        $tempFileModel->file_path = $fileName;

        $tempFileModel->save();

        $this->serviceResponse->serviceResponse->responseData = $tempFileModel->token;
        return  $this->serviceResponse->response();
    }


    public function removeProfilePicTempImage(Request $request)
    {


        $token = $request->input("token");

        $tempFile=TempFileModel::where('token',$token)->first();


        if($tempFile!=''){
            $file = public_path()."/tmp-file/".$tempFile->file_path;

            if($tempFile->delete())
            {
                if(file_exists($file)){
                    unlink($file);
                    $this->serviceResponse->serviceResponse->responseStat->status = true;
                    $this->serviceResponse->serviceResponse->responseStat->msg="Successfully Removed";
                    return $this->serviceResponse->response();
                }else{
                    $this->serviceResponse->serviceResponse->responseStat->status = false;
                    $this->serviceResponse->serviceResponse->responseStat->msg="Deleted successfully but file not found";
                    return $this->serviceResponse->response();
                }


            }else{
                $this->serviceResponse->serviceResponse->responseStat->status = FALSE;
                $this->serviceResponse->serviceResponse->responseStat->msg="Failed to Remove";
                return $this->serviceResponse->response();
            }
        }else{
            $this->serviceResponse->serviceResponse->responseStat->status = FALSE;
            $this->serviceResponse->serviceResponse->responseStat->msg="Invalid Request. No record found";
            return $this->serviceResponse->response();
        }

    }

    public function saveImageByToken(Request $request){
        $token=$request->imageToken;
        $destination="/public/uploaded/resume-image";
        $userId=$request->userId;
        $file=$this->moveTempFileByToken($token,$destination);
//        echo "<pre>";
//        print_r($destination.'/'.$file);

       // $this->resizeImage(public_path().'/uploaded/resume-image/'.$file,144,160);

        if($request->imageType=='resume'){
            $saveImage=$this->resumeImageDao->saveOrUpdateResumeImageByResumeId($file,$request->resumeId);
        }


        $this->serviceResponse->serviceResponse->responseStat->status = true;
        $this->serviceResponse->serviceResponse->responseStat->msg="Image saved successfully";

        return $this->serviceResponse->response();
    }

    public function moveTempFileByToken($token,$destination){

        $tempDir="/public/tmp-file";
        $tempFileModel = new TempFileModel();
        $tempFile = $tempFileModel->getByToken($token);

        if($tempFile->id==0){
            throw new \Exception("Token not found");
        }
        $tmpPath = base_path().$tempDir."/".$tempFile->file_path;
        $destinationPath = base_path().$destination."/".$tempFile->file_path;

        if(file_exists($tmpPath)){
            rename($tmpPath,$destinationPath);
        }else{
            throw new IOException("No file found with this token : ".$token);
        }
        $tempFileModel->deleteByToken($token);

        return $tempFile->file_path;
    }

    public function resizeImage($filepath,$w,$h){
        $img = Image::make($filepath);
        $img->resize($w, $h);
        $img->save($filepath);

        return true;
    }



//    public function getResumeImageByResumeId(Request $request){
//        $userId=$request->userId;
//
//        $userImage=$this->resumeImageDao->getByResumeId($userId,"profile");
//
//        return $userImage;
//    }
}