<?php

namespace App\Http\Controllers\User;

use App\Dao\CompanyTypeDao;


use App\Dao\JobCategoryDao;
use App\Dao\JobLevelDao;
use App\Dao\JobPostDao;
use App\Dao\JobTypeDao;
use App\Dao\SearchDao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
        $this->jobCategoryDao=new JobCategoryDao();
        $this->jobTypeDao=new JobTypeDao();
        $this->searchDao=new SearchDao();
        $this->jobPostDao=new JobPostDao();
        $this->jobLevelDao=new JobLevelDao();
        $this->companyTypeDao=new CompanyTypeDao();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function jobSearch(Request $request){
        $jobType=$this->jobTypeDao->getAll();

        $jobCategories=$this->jobCategoryDao->getAll();

        $jobLevel=$this->jobLevelDao->getAll();
        $industryType=$this->companyTypeDao->getAll();
        $jobResult=$this->searchDao->searchJobByParameter($request);


        $data['jobResult']=$jobResult;
        $data['jobType']=$jobType;
        $data['jobCategories']=$jobCategories;
        $data['jobLevel']=$jobLevel;
        $data['industryType']=$industryType;
        return view("user.employee.job.search_job",$data);
    }


    public function resumeSearch(Request $request){
        $jobType=$this->jobTypeDao->getAll();

        $jobCategories=$this->jobCategoryDao->getAll();

        $jobLevel=$this->jobLevelDao->getAll();
        $industryType=$this->companyTypeDao->getAll();
        $jobResult=$this->searchDao->searchJobByParameter($request);


        $data['jobResult']=$jobResult;
        $data['jobType']=$jobType;
        $data['jobCategories']=$jobCategories;
        $data['jobLevel']=$jobLevel;
        $data['industryType']=$industryType;
        return view("user.employer.search_resume",$data);
    }


}
