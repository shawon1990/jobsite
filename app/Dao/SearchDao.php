<?php
namespace App\Dao;


use App\Model\EmployeeResumeModel;
use App\Model\JobPostModel;
use App\Model\ResumeAcademicSummaryModel;
use App\Model\ResumeItSkillModel;
use App\Model\ResumeSkillModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SearchDao extends Controller
{
    public function searchJobByParameter(Request $request){

        $jobs=JobPostModel::query();

        if ($request->has('jobCategory'))
        {
            $jobs->where('category_id',$request->jobCategory);
        }

        if ($request->has('industryType')){
            if($request->industryType!=0){

                $jobs->where('industry_type',$request->industryType);
            }
        }

        if ($request->has('jobExperienceFrom') && $request->has('jobExperienceTo')){
            if($request->jobExperienceTo!=0){
                $jobs->where('experience_from','<=',$request->jobExperienceTo);
                $jobs->where('experience_to','>=',$request->jobExperienceFrom);

            }
        }

        if ($request->has('jobPublishedStartDate') && $request->has('jobPublishedEndDate')){
            if($request->jobPublishedStartDate!='' && $request->jobPublishedEndDate!=''){
                $jobs->whereBetween('created_at', [$request->jobPublishedStartDate, $request->jobPublishedEndDate]);
            }
        }

        if ($request->has('jobDeadlineStartDate') && $request->has('jobDeadlineEndDate')){
            if($request->jobDeadlineStartDate!='' && $request->jobDeadlineEndDate!=''){
                $jobs->whereBetween('application_deadline', [$request->jobDeadlineStartDate, $request->jobDeadlineEndDate]);
            }else{
                $jobs->where('application_deadline','>=',date('Y-m-d'));
            }
        }else{

            $jobs->where('application_deadline','>=',date('Y-m-d'));
        }

        if ($request->has('jobTypeArray')){
            if(sizeof($request->jobTypeArray)>0){
                $jobs->whereIn('job_type_id', $request->jobTypeArray);
            }
        }

        if ($request->has('jobGender'))
        {
            if($request->jobGender=='female'){
                $jobs->where('gender','!=',"male");
            }else if($request->jobGender=='male'){
                $jobs->where('gender','!=',"female");
            }else{
                $jobs->where('gender','!=',"");
            }

        }

        if ($request->has('country') && $request->country!=0)
        {
            $jobs->where('country_id',$request->country);
        }

        if ($request->has('exceptCountry'))
        {
            $jobs->where('country_id','!=',$request->exceptCountry);
        }

        if ($request->has('searchBy'))
        {
            $jobs->where('job_title',"like","%".$request->searchBy."%");

           // $jobs->orWhere('qualification_skills',"like","%".$request->searchBy."%");
        }
        if ($request->has('location'))
        {
            $jobs->where('job_location',"like","%".$request->location."%");
        }

        if ($request->has('handicappedJob'))
        {
            $jobs->where('handicapped_job',$request->handicappedJob);
        }

        return $jobs->with("jobTypeNameById","jobCategoryNameById","companyInfo")->orderBy('id', 'desc')->paginate(5);
    }






    public function searchResumeByParameter(Request $request){

        $resume=EmployeeResumeModel::query();
        $resume->select("employee_resume.*","resume_job_details.soft_skill","resume_job_details.job_level","resume_academic_summary.level_of_education","resume_academic_summary.degree_title","resume_academic_summary.year_of_passing","resume_academic_summary.institute_name","resume_academic_summary.major","user_details.registration_number");
        $resume->leftjoin('resume_job_details','employee_resume.id', '=','resume_job_details.resume_id' );
        $resume->leftjoin('resume_academic_summary','employee_resume.id', '=','resume_academic_summary.resume_id' );

        $resume->leftjoin('user_details','employee_resume.user_id', '=','user_details.user_id');
        $resume->where('resume_academic_summary.preview_status',1);

        if ($request->has('jobLevelArray'))
        {
            $resume->whereIn('resume_job_details.job_level',$request->jobLevelArray);
        }
        if ($request->has('jobTypeArray'))
        {
            $resume->whereIn('resume_job_details.job_type',$request->jobTypeArray);
        }

        if ($request->has('jobGender'))
        {
            if($request->jobGender=='female'){
                $resume->where('employee_resume.gender','!=',"male");
            }else if($request->jobGender=='male'){
                $resume->where('employee_resume.gender','!=',"female");
            }else{
                $resume->where('employee_resume.gender','!=',"");
            }
        }
        if ($request->has('jobCategory'))
        {
            $resume->leftjoin('resume_preferred_job_category','employee_resume.id', '=','resume_preferred_job_category.resume_id' );
            $resume->where('resume_preferred_job_category.preferred_job_category',$request->jobCategory);
        }
        if ($request->has('educationArray'))
        {
            $resume->whereIn('resume_academic_summary.level_of_education',$request->educationArray);
        }
        if ($request->has('resumeItSkill'))
        {
            $resume->leftjoin('resume_it_skills','employee_resume.id', '=','resume_it_skills.resume_id');
            $resume->where("resume_it_skills.skill_name","like","%".$request->resumeItSkill."%");
        }
        if ($request->has('resumeCoreCompetency'))
        {
            $resume->leftjoin('resume_skills','employee_resume.id', '=','resume_skills.resume_id');
            $resume->where("resume_skills.skill_name","like","%".$request->resumeCoreCompetency."%");
        }
        if ($request->has('resumeInstitutionName'))
        {
            $resume->where("resume_academic_summary.institute_name","like","%".$request->resumeInstitutionName."%");
        }

        if ($request->has('searchBy'))
        {
            if($request->searchBy!=''){
            $resume->where("resume_academic_summary.major","like","%".$request->searchBy."%");

            $resume->orWhere("user_details.registration_number","like","%".$request->searchBy."%");
        }

          //  $resume->where('job_title',"like","%".$request->searchBy."%");
           // $resume->orWhere('qualification_skills',"like","%".$request->searchBy."%");
        }

        if ($request->has('country') && $request->country!=0)
        {
            $resume->where('employee_resume.country_id',$request->country);
        }
        if ($request->has('location'))
        {
            if($request->location!=''){
                $resume->where("employee_resume.current_location","like","%".$request->location."%");
            }
           // $resume->where('job_location',"like","%".$request->location."%");
        }
       // $resume->where("employee_resume.online_assessment","!=",0);
        $resume->where("employee_resume.interview_ranking",">",1);
        $resume->where('employee_resume.looking_for_job',"yes");

        return $resume->with("resumeCoreSkillByResumeId","resumeItSkillByResumeId","resumeWorkExperienceByResumeId")->orderBy('employee_resume.id', 'desc')->groupBy('employee_resume.id')->paginate(5);
    }


    public function findItSkillBySearch(Request $request){
        $itSkill=ResumeItSkillModel::where("skill_name","like","%".$request->q."%")->groupBy('skill_name')->get();
        return $itSkill;
    }
    public function findCoreCompetenciesBySearch(Request $request){
        $coreCompetencies=ResumeSkillModel::where("skill_name","like","%".$request->q."%")->groupBy('skill_name')->get();
        return $coreCompetencies;
    }
    public function findInstitutionNameBySearch(Request $request){
        $InstitutionName=ResumeAcademicSummaryModel::where("institute_name","like","%".$request->q."%")->groupBy('institute_name')->get();
        return $InstitutionName;
    }


    /**
     * Admin
     */

    public function searchResumeByAdmin(Request $request){

        $resume=EmployeeResumeModel::query();
        $resume->select("employee_resume.*","users.email as userEmail","resume_job_details.soft_skill","resume_academic_summary.level_of_education","resume_academic_summary.degree_title","resume_academic_summary.year_of_passing","resume_academic_summary.institute_name","resume_academic_summary.major","user_details.registration_number");
        $resume->leftjoin('resume_job_details','employee_resume.id', '=','resume_job_details.resume_id' );
        $resume->leftjoin('resume_academic_summary','employee_resume.id', '=','resume_academic_summary.resume_id' );
        $resume->leftjoin('resume_preferred_job_category','employee_resume.id', '=','resume_preferred_job_category.resume_id' );
        $resume->leftjoin('resume_it_skills','employee_resume.id', '=','resume_it_skills.resume_id');
        $resume->leftjoin('resume_skills','employee_resume.id', '=','resume_skills.resume_id');
        $resume->leftjoin('user_details','employee_resume.user_id', '=','user_details.user_id');
        $resume->leftjoin('users','employee_resume.user_id', '=','users.id');
        $resume->where('resume_academic_summary.preview_status',1);

        if ($request->has('jobLevelArray'))
        {
            $resume->whereIn('resume_job_details.job_level',$request->jobLevelArray);
        }
        if ($request->has('jobTypeArray'))
        {
            $resume->whereIn('resume_job_details.job_type',$request->jobTypeArray);
        }

        if ($request->has('jobGender'))
        {
            if($request->jobGender=='female'){
                $resume->where('employee_resume.gender','!=',"male");
            }else if($request->jobGender=='male'){
                $resume->where('employee_resume.gender','!=',"female");
            }else{
                $resume->where('employee_resume.gender','!=',"");
            }
        }
        if ($request->has('jobCategory'))
        {
            $resume->where('resume_preferred_job_category.preferred_job_category',$request->jobCategory);
        }
        if ($request->has('educationArray'))
        {
            $resume->whereIn('resume_academic_summary.level_of_education',$request->educationArray);
        }
        if ($request->has('resumeItSkill'))
        {
            $resume->where("resume_it_skills.skill_name","like","%".$request->resumeItSkill."%");
        }
        if ($request->has('resumeCoreCompetency'))
        {
            $resume->where("resume_skills.skill_name","like","%".$request->resumeCoreCompetency."%");
        }
        if ($request->has('resumeInstitutionName'))
        {
            $resume->where("resume_academic_summary.institute_name","like","%".$request->resumeInstitutionName."%");
        }

        if ($request->has('searchBy'))
        {
            if($request->searchBy!=''){
                $resume->where("resume_academic_summary.major","like","%".$request->searchBy."%");

                $resume->orWhere("user_details.registration_number","like","%".$request->searchBy."%");
            }

            //  $resume->where('job_title',"like","%".$request->searchBy."%");
            // $resume->orWhere('qualification_skills',"like","%".$request->searchBy."%");
        }

        if ($request->has('country') && $request->country!=0)
        {
            $resume->where('employee_resume.country_id',$request->country);
        }
        if ($request->has('location'))
        {
            if($request->location!=''){
                $resume->where("employee_resume.current_location","like","%".$request->location."%");
            }
            // $resume->where('job_location',"like","%".$request->location."%");
        }
        // $resume->where("employee_resume.online_assessment","!=",0);
        $resume->where("employee_resume.interview_ranking",">",1);
        $resume->where('employee_resume.looking_for_job',"yes");


        return $resume->with("resumeCoreSkillByResumeId","resumeItSkillByResumeId","resumeWorkExperienceByResumeId")->orderBy('employee_resume.id', 'desc')->groupBy('employee_resume.id')->get();


    }




    public function searchResumeWithUserDetails(Request $request){

        $resume=EmployeeResumeModel::query();
        $resume->select("employee_resume.*","users.*","user_details.registration_number","admins.name");
        $resume->leftjoin('users','employee_resume.user_id', '=','users.id' );
        $resume->leftjoin('user_details','employee_resume.user_id', '=','user_details.user_id');
        $resume->leftjoin('admins','employee_resume.interview_assigned_to', '=','admins.id');

        if ($request->rankingTypeCheckbox=='incomplete'){
            if(sizeof($request->resumeRankingType)>0){
                foreach ($request->resumeRankingType as $k=>$v){
                    $resume->where("employee_resume.".$v,"<=",1);
                }
            }
        }elseif ($request->rankingTypeCheckbox=='complete'){
            if(sizeof($request->resumeRankingType)>0){
                foreach ($request->resumeRankingType as $k=>$v){
                    $resume->where("employee_resume.".$v,">",1);
                }
            }
        }

        if($request->resumeEmailVerification!=''){
            $resume->where("users.email_verification",$request->resumeEmailVerification);
        }

        if($request->resumeStatus!='all'){
            $resume->where('employee_resume.status',$request->resumeStatus);
        }

        if($request->resumeLookingForjob!=''){
            $resume->where("employee_resume.looking_for_job",$request->resumeLookingForjob);
        }


        if($request->resumeStatus=='all') {
            if ($request->search['value'] != '') {
                $resume->where("users.email", "like", "%" . $request->search['value'] . "%");
                $resume->orWhere("user_details.registration_number", "like", "%" . $request->search['value'] . "%");
            }
        }


        if($request->resumeStatus!='all'){
            return $resume->orderBy('employee_resume.id', 'desc')->groupBy('employee_resume.id')->get();
        }else{
            return $resume->orderBy('employee_resume.id', $request->order[0]['dir'])->groupBy('employee_resume.id')->skip($request->start)->take($request->length)->get();
        }

    }


    public function getResumeCount(Request $request){

        $resume=EmployeeResumeModel::query();
        $resume->select("employee_resume.*","users.*","user_details.registration_number","admins.name");
        $resume->leftjoin('users','employee_resume.user_id', '=','users.id' );
        $resume->leftjoin('user_details','employee_resume.user_id', '=','user_details.user_id');
        $resume->leftjoin('admins','employee_resume.interview_assigned_to', '=','admins.id');

        if ($request->rankingTypeCheckbox=='incomplete'){
            if(sizeof($request->resumeRankingType)>0){
                foreach ($request->resumeRankingType as $k=>$v){
                    $resume->where("employee_resume.".$v,"<=",1);
                }
            }
        }elseif ($request->rankingTypeCheckbox=='complete'){
            if(sizeof($request->resumeRankingType)>0){
                foreach ($request->resumeRankingType as $k=>$v){
                    $resume->where("employee_resume.".$v,">",1);
                }
            }
        }

        if($request->resumeEmailVerification!=''){
            $resume->where("users.email_verification",$request->resumeEmailVerification);
        }

        if($request->resumeStatus!='all'){
            $resume->where('employee_resume.status',$request->resumeStatus);
        }

        if($request->resumeLookingForjob!=''){
            $resume->where("employee_resume.looking_for_job",$request->resumeLookingForjob);
        }


        if($request->resumeStatus=='all') {
            if ($request->search['value'] != '') {
                $resume->where("users.email", "like", "%" . $request->search['value'] . "%");
                $resume->orWhere("user_details.registration_number", "like", "%" . $request->search['value'] . "%");
                $resume->orWhere("user_details.first_name", "like", "%" . $request->search['value'] . "%");
                $resume->orWhere("user_details.last_name", "like", "%" . $request->search['value'] . "%");
            }
        }

        return $resume->count('employee_resume.id');
    }



}


?>