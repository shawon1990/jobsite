<?php
namespace App\Http\Controllers;
use App\Dao\BusinessUpdateDao;
use App\Dao\CompanyDetailsDao;
use App\Dao\CompanySubscriptionDao;
use App\Dao\CompanyTypeDao;
use App\Dao\CountryDao;
use App\Dao\EmployeeResumeDao;
use App\Dao\JobApplicationDao;
use App\Dao\JobCategoryDao;
use App\Dao\JobLevelDao;
use App\Dao\JobPostDao;
use App\Dao\JobTypeDao;
use App\Dao\RankingCodesDao;
use App\Dao\SearchDao;
use App\Dao\UserDao;
use App\Dao\UserDetailsDao;
use App\Model\CompanyTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

        $this->jobCategoryDao=new JobCategoryDao();
        $this->jobTypeDao=new JobTypeDao();
        $this->searchDao=new SearchDao();
        $this->jobPostDao=new JobPostDao();
        $this->jobLevelDao=new JobLevelDao();
        $this->companyTypeDao=new CompanyTypeDao();
        $this->userDao=new UserDao();
        $this->countryDao=new CountryDao();
        $this->companySubscriptionDao=new CompanySubscriptionDao();
        $this->oompanyDetailsDao=new CompanyDetailsDao();
        $this->jobApplicationDao=new JobApplicationDao();
        $this->employeeResumeDao=new EmployeeResumeDao();
        $this->userDetailsDao=new UserDetailsDao();
        $this->rankingCodesDao=new RankingCodesDao();
        $this->businessUpdateDao=new BusinessUpdateDao();
        $this->detect=new \Mobile_Detect();
    }
    public function index()
    {
        $jobCategories=$this->jobCategoryDao->getAllWithJobCount();

        $jobType=$this->jobTypeDao->getAll();

        $date['from']=date("Y-m-d")." 00:00:00";
        $date['to']=date("Y-m-d")." 23:59:59";
        $date['limit']=5;
        //  $recentJob=$this->jobPostDao->getByLimit($date);
        $recentJob=$this->jobPostDao->recentJobByLimit();


        /**
         * premium package
         */
        //  $activePremiumCompanyId=$this->companySubscriptionDao->getAllActiveCompanyInfo();

        $activePremiumJobPostCompanyId=$this->jobPostDao->getAllActivePremiumJobsCompanyId();

        $companyWithPremiumJobs=$this->oompanyDetailsDao->companyWithPremiumJobs($activePremiumJobPostCompanyId);
        $govtJobList=$this->jobPostDao->getAllGovtJob();
        $data['jobCategories']=$jobCategories;
        $data['jobType']=$jobType;
        $data['recentJob']=$recentJob;
        $data['companyWithPremiumJobs']=$companyWithPremiumJobs;
        $data['govtJobList']=$govtJobList;

        return view('home.index',$data);
    }



    public function findJobs(Request $request)
    {
        $jobType=$this->jobTypeDao->getAll();

        $jobCategories=$this->jobCategoryDao->getAll();

        $jobLevel=$this->jobLevelDao->getAll();

        $industryType=$this->companyTypeDao->getAll();

        $country=$this->countryDao->getAll();


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


        $date['from']=date("Y-m-d")." 00:00:00";
        $date['to']=date("Y-m-d")." 23:59:59";
        $date['limit']=5;
      //  $recentJob=$this->jobPostDao->getByLimit($date);
        $recentJob=$this->jobPostDao->recentJobByLimit();

        $data['recentJob']=$recentJob;
        $data['jobResult']=$jobResult;
        $data['jobType']=$jobType;
        $data['jobCategories']=$jobCategories;
        $data['jobLevel']=$jobLevel;
        $data['industryType']=$industryType;
        $data['country']=$country;

        return view('home.findjobs',$data);
    }

    public function findJobsWithTitle($title,Request $request)
    {
        $jobType=$this->jobTypeDao->getAll();

        $jobCategories=$this->jobCategoryDao->getAll();

        $jobLevel=$this->jobLevelDao->getAll();

        $industryType=$this->companyTypeDao->getAll();

        $country=$this->countryDao->getAll();


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


        $date['from']=date("Y-m-d")." 00:00:00";
        $date['to']=date("Y-m-d")." 23:59:59";
        $date['limit']=5;
      //  $recentJob=$this->jobPostDao->getByLimit($date);
        $recentJob=$this->jobPostDao->recentJobByLimit();

        $data['recentJob']=$recentJob;
        $data['jobResult']=$jobResult;
        $data['jobType']=$jobType;
        $data['jobCategories']=$jobCategories;
        $data['jobLevel']=$jobLevel;
        $data['industryType']=$industryType;
        $data['country']=$country;

        return view('home.findjobs',$data);
    }


    public function overseasJobs(Request $request)
    {

        $jobType=$this->jobTypeDao->getAll();

        $jobCategories=$this->jobCategoryDao->getAll();

        $jobLevel=$this->jobLevelDao->getAll();

        $industryType=$this->companyTypeDao->getAll();

        $country=$this->countryDao->getAll();


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


        $date['from']=date("Y-m-d")." 00:00:00";
        $date['to']=date("Y-m-d")." 23:59:59";
        $date['limit']=5;
        //  $recentJob=$this->jobPostDao->getByLimit($date);
        $recentJob=$this->jobPostDao->recentJobByLimit();

        $data['recentJob']=$recentJob;
        $data['jobResult']=$jobResult;
        $data['jobType']=$jobType;
        $data['jobCategories']=$jobCategories;
        $data['jobLevel']=$jobLevel;
        $data['industryType']=$industryType;
        $data['country']=$country;

        return view('home.overseas-jobs',$data);
    }


    public function womenOnlineJobs(Request $request)
    {
        $jobType=$this->jobTypeDao->getAll();

        $jobCategories=$this->jobCategoryDao->getAll();

        $jobLevel=$this->jobLevelDao->getAll();

        $industryType=$this->companyTypeDao->getAll();

        $country=$this->countryDao->getAll();


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


        $date['from']=date("Y-m-d")." 00:00:00";
        $date['to']=date("Y-m-d")." 23:59:59";
        $date['limit']=5;
        //  $recentJob=$this->jobPostDao->getByLimit($date);
        $recentJob=$this->jobPostDao->recentJobByLimit();

        $data['recentJob']=$recentJob;
        $data['jobResult']=$jobResult;
        $data['jobType']=$jobType;
        $data['jobCategories']=$jobCategories;
        $data['jobLevel']=$jobLevel;
        $data['industryType']=$industryType;
        $data['country']=$country;

        return view('home.women-online-jobs',$data);
    }


    public function handicapJobs(Request $request)
    {
        $jobType=$this->jobTypeDao->getAll();

        $jobCategories=$this->jobCategoryDao->getAll();

        $jobLevel=$this->jobLevelDao->getAll();

        $industryType=$this->companyTypeDao->getAll();

        $country=$this->countryDao->getAll();


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


        $date['from']=date("Y-m-d")." 00:00:00";
        $date['to']=date("Y-m-d")." 23:59:59";
        $date['limit']=5;
        //  $recentJob=$this->jobPostDao->getByLimit($date);
        $recentJob=$this->jobPostDao->recentJobByLimit();

        $data['recentJob']=$recentJob;
        $data['jobResult']=$jobResult;
        $data['jobType']=$jobType;
        $data['jobCategories']=$jobCategories;
        $data['jobLevel']=$jobLevel;
        $data['industryType']=$industryType;
        $data['country']=$country;

        return view('home.handicap-jobs',$data);
    }



    public function findResume(Request $request)
    {

        $jobType=$this->jobTypeDao->getAll();

        $jobCategories=$this->jobCategoryDao->getAll();

        $jobLevel=$this->jobLevelDao->getAll();

        $industryType=$this->companyTypeDao->getAll();

        $country=$this->countryDao->getAll();

       // $jobResult=$this->searchDao->searchJobByParameter($request);
        if ($request->has('searchBy'))
        {
            $data['what']=$request->searchBy;
        }
        if ($request->has('location'))
        {
            $data['where']=$request->location;
        }




        $date['from']=date("Y-m-d")." 00:00:00";
        $date['to']=date("Y-m-d")." 23:59:59";
        $date['limit']=5;
     //   $recentJob=$this->jobPostDao->getByLimit($date);
        $recentJob=$this->jobPostDao->recentJobByLimit();

        $data['recentJob']=$recentJob;
       // $data['jobResult']=$jobResult;
        $data['jobType']=$jobType;
        $data['jobCategories']=$jobCategories;
        $data['jobLevel']=$jobLevel;
        $data['industryType']=$industryType;
        $data['country']=$country;
        return view('home.findresume',$data);
    }

    public function aboutUs()
    {

        return view('home.about');
    }

    public function businessUpdate()
    {
     //   $data["businessUpdate"]=$this->businessUpdateDao->getAll();
        $data["businessUpdate"]=$this->businessUpdateDao->getWithPagination();

        return view('home.business-update',$data);
    }


    public function whyUs()
    {

        return view('home.whyus');
    }


    public function contactUs()
    {

        return view('home.contact');
    }

    public function terms()
    {

        return view('home.terms');
    }

    public function register($registerType)
    {
        $companyType=$this->companyTypeDao->getAll();
        $data['userType']=$registerType;
        $data['companyType']=$companyType;
        return view('auth.register',$data);
    }

    public function emailVerification(){
        $userVerificationCode = Input::get('emailverification');

        $findUser=$this->userDao->getByVerificationCode(trim($userVerificationCode));

        if($findUser!=''){
            $this->userDao->updateEmailStatusById($findUser->id,'1');
            $msg="Your account has been successfully verified by your email";
        }else{
            $msg="Your account is already verified";
        }

        return redirect('/')->with('msg',$msg);
    }

    public function jobDetails($jobDetails,$jobId,$companyId){

        if(Auth::check()){
           return redirect("job/view/".$jobId."/".$companyId);
        }else{
            $jobPostId=$jobId;
            $companyId=$companyId;
            $jobDetails=$this->jobPostDao->getByIdCompanyId($jobPostId,$companyId);

            $data['jobDetails']=$jobDetails;

            if($jobDetails->subscription_package_details_id==4||$jobDetails->subscription_package_details_id==5){
                return view('home.job-preview.premium',$data);
            }else{
                return view('home.job-preview.basic',$data);
            }
            //return view('home.job-preview.premium',$data);
        }


    }

    public function resumeDetails($resumeId){
        $vowels = range('a', 'z');
        $resumeInfo=$this->employeeResumeDao->findResumeById($resumeId);


//        $string="I am working in Eastern Bank Ltd and VE";
//        $yourString = str_replace($vowels, "█", strtolower($companyName[0]));

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
        if(Auth::check()){

            return redirect("employer/resume/view/".$resumeId);
        }else{
            $data['resumeInfo']=$resumeInfo;
            $data['companyName']=$companyNameArray;
            $data['replacedCompanyName']=$companyReplacedArray;

            return view('home.view_resume',$data);
        }


    }


    public function ourResume(){
        return view('home.our-resume');
    }

    public function refereeVerification($token){
        //$token="reg-JS290825118";
        $regArray=explode("-",$token);
        $regId=$regArray[1];
        $userDetails=$this->userDetailsDao->getByRegistrationId($regId);

        $resume=$this->employeeResumeDao->findResumeByUserId($userDetails->user_id);

//        if($resume->refree_ranking!=0){
//            $msg="Candidate is already verified";
//            return redirect("/")->with('msg',$msg);;
//        }


        $data["resume"]=$resume;


        if($this->detect->isMobile()){
            return view("home.referee-verification-extended",$data);
        }else{
            return view("home.referee-verification",$data);
        }


    }


    public function refereeVerificationSubmit(Request $request){
        $knowledgeTotalLength=3;
        $communicationSkillsLength=2;
        $interpersonalSkillsLength=3;
        $workSkillsLength=3;

        $knowledgeTotalValue=0;
        $communicationSkillsTotalValue=0;
        $interpersonalSkillsTotalValue=0;
        $workSkillsTotalValue=0;



        $nidNumber=$request->r_nid;
        $newvalue=0;
        $colorCode= $this->rankingCodesDao->getAll();

        for ($i=1;$i<=$knowledgeTotalLength;$i++){
            $knowledgeIndivValue=Input::get("knowledge_".$i);
            $knowledgeTotalValue+=$knowledgeIndivValue;
            $percentage=ceil($knowledgeTotalValue/$knowledgeTotalLength)* 20;

            $knowledge["category"]="Knowledge";
            $knowledge["percentage"]=$percentage;
            foreach ($colorCode as $m => $n) {
                if ($percentage >= $n->lower_percent && $percentage <= $n->higher_percent) {

                    $knowledge['ranking']=$n->id;
                }
            }

        }

        for ($i=1;$i<=$communicationSkillsLength;$i++){
            $communicationIndivValue=Input::get("communication_".$i);
            $communicationSkillsTotalValue+=$communicationIndivValue;
            $percentage=ceil(($communicationSkillsTotalValue/$communicationSkillsLength))* 20;

            $communication["category"]="Communication Skills";
            $communication["percentage"]=$percentage;

            foreach ($colorCode as $m => $n) {
                if ($percentage >= $n->lower_percent && $percentage <= $n->higher_percent) {
                    $communication['ranking']=$n->id;
                }
            }
        }

        for ($i=1;$i<=$interpersonalSkillsLength;$i++){
            $knowledgeIndivValue=Input::get("interpersonal_".$i);
            $interpersonalSkillsTotalValue+=$knowledgeIndivValue;
            $percentage=ceil(($interpersonalSkillsTotalValue/$interpersonalSkillsLength))* 20;
            $interpersonal["category"]="Interpersonal Skills";
            $interpersonal["percentage"]=$percentage;
            foreach ($colorCode as $m => $n) {
                if ($percentage >= $n->lower_percent && $percentage <= $n->higher_percent) {
                    $interpersonal['ranking']=$n->id;
                }
            }
        }

        for ($i=1;$i<=$workSkillsLength;$i++){
            $knowledgeIndivValue=Input::get("workskills_".$i);
            $workSkillsTotalValue+=$knowledgeIndivValue;
            $percentage=ceil(($workSkillsTotalValue/$workSkillsLength))* 20;
            $workSkills["category"]="Work Skills";
            $workSkills["percentage"]=ceil(($workSkillsTotalValue/$workSkillsLength))* 20;
            foreach ($colorCode as $m => $n) {
                if ($percentage >= $n->lower_percent && $percentage <= $n->higher_percent) {
                    $workSkills['ranking']=$n->id;
                }
            }
        }

        $refereeMarks=[];
        array_push($refereeMarks,$knowledge,$communication,$interpersonal,$workSkills);

        $this->employeeResumeDao->deleteResumeRankingByTypeResumeId($request->resumeId,'refree_ranking');

        foreach ($refereeMarks as $key=>$value){

            $this->employeeResumeDao->insertResumeRanking($value, $request->resumeId,"refree_ranking");
        }


        $totalPercentage=ceil(($knowledge["percentage"]+$communication["percentage"]+$interpersonal["percentage"]+$workSkills["percentage"])/4);

        $rankingCodesId=$this->rankingCodesDao->getByPercentage($totalPercentage);

        $this->employeeResumeDao->referenceNIDUpdateByResumeId($request->resumeId,$nidNumber);

        $this->employeeResumeDao->rankingUpdateByCast("refree_ranking",$rankingCodesId->id,$request->resumeId);
        $msg="Verification submitted successfully.Thanks for your time.";
        return redirect("/")->with('msg',$msg);


    }


    public function benifits(){
        return view("home.benifits");
    }


    public function webGuide(){
        return view("home.web-guide");
    }

    public function blogDetails()
    {
        return view("home.blog.blog-details");
    }
    public function blog()
    {
        return view("home.blog.blog-articles");
    }


}
