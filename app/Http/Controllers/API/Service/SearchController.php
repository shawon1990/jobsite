<?php
/**
 * Created by PhpStorm.
 * User: mi_rafi
 * Date: 6/30/17
 * Time: 7:22 PM
 */

namespace App\Http\Controllers\API\Service;


use App\Dao\CompanyDetailsDao;
use App\Dao\CompanyUsersDao;
use App\Dao\EmployeeResumeDao;
use App\Dao\JobCategoryDao;
use App\Dao\JobPostDao;
use App\Dao\SearchDao;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;



class SearchController extends Controller
{
    public function __construct()
    {
        $this->serviceResponse=new ValBaseService();
        $this->employeeResumeDao=new EmployeeResumeDao();
        $this->jobPostDao=new JobPostDao();
        $this->companyDetailsDao=new CompanyDetailsDao();
        $this->companyUsersDao=new CompanyUsersDao();
        $this->searchDao=new SearchDao();
        $this->jobCategoryDao=new JobCategoryDao();

    }



    public function createJobPost(Request $request){

        $this->jobPostDao->insertJobPost($request);
        $this->serviceResponse->serviceResponse->responseStat->status = true;
        $this->serviceResponse->serviceResponse->responseStat->msg="Job Post Created Successfully";

        return $this->serviceResponse->response();

    }

    public function partialJobSearch(Request $request){
        $jobResult=$this->searchDao->searchJobByParameter($request);
        if ($request->has('searchBy'))
        {
            $data['what']=$request->searchBy;
        }
        if ($request->has('location'))
        {
            $data['where']=$request->location;
        }
        if ($request->has('jobCategory'))
        {
            $data['searchedJobCategory']=$request->jobCategory;
        }
        if ($request->has('jobType')){
            if($request->jobType!=0){
                $data['searchedJobType']=$request->jobType;
            }
        }

        $data['jobResult']=$jobResult;

        return view('home.partial.partial-find-jobs',$data);
    }

    public function partialEmployeeJobSearch(Request $request){
        $jobResult=$this->searchDao->searchJobByParameter($request);
        if ($request->has('searchBy'))
        {
            $data['what']=$request->searchBy;
        }
        if ($request->has('location'))
        {
            $data['where']=$request->location;
        }
        if ($request->has('jobCategory'))
        {
            $data['searchedJobCategory']=$request->jobCategory;
        }
        if ($request->has('jobType')){
            if($request->jobType!=0){
                $data['searchedJobType']=$request->jobType;
            }
        }

        $data['jobResult']=$jobResult;

        return view('user.employee.partial.partial-find-jobs',$data);
    }



    public function partialResumeSearch(Request $request){
        $resumeResult=$this->searchDao->searchResumeByParameter($request);
        if ($request->has('searchBy'))
        {
            $data['what']=$request->searchBy;
        }
        if ($request->has('location'))
        {
            $data['where']=$request->location;
        }
        if ($request->has('jobCategory'))
        {
            $data['searchedJobCategory']=$request->jobCategory;
        }
        if ($request->has('jobType')){
            if($request->jobType!=0){
                $data['searchedJobType']=$request->jobType;
            }
        }
      //  return $resumeResult;
        $data['resume']=$resumeResult;

        return view('home.partial.partial-find-resume',$data);
    }

    public function searchITSkill(Request $request){
        $itSkill=$this->searchDao->findItSkillBySearch($request);

        $data['items']=$itSkill;
        $data['total_count']=sizeof($itSkill);
        $data['incomplete_results']=false;

        return $data;
    }

    public function searchCoreCompetencies(Request $request){
        $coreCompetencies=$this->searchDao->findCoreCompetenciesBySearch($request);

        $data['items']=$coreCompetencies;
        $data['total_count']=sizeof($coreCompetencies);
        $data['incomplete_results']=false;

        return $data;
    }

    public function searchInstitutionName(Request $request){
        $institutionName=$this->searchDao->findInstitutionNameBySearch($request);

        $data['items']=$institutionName;
        $data['total_count']=sizeof($institutionName);
        $data['incomplete_results']=false;

        return $data;
    }


    public function partialCandidateSuggestion(Request $request){
        $companyInfo=$this->companyUsersDao->getByUserId($request->userId);
        $activeJobCategory=$this->jobPostDao->getAllActiveJobsJobCategoryByCompanyId($companyInfo->id);
        $preferredCategoryUserId=$this->employeeResumeDao->getPreferredCategoryResumeIdByCategoryId($activeJobCategory);
        $suggestiveCandidate=$this->employeeResumeDao->findVerifiedResumeByIdArray($preferredCategoryUserId);

       // return $suggestiveCandidate;

        $data["suggestiveCandidate"]=$suggestiveCandidate;
        return view("user.employer.partial.suggestive-candidates",$data);


    }

    public function partialJobsSuggestion(Request $request){
        $resumeInfo=$this->employeeResumeDao->findResumeByUserId($request->userId);
        $preferredCategoryUserId=$this->employeeResumeDao->findOnlyPreferredJobCategory($resumeInfo->id);
        $suggestiveJob=$this->jobPostDao->getAllActiveJobsByCategoryArray($preferredCategoryUserId);


      //  $suggestiveCandidate=$this->employeeResumeDao->findVerifiedResumeByIdArray($preferredCategoryUserId);


        $data["suggestiveJob"]=$suggestiveJob;
        return view("user.employee.partial.suggestive-jobs",$data);


    }

    public function partialJobCountWithTypeCategory(Request $request){
        $jobCategories=[];
        if($request->jobCategory=="all"){
            $jobCategories=$this->jobCategoryDao->getAllWithJobCountType($request->jobType);
        }else if($request->jobCategory=='today'){
            $date['from']=date("Y-m-d")." 00:00:00";
            $date['to']=date("Y-m-d")." 23:59:59";
            $todaysJob=$this->jobPostDao->getJobCategoryByPostDate($date);

            $jobCategories=$this->jobCategoryDao->getByCategoryIdArrayWithJobCountDateType($todaysJob,$date,$request->jobType,$request->jobCategory);
        }else if($request->jobCategory=='previous'){
            $date['from']= date('Y-m-d',strtotime("-1 days"))." 00:00:00";
            $date['to']= date('Y-m-d',strtotime("-1 days"))." 23:59:59";

            $previousDaysJob=$this->jobPostDao->getJobCategoryByPostDate($date);
            $jobCategories=$this->jobCategoryDao->getByCategoryIdArrayWithJobCountDateType($previousDaysJob,$date,$request->jobType,$request->jobCategory);
        }else if($request->jobCategory=='tomorrow'){
            $date['from']= date('Y-m-d',strtotime("+1 days"));
            $date['to']= date('Y-m-d',strtotime("+1 days"));
            $tomorrowExpiredJob=$this->jobPostDao->getJobCategoryByExpiredDate($date);
            $jobCategories=$this->jobCategoryDao->getByCategoryIdArrayWithJobCountDateType($tomorrowExpiredJob,$date,$request->jobType,$request->jobCategory);
        }

        $data["jobCategories"]=$jobCategories;

        return view("home.partial.partial-job-division",$data);
    }


/**
 * admin
 */
    public function adminResumeSearch(Request $request){
        $resumeResult=$this->searchDao->searchResumeByAdmin($request);
        if ($request->has('searchBy'))
        {
            $data['what']=$request->searchBy;
        }
        if ($request->has('location'))
        {
            $data['where']=$request->location;
        }
        if ($request->has('jobCategory'))
        {
            $data['searchedJobCategory']=$request->jobCategory;
        }
        if ($request->has('jobType')){
            if($request->jobType!=0){
                $data['searchedJobType']=$request->jobType;
            }
        }
        //  return $resumeResult;
        $data['data']=$resumeResult;
        $data['recordsfiltered']=sizeof($resumeResult);

        return $data;
    }

}