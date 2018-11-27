<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    const _FILE_SIZE_LIMIT = 1500000;

    public function __construct()
    {

    }


   public function moveImage($file,$filePath){

       $supportedImageMime = array("image/jpeg","image/png","image/bmp");

       if($file==null){
           $data["responseStat"]=false;
           $data["responseMsg"]="No file found";
           return  $data;
       }
       $fileExtension = $file->getClientOriginalExtension();

       /**
        * File Extension
        */
       if($fileExtension==null || $fileExtension == ""){
           $data["responseStat"]=false;
           $data["responseMsg"]="No file found";
           return  $data;
       }

       /**
        * File Size
        */

       if($file->getSize()>ImageController::_FILE_SIZE_LIMIT){
           $data["responseStat"]=false;
           $data["responseMsg"]="Limit Exceed";
           return  $data;
       }

       /**
        * File Type Ony Image
        */
       if (!in_array($file->getMimeType(),$supportedImageMime)){

           $data["responseStat"]=false;
           $data["responseMsg"]="Only image file are allowed";
           return  $data;
       }
       /*= == === ==== Validation Ends ==== === == = */


       $token = time().md5(uniqid(rand(), true));

       $fileName = $token;
       $fileName.=".".$fileExtension;



       $file->move($filePath, $fileName);

       chmod($filePath.'/'.$fileName,0777);

       $data["responseStat"]=true;
       $data["responseMsg"]="Uploaded successfully";
       $data["responseData"]=$fileName;
       return  $data;


   }



    function ImageResize($filePath,$image,$w, $h)
    {


         Image::make($filePath.'/'.$image)->resize(280, 200)->insert($filePath.'/watermark.png');
    }


    public function imageResizeDev(){
        //476*120
        $img = Image::make(public_path().'/logos.png');

        $img->resize(250, 250);

      //  $img->insert(public_path().'/watermark.png');
        $img->save(public_path().'/logos.png');
    }

    public function removeImage($file){
        if(file_exists($file)){
            unlink($file);

        }

        return true;
    }
}
