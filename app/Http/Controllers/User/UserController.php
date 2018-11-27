<?php

namespace App\Http\Controllers\User;

use App\Dao\ActivityNotificationDao;
use App\Dao\CompanyDetailsDao;
use App\Dao\CompanySubscriptionDao;
use App\Dao\CompanyUsersDao;
use App\Dao\CountryDao;
use App\Dao\EmployeeResumeDao;
use App\Dao\JobApplicationDao;
use App\Dao\JobCategoryDao;
use App\Dao\JobPostDao;
use App\Dao\JobTypeDao;
use App\Dao\ManageCVCandidateDao;
use App\Dao\SystemEmailDao;
use App\Dao\UserDao;
use App\Dao\UserDetailsDao;
use App\Dao\UserImageDao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
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
        $this->userDetailsDao=new UserDetailsDao();
        $this->countryDao=new CountryDao();
        $this->jobCategoryDao=new JobCategoryDao();
        $this->jobTypeDao=new JobTypeDao();
        $this->companyUsersDao=new CompanyUsersDao();
        $this->companyDetailsDao=new CompanyDetailsDao();
        $this->userImageDao=new UserImageDao();
        $this->notificationController=new NotificationController();
        $this->companySubscriptionDao=new CompanySubscriptionDao();
        $this->jobPostDao=new JobPostDao();
        $this->systemEmailDao=new SystemEmailDao();
        $this->jobApplicationDao=new JobApplicationDao();
        $this->manageCVCandidateDao=new ManageCVCandidateDao();
        $this->employeeResumeDao=new EmployeeResumeDao();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notification=$this->notificationController->notificationByUserId();


        $userId=Auth::user()->id;
        $userDetails=$this->userDetailsDao->getByUserId($userId);
        $userImage=$this->userImageDao->findByUserId($userId);
        $data['userDetails']=$userDetails;
        $data['userImage']=$userImage;
        $data['notification']=$notification;

        if (Auth::user()->user_type=='employee'){

            $resumeInfo=$this->employeeResumeDao->findResumeByUserId(Auth::user()->id);
            $scheduleJobApplication=$this->jobApplicationDao->getJobApplicationScheduleApplicationByResumeId($resumeInfo->id);
            $scheduleCVCandidates=$this->manageCVCandidateDao->getCVCandidateScheduleApplicationByResumeId($resumeInfo->id);
            $countEmails=$this->systemEmailDao->getCountEmailsByUserId(Auth::user()->id);
            $onlineApplicationCount=$this->jobApplicationDao->getCountByResumeId($resumeInfo->id);
            $countActiveJobPost=$this->jobPostDao->getAllActiveJobs();
            $respondedJobApplication=$this->jobApplicationDao->getRespondedApplicationByResumeId($resumeInfo->id);
            $respondedCVApplication=$this->manageCVCandidateDao->getRespondedCVApplicationByResumeId($resumeInfo->id);

            $data['countEmails']=$countEmails;
            $data['scheduleJobApplication']=$scheduleJobApplication;
            $data['scheduleCVCandidates']=$scheduleCVCandidates;
            $data['onlineApplicationCount']=$onlineApplicationCount;
            $data['remainingOnlineAssessment']=$resumeInfo->remaining_online_assessment;
            $data['countActiveJobPost']=$countActiveJobPost;
            $data['respondedApplication']=$respondedJobApplication+$respondedCVApplication;
            $data['resumeInfo']=$resumeInfo;

            return view('user.employee.dashboard',$data);
        }
        elseif(Auth::user()->user_type=='employer'){


            $companyDetails=$this->companyUsersDao->getByUserId($userId);
            $companyId=$companyDetails->company_id;

            Session::put('handicapJob', $companyDetails['companyDetailsByUserId']->approval_for_handicapped_job_post);

            /**
             * Dashboard info
             */
            $countSubscription=$this->companySubscriptionDao->getAdvActivePackageCountByCompanyId($companyId);
            $countJobPost=$this->jobPostDao->getAllCountByCompanyId($companyId);
            $countActiveJobPost=$this->jobPostDao->getAllActiveJobsByCompanyId($companyId);
            $countEmails=$this->systemEmailDao->getCountEmailsByUserId(Auth::user()->id);
            $countJobApplications=$this->jobApplicationDao->getCountBycompanyId($companyId);
            $countRespondedJobApplications=$this->jobApplicationDao->getCountRespondedBycompanyId($companyId);
            $checkSubscription=$this->companySubscriptionDao->getAdvActivePackageQuantityCountByCompanyId($companyId);
            $cvPackageDetails=$this->companySubscriptionDao->getActiveCVPackageByCompanyId($companyId);
            $scheduleJobApplication=$this->jobApplicationDao->getJobApplicationScheduleApplicationByCompanyId($companyId);
            $scheduleCVCandidates=$this->manageCVCandidateDao->getCVCandidateScheduleApplicationByCompanyId($companyId);

            $data['companyDetails']=$companyDetails["companyDetailsByUserId"];
            $data['subscriptionCount']=$countSubscription;
            $data['countJobPost']=$countJobPost;
            $data['countEmails']=$countEmails;
            $data['countActiveJobPost']=$countActiveJobPost;
            $data['countJobApplications']=$countJobApplications;
            $data['countRespondedJobApplications']=$countRespondedJobApplications;
            $data['checkSubscription']=$checkSubscription;
            $data['cvPackageDetails']=$cvPackageDetails;
            $data['scheduleJobApplication']=$scheduleJobApplication;
            $data['scheduleCVCandidates']=$scheduleCVCandidates;

            return view('user.employer.dashboard',$data);
        }

    }

    public function editEmployee(){

        $userDetails=$this->employeeDetailsDao->getByUserId(Auth::user()->id);
        $country=$this->countryDao->getAll();
        $jobCategory=$this->jobCategoryDao->getAll();
        $selectedCategory=$this->employeeDetailsDao->getInterestedCategory($userDetails->id);

        $data['userDetails']=$userDetails;
        $data['country']=$country;
        $data['jobCategory']=$jobCategory;
        $data['selectedCategory']=$selectedCategory;

        return view('user.employee.edit_profile',$data);
    }

    public function updateEmployeeDetails(Request $request){

        if($request->first_name!=''&& $request->last_name!=''){

            $userId=Auth::user()->id;

            $saveUserInfo=$this->userDao->updateById($request,$userId);

            $saveUserDetails=$this->employeeDetailsDao->updateByUserId($request,$userId);

            $userDetailsId=$saveUserDetails->id;

            if(sizeof($request->category)>0){

                $findEmployeeInterestCategory=$this->employeeInterestCategoryDao->findByUserDetailsId($userDetailsId);

                foreach ($findEmployeeInterestCategory as $k=>$v){
                    $this->employeeInterestCategoryDao->deleteById($v->id);
                }

                foreach ($request->category as $k=>$v){
                   $this->employeeInterestCategoryDao->saveEmployeeInterest($v,$userDetailsId);
                }

            }

        }else{
            return redirect()->back()->withInput($request->all());
        }


        return redirect('/')->with('success','Profile updated successfully');
    }

}
