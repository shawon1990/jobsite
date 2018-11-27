<?php

namespace App\Http\Controllers\User;

use App\Dao\CountryDao;
use App\Dao\EmployeeDetailsDao;
use App\Dao\EmployerDetailsDao;
use App\Dao\ResumeImageDao;
use App\Dao\UserDao;
use App\Model\ImageModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->userDao=new UserDao();
        $this->countryDao=new CountryDao();
        $this->imageDao=new ResumeImageDao();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadEmployeeProfileImage(Request $request){

        $imageData=json_decode($request->profileImage);
        $userId=$request->userId;


        list($type, $imageData) = explode(';', $imageData);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);

        $fileName = $userId."profile".'.'.$extension;

        $imageData = base64_decode($imageData);
        $path=public_path().'/uploaded/employee/profileImage/'.$fileName;
        file_put_contents($path, $imageData);

        $updateEmployeeProfile=$this->imageDao->saveOrUpdateProfileImageByUserId($fileName,$userId,'profilepic');




        return $updateEmployeeProfile;

    }


}
