<?php

namespace App\Http\Controllers\User;

use App\Dao\CompanyDetailsDao;
use App\Dao\CompanySubscriptionDao;
use App\Dao\CompanyUsersDao;
use App\Dao\CountryDao;

use App\Dao\EmployeeResumeDao;
use App\Dao\JobCategoryDao;
use App\Dao\JobLevelDao;
use App\Dao\JobTypeDao;
use App\Dao\ManageCVCandidateDao;
use App\Dao\UserDao;
use App\Dao\UserDetailsDao;
use App\Dao\UserImageDao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class ResumeController extends Controller
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
        $this->employeeResumeDao=new EmployeeResumeDao();
        $this->jobLevel=new JobLevelDao();
        $this->jobType=new JobTypeDao();
        $this->jobCategory=new JobCategoryDao();
        $this->userImageDao=new UserImageDao();
        $this->countryDao=new CountryDao();
        $this->companyUsersDao=new CompanyUsersDao();
        $this->companySubscriptionDao=new CompanySubscriptionDao();
        $this->manageCVCandidateDao=new ManageCVCandidateDao();
        $this->detect=new \Mobile_Detect();


    }

    public function editResume(){

        $jobLevel=$this->jobLevel->getAll();
        $jobType=$this->jobType->getAll();
        $jobCategory=$this->jobCategory->getAll();
        $country=$this->countryDao->getAll();
        $softSkill=$this->employeeResumeDao->getSoftSkill();
        $getResume=$this->employeeResumeDao->findResumeByUserId(Auth::user()->id);
        $findResumePreferredJobCategoryByResumeId=$this->employeeResumeDao->findResumePreferredJobCategoryByResumeId($getResume->id);


        $data["resume"]=$getResume;
        $data["resumePreferredJobCategoryByResumeId"]=$findResumePreferredJobCategoryByResumeId;
        $data["jobLevel"]=$jobLevel;
        $data["jobType"]=$jobType;
        $data["jobCategory"]=$jobCategory;
        $data["country"]=$country;
        $data["softSkill"]=$softSkill;

        //return view('user.employee.resume.edit_resume',$data);
        if(!$this->detect->isMobile()){
            return view('user.employee.resume.edit_resume-extended',$data);
        }else{
            return view('user.employee.resume.edit_resume',$data);
        }

    }


    public function editResumeExtended(){

        $jobLevel=$this->jobLevel->getAll();
        $jobType=$this->jobType->getAll();
        $jobCategory=$this->jobCategory->getAll();
        $country=$this->countryDao->getAll();
        $softSkill=$this->employeeResumeDao->getSoftSkill();
        $getResume=$this->employeeResumeDao->findResumeByUserId(Auth::user()->id);
        $findResumePreferredJobCategoryByResumeId=$this->employeeResumeDao->findResumePreferredJobCategoryByResumeId($getResume->id);


        $data["resume"]=$getResume;
        $data["resumePreferredJobCategoryByResumeId"]=$findResumePreferredJobCategoryByResumeId;
        $data["jobLevel"]=$jobLevel;
        $data["jobType"]=$jobType;
        $data["jobCategory"]=$jobCategory;
        $data["country"]=$country;
        $data["softSkill"]=$softSkill;

        return view('user.employee.resume.edit_resume-extended',$data);
    }

    public function viewResume(){

        $resumeInfo=$this->employeeResumeDao->findResumeByUserId(Auth::user()->id);
        $resumeImage=$this->userImageDao->findByUserId(Auth::user()->id);

        $data['resumeInfo']=$resumeInfo;
        $data['userImage']=$resumeImage;

        return view('user.employee.resume.view_resume',$data);
    }

    public function employerViewResumeDetails($resumeId){

        $vowels = range('a', 'z');
        $comapnyInfo='';
        $cvPackageDetails='';
        $existingManageCandidatesName='';
        $resumeInfo=$this->employeeResumeDao->findResumeById($resumeId);

        if(Auth::user()->user_type=='employer'){
            $comapnyInfo=$this->companyUsersDao->getCompanyInfoByUserId(Auth::user()->id);
            $cvPackageDetails=$this->companySubscriptionDao->getActiveCVPackageByCompanyId($comapnyInfo->id);
            $existingManageCandidatesName=$this->manageCVCandidateDao->getAllNameByCompanyId($comapnyInfo->id);
        }

        /*
         * Senior Employee information security start
         */
        $companyNameArray=[];
        $companyReplacedArray=[];
        if($resumeInfo["resumeJobDetailsByResumeId"]->job_level==3) {
            $companyName=$this->employeeResumeDao->getAllCurrentCompanyName($resumeId);
            foreach ($companyName as $k=>$v){

                $replacedName=str_replace($vowels, "█", strtolower($v));
                $replacedWordsArray=explode(" ",$replacedName);

                $nameWordsArray=explode(" ",$v);

                foreach ($nameWordsArray as $m=>$n){
                    array_push($companyNameArray,$n);
                }
                foreach ($replacedWordsArray as $m=>$n){
                    array_push($companyReplacedArray,$n);
                }
            }



//            foreach ($companyName as $k => $v) {
//
//                $companyReplacedArray[$k] = str_replace($vowels, "█", strtolower($v));
//
//            }
//            $companyNameArray = $companyName;

        }
        /*
         * Senior Employee information security end
         */


        $data['comapnyInfo']=$comapnyInfo;
        $data['resumeInfo']=$resumeInfo;
        $data['cvPackageDetails']=$cvPackageDetails;
        $data['existingManageCandidatesName']=$existingManageCandidatesName;
        $data['companyName']=$companyNameArray;
        $data['replacedCompanyName']=$companyReplacedArray;

        return view('user.employer.view_resume',$data);
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

}
