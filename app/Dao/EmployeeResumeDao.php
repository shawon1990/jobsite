<?php
/**
 * Created by PhpStorm.
 * User: shawo
 * Date: 10/8/2017
 * Time: 3:30 PM
 */
namespace App\Dao;

use App\Admin;
use App\Model\EmployeeResumeModel;
use App\Model\ResumeAcademicProjectModel;
use App\Model\ResumeAcademicSummaryModel;
use App\Model\ResumeExtraCurricularActivitiesModel;
use App\Model\ResumeItSkillModel;
use App\Model\ResumeJobDetailsModel;
use App\Model\ResumeKeyWordSearchModel;
use App\Model\ResumePreferredJobCategoryModel;
use App\Model\ResumeRankingModel;
use App\Model\ResumeReferenceModel;
use App\Model\ResumeSkillModel;
use App\Model\ResumeSocialInfoModel;
use App\Model\ResumeTrainingCertificationModel;
use App\Model\ResumeWorkExperienceModel;
use App\Model\SoftSkillModel;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeResumeDao extends Controller
{

    public function getSoftSkill(){
        return SoftSkillModel::all();
    }

    public function findResumeById($id){
        $findResume=EmployeeResumeModel::where("id",$id)->with("userDetailsByUserId","resumeJobDetailsByResumeId","resumePreferredJobCategoryByResumeId",
            "resumeTrainingCertificationByResumeId","resumeAcademicSummaryByResumeId","resumeWorkExperienceByResumeId","resumeReferenceByResumeId","resumeCoreSkillByResumeId","resumeItSkillByResumeId","resumeImageByResumeId","onlineAssessmentRankingCodes","interviewRankingRankingCodes","refreeRankingRankingCodes","resumeSocialInfo","resumeAcademicProjectByResumeId","resumeExtraCurricularActivitiesByResumeId","getSubCategoryDetails","getSubCategoryDetails.getCategory","getSubCategoryDetails.getCategory.getLevel")->first();

        return $findResume;
    }

    public function findResumeByUserId($userId){
        $findResume=EmployeeResumeModel::where("user_id",$userId)->with("userDetailsByUserId","resumeJobDetailsByResumeId","resumeJobDetailsByResumeId.resumeJobLevel","resumeJobDetailsByResumeId.resumeJobType","resumePreferredJobCategoryByResumeId",
            "resumeTrainingCertificationByResumeId","resumeAcademicSummaryByResumeId","resumeWorkExperienceByResumeId","resumeReferenceByResumeId","resumeCoreSkillByResumeId","resumeItSkillByResumeId","resumeImageByResumeId","onlineAssessmentRankingCodes","interviewRankingRankingCodes","refreeRankingRankingCodes","resumeSocialInfo","resumeAcademicProjectByResumeId","interviewRankingDetails","refereeRankingDetails","onlineAssessmentRankingDetails","resumeExtraCurricularActivitiesByResumeId","getSubCategoryDetails","getSubCategoryDetails.getCategory","getSubCategoryDetails.getCategory.getLevel")->first();

        return $findResume;
    }

    public function findResumePreferredJobCategoryByResumeId($resumeId){
        $findResumePreferredJobCategoryByResumeId=ResumePreferredJobCategoryModel::where("resume_id",$resumeId)->pluck("preferred_job_category")->toArray();

        return $findResumePreferredJobCategoryByResumeId;
    }

    public function checkRankingByUserId($userId){
        $checkRankingByUserId=EmployeeResumeModel::where("user_id",$userId)
                                                ->where("online_assessment","!=",0)
                                                ->where("interview_ranking","!=",0)
                                                ->where("refree_ranking","!=",0)
                                                ->first();


        return $checkRankingByUserId;
    }

    public function getAllRankingByUserId($userId){
        $checkRankingByUserId=EmployeeResumeModel::select('interview_ranking','online_assessment','refree_ranking')->where("user_id",$userId)->first();


        return $checkRankingByUserId;
    }

    public function insert($resumeDetails){
        $saveBasic=new EmployeeResumeModel();
        $saveBasic->first_name=$resumeDetails['first_name'];
        $saveBasic->last_name=$resumeDetails['last_name'];
        $saveBasic->user_id=$resumeDetails['user_id'];

        $saveBasic->save();

        return $saveBasic;
    }

    public function updateJobLookingStatus(Request $request){
        $updateBasic=EmployeeResumeModel::where("user_id",$request->userId)->first();
        $updateBasic->looking_for_job=$request->lookingForJob;
        return $updateBasic->save();
    }

    public function updateResumeStatus($request){
        $updateBasic=EmployeeResumeModel::where("id",$request->resumeId)->first();
        $updateBasic->status=$request->status;
        return $updateBasic->save();
    }

    public function updateResumeComment($request){
        $updateBasic=EmployeeResumeModel::where("id",$request->resumeId)->first();
        $updateBasic->comments=$request->comment;
        return $updateBasic->save();
    }

    public function updateResumeSearchingKeyword($data){

        return ResumeKeyWordSearchModel::insert($data);
    }


    public function deleteResumeSearchKeyWord($keywords){

        ResumeKeyWordSearchModel::whereIn('id', $keywords)->delete();

        return true;
    }

    public function findResumeSearchingKeywordsByColumn($resumeId,$column){
        return ResumeKeyWordSearchModel::where('resume_id',$resumeId)->pluck($column)->toArray();
    }




    public function updateBasic(Request $request,$languageProficiency){

        $updateBasic=EmployeeResumeModel::find($request->resumeId);
        $updateBasic->first_name=$request->firstName;
        $updateBasic->middle_name=$request->middleName;
        $updateBasic->last_name=$request->lastName;
        $updateBasic->dob=$request->dob;
        $updateBasic->gender=$request->gender;
        $updateBasic->religion=$request->religion;
        $updateBasic->marital_status=$request->maritalStatus;
        $updateBasic->nationality=$request->nationality;
        $updateBasic->nid_number=$request->nidNumber;
        $updateBasic->present_address=$request->presentAddress;
        $updateBasic->permanent_address=$request->permanentAddress;
        $updateBasic->current_location=$request->currentLocation;
        $updateBasic->country_id=$request->resumeCountry;
        $updateBasic->phone_code=$request->phoneCode;
        $updateBasic->phone=$request->phone;
        $updateBasic->email=$request->email;
        $updateBasic->alternative_email=$request->alternativeEmail;
        $updateBasic->language_proficiency=$languageProficiency;


        $updateBasic->save();

        return $updateBasic;
    }


    /*
     * preferred Job start
     */
    public function findResumeJobDetails($resumeId){

        $resumeJobDetails=ResumeJobDetailsModel::where('resume_id',$resumeId)->first();

        return $resumeJobDetails;
    }

    public function insertResumeJobDetails(Request $request){
        $saveResumeJobDetails=new ResumeJobDetailsModel();
        $saveResumeJobDetails->resume_id=$request->resumeId;
        $saveResumeJobDetails->job_level=$request->jobLevel;
        $saveResumeJobDetails->job_type=$request->jobType;
        $saveResumeJobDetails->preferred_organization_type=$request->preferredOrganizationType;
        $saveResumeJobDetails->soft_skill=$this->findSoftSkillFormattedData($request->softSkill);
        $saveResumeJobDetails->career_objective=$request->careerObjective;
        $saveResumeJobDetails->job_summary=$request->jobSummary;

        $saveResumeJobDetails->save();

        return $saveResumeJobDetails;
    }
    public function findSoftSkillFormattedData($softSkill){
        if($softSkill!='') {
            $softSkill=serialize($softSkill);
        }else{
            $softSkill='';
        }

        return $softSkill;
    }
    public function updateResumeJobDetails(Request $request){
        $updateResumeJobDetails=ResumeJobDetailsModel::where('resume_id',$request->resumeId)->first();
        $updateResumeJobDetails->job_level=$request->jobLevel;
        $updateResumeJobDetails->job_type=$request->jobType;
        $updateResumeJobDetails->preferred_organization_type=$request->preferredOrganizationType;
        $updateResumeJobDetails->soft_skill=$this->findSoftSkillFormattedData($request->softSkill);
        $updateResumeJobDetails->career_objective=trim($request->careerObjective);
        $updateResumeJobDetails->job_summary=trim($request->jobSummary);

        $updateResumeJobDetails->save();

        return $updateResumeJobDetails;
    }


    public function insertPreferredJobCategory($preferredJobCategory){
        $savePreferredJobCategory=new ResumePreferredJobCategoryModel();
        $savePreferredJobCategory->preferred_job_category=$preferredJobCategory['preferred_job_category'];
        $savePreferredJobCategory->resume_id=$preferredJobCategory['resume_id'];

        $savePreferredJobCategory->save();

        return $savePreferredJobCategory;
    }

    public function findPreferredJobCategory($resumeId){
        $preferredJobCategory=ResumePreferredJobCategoryModel::where("resume_id",$resumeId)->get();
        return $preferredJobCategory;
    }

    public function findOnlyPreferredJobCategory($resumeId){
        $preferredJobCategory=ResumePreferredJobCategoryModel::where("resume_id",$resumeId)->pluck("preferred_job_category");
        return $preferredJobCategory;
    }

    public function deletePreferredJobCategory($id){
        $preferredJobCategory=ResumePreferredJobCategoryModel::find($id);
        $preferredJobCategory->delete();

        return true;
    }

    /*
         * preferred Job end
         */

    public function insertReference(Request $request){
        $saveReference=new ResumeReferenceModel();
        $saveReference->reference_name=$request->referenceName;
        $saveReference->reference_designation=$request->referenceDesignation;
        $saveReference->reference_mobile=$request->referenceMobile;
        $saveReference->reference_email=$request->referenceEmail;
        $saveReference->reference_relationship=$request->referenceRelationship;
        $saveReference->reference_organization=$request->referenceOrganization;
        $saveReference->country_code=$request->referenceCountryCode;

        $saveReference->save();

        return $saveReference;
    }

    public function updateReference(Request $request){
        $saveReference=ResumeReferenceModel::where('resume_id',$request->resume_id);
        $saveReference->reference_name=$request->referenceName;
        $saveReference->reference_designation=$request->referenceDesignation;
        $saveReference->reference_mobile=$request->referenceMobile;
        $saveReference->reference_email=$request->referenceEmail;
        $saveReference->reference_relationship=$request->referenceRelationship;
        $saveReference->reference_organization=$request->referenceOrganization;
        $saveReference->country_code=$request->referenceCountryCode;

        $saveReference->save();

        return $saveReference;
    }




/*
 * resume experience start
 */
    public function findResumeExperience($resumeId){
        $resumeExperience=ResumeWorkExperienceModel::where("resume_id",$resumeId)->get();
        return $resumeExperience;
    }

    public function deleteResumeExperience($id){
        $resumeExperience=ResumeWorkExperienceModel::find($id);
        $resumeExperience->delete();

        return true;
    }

    public function insertResumeWorkExperience($workExperience){

        $saveWorkExperience=new ResumeWorkExperienceModel();
        $saveWorkExperience->job_title=$workExperience["job_title"];
        $saveWorkExperience->company_name=$workExperience["company_name"];
        $saveWorkExperience->company_business=$workExperience["company_business"];
        $saveWorkExperience->department=$workExperience["department"];
        $saveWorkExperience->area_of_experiences=$workExperience["area_of_experiences"];
        $saveWorkExperience->responsibilities=$workExperience["responsibilities"];
        $saveWorkExperience->achievements=$workExperience["achievements"];
        $saveWorkExperience->company_location=$workExperience["company_location"];
        $saveWorkExperience->employment_period=$workExperience["employment_period"];
        $saveWorkExperience->total_experience=$workExperience["total_experience"];
        $saveWorkExperience->resume_id=$workExperience["resume_id"];
        $saveWorkExperience->currently_working=$workExperience["currently_working"];

        $saveWorkExperience->save();

        return $saveWorkExperience;

    }

    public function getAllCurrentCompanyName($resumeId){
        return ResumeWorkExperienceModel::where('resume_id',$resumeId)->where('currently_working',1)->pluck('company_name')->toArray();


    }
    /*
 * resume experience end
 */
    
/*
     * Training start
     */
    public function findResumeTrainingCertification($resumeId){
        $resumeTrainingCertification=ResumeTrainingCertificationModel::where("resume_id",$resumeId)->get();
        return $resumeTrainingCertification;
    }

    public function deleteResumeTrainingCertification($id){
        $resumeTrainingCertification=ResumeTrainingCertificationModel::find($id);
        $resumeTrainingCertification->delete();

        return true;
    }
    public function insertResumeTrainingCertification($trainingCertification){
        $saveTrainingCertification=new ResumeTrainingCertificationModel();
        $saveTrainingCertification->trainining_title=$trainingCertification["trainining_title"];
        $saveTrainingCertification->institute=$trainingCertification["institute"];
        $saveTrainingCertification->location=$trainingCertification["location"];
        $saveTrainingCertification->description=$trainingCertification["description"];
        $saveTrainingCertification->time_period=$trainingCertification["time_period"];
        $saveTrainingCertification->resume_id=$trainingCertification["resume_id"];

        $saveTrainingCertification->save();
    }
    /*
     * training end
     */

    /*
     * Academic start
     */
    public function findResumeAcademicSummary($resumeId){
        $resumeAcademicSummary=ResumeAcademicSummaryModel::where("resume_id",$resumeId)->get();
        return $resumeAcademicSummary;
    }

    public function deleteResumeAcademicSummary($id){
        $resumeAcademicSummary=ResumeAcademicSummaryModel::find($id);
        $resumeAcademicSummary->delete();

        return true;
    }

    public function insertResumeAcademicSummary($academicSummary){
        $saveAcademicSummary=new ResumeAcademicSummaryModel();
        $saveAcademicSummary->level_of_education=$academicSummary['level_of_education'];
        $saveAcademicSummary->result=$academicSummary['result'];
        $saveAcademicSummary->degree_title=$academicSummary['degree_title'];
        $saveAcademicSummary->year_of_passing=$academicSummary['year_of_passing'];
        $saveAcademicSummary->currently_studying=$academicSummary['currently_studying'];
        $saveAcademicSummary->major=$academicSummary['major'];
        $saveAcademicSummary->duration=$academicSummary['duration'];
        $saveAcademicSummary->institute_name=$academicSummary['institute_name'];
        $saveAcademicSummary->remarks=$academicSummary['remarks'];
        $saveAcademicSummary->preview_status=$academicSummary['preview_status'];
        $saveAcademicSummary->resume_id=$academicSummary['resume_id'];

        $saveAcademicSummary->save();

        return $saveAcademicSummary;
    }
    /*
     * academic end
     */


    /*
     * Academic project start
     */
    public function findResumeAcademicProject($resumeId){
        $resumeAcademicProject=ResumeAcademicProjectModel::where("resume_id",$resumeId)->get();
        return $resumeAcademicProject;
    }

    public function deleteResumeAcademicProject($id){
        $resumeAcademicProject=ResumeAcademicProjectModel::find($id);
        $resumeAcademicProject->delete();

        return true;
    }

    public function insertResumeAcademicProject($academicProject){
        $saveAcademicProject=new ResumeAcademicProjectModel();
        $saveAcademicProject->course_name=$academicProject['course_name'];
        $saveAcademicProject->project_title=$academicProject['project_title'];
        $saveAcademicProject->area_of_work=$academicProject['area_of_work'];
        $saveAcademicProject->project_description=$academicProject['project_description'];
        $saveAcademicProject->role=$academicProject['role'];
        $saveAcademicProject->project_portfolio_link=$academicProject['project_portfolio_link'];
        $saveAcademicProject->resume_id=$academicProject['resume_id'];

        return $saveAcademicProject->save();
    }
    /*
     * academic project end
     */




    /*
     * skill start
     */
    public function findResumeSkill($resumeId){
        $resumeSkill=ResumeSkillModel::where("resume_id",$resumeId)->get();
        return $resumeSkill;
    }

    public function deleteResumeSkill($id){
        $resumeSkill=ResumeSkillModel::find($id);
        $resumeSkill->delete();

        return true;
    }

    public function insertResumeSkill($skill){
        $saveSkill=new ResumeSkillModel();
        $saveSkill->skill_name=$skill['skill_name'];
        $saveSkill->percentage=$skill['percentage'];
        $saveSkill->resume_id=$skill['resume_id'];

        $saveSkill->save();

        return $saveSkill;
    }
    /*
     * skill end
     */

    /*
     * IT skill start
     */
    public function findResumeItSkill($resumeId){
        $resumeSkill=ResumeItSkillModel::where("resume_id",$resumeId)->get();
        return $resumeSkill;
    }

    public function deleteResumeItSkill($id){
        $resumeSkill=ResumeItSkillModel::find($id);
        $resumeSkill->delete();

        return true;
    }

    public function insertResumeItSkill($skill){
        $saveSkill=new ResumeItSkillModel();
        $saveSkill->skill_name=$skill['skill_name'];
        $saveSkill->percentage=$skill['percentage'];
        $saveSkill->resume_id=$skill['resume_id'];

        $saveSkill->save();

        return $saveSkill;
    }
    /*
     * IT skill end
     */

    /*
     * Resume extra curricular activities start
     */
    public function findResumeEca($resumeId){
        $resumeSkill=ResumeExtraCurricularActivitiesModel::where("resume_id",$resumeId)->get();
        return $resumeSkill;
    }

    public function deleteResumeEca($id){
        $resumeSkill=ResumeExtraCurricularActivitiesModel::find($id);
        $resumeSkill->delete();

        return true;
    }

    public function insertResumeEca($ecaInfo){
        $saveEca=new ResumeExtraCurricularActivitiesModel();
        $saveEca->activity_title=$ecaInfo['activity_title'];
        $saveEca->activity_place=$ecaInfo['activity_place'];
        $saveEca->year=$ecaInfo['year'];
        $saveEca->role=$ecaInfo['role'];
        $saveEca->resume_id=$ecaInfo['resume_id'];

        $saveEca->save();

        return $saveEca;
    }
    /*
     * Resume extra curricular activities end
     */

    public function findResumeReference($resumeId){
        $resumeReference=ResumeReferenceModel::where("resume_id",$resumeId)->first();
        return $resumeReference;
    }


    public function insertResumeReference(Request $request){
        $saveReference=new ResumeReferenceModel();
        $saveReference->resume_id=$request->resumeId;
        $saveReference->reference_name=$request->referenceName;
        $saveReference->reference_designation=$request->referenceDesignation;
        $saveReference->reference_mobile=$request->referenceMobile;
        $saveReference->reference_email=$request->referenceEmail;
        $saveReference->reference_relationship=$request->referenceRelation;
        $saveReference->reference_organization=$request->referenceOrganization;

        $saveReference->save();

        return $saveReference;
    }

    public function updateResumeReference(Request $request){
        $updateReference=ResumeReferenceModel::where("resume_id",$request->resumeId)->first();
        $updateReference->reference_name=$request->referenceName;
        $updateReference->reference_designation=$request->referenceDesignation;
        $updateReference->reference_mobile=$request->referenceMobile;
        $updateReference->reference_email=$request->referenceEmail;
        $updateReference->reference_relationship=$request->referenceRelation;
        $updateReference->reference_organization=$request->referenceOrganization;

        $updateReference->save();

        return $updateReference;
    }
    /*
     * reference start
     */


    /*
     * reference end
     */
    public function getResumeRankingByTypeResumeId($type,$resumeId){
        return ResumeRankingModel::where("resume_id",$resumeId)
            ->where("ranking_type",$type)->get();
    }


    public function rankingUpdate(Request $request){
        $param=$request->type;
        $resume=EmployeeResumeModel::where('id',$request->resumeId)->first();
        $resume->$param=$request->value;
        return $resume->save();
    }

    public function rankingUpdateByCast($type,$value,$resumeId){
        $param=$type;
        $resume=EmployeeResumeModel::where('id',$resumeId)->first();
        $resume->$param=$value;
        return $resume->save();
    }


    public function remainOnlineAssessmentUpdateByResumeId($resumeId){
        $resume=EmployeeResumeModel::where('id',$resumeId)->first();
        $count=$resume->remaining_online_assessment-1;
        $resume->remaining_online_assessment=$count;
        return $resume->save();
    }


    public function insertResumeRanking($data,$resumeId,$rankingType){
        $insert=new ResumeRankingModel();
        $insert->resume_id=$resumeId;
        $insert->name=$data["category"];
        $insert->percentage=$data["percentage"];
        $insert->ranking=$data["ranking"];
        $insert->ranking_type=$rankingType;
        return $insert->save();


    }

    public function deleteResumeRankingByTypeResumeId($resumeId,$rankingType){

       $resume= ResumeRankingModel::where("resume_id",$resumeId)->where("ranking_type",$rankingType)->get();

       if(sizeof($resume)>0){
          foreach ($resume as $k=>$v){
              ResumeRankingModel::where("resume_id",$resumeId)->where("ranking_type",$rankingType)->delete();
          }
       }
      return $resume;
    }

    public function getAllRankingByType($resumeId,$rankingType){

       $resume= ResumeRankingModel::where("resume_id",$resumeId)->where("ranking_type",$rankingType)->with("rankingCodes")->get();

       return $resume;
    }

    public function findRankingByResumeId($resumeId){
       return ResumeRankingModel::where("resume_id",$resumeId)->with("rankingCodes")->get();
    }


    public function getPreferredCategoryResumeIdByCategoryId($categoryIdArray){
        return ResumePreferredJobCategoryModel::whereIn("preferred_job_category",$categoryIdArray)->distinct("resume_id")->pluck("resume_id")->take(100);
    }

    public function findVerifiedResumeByIdArray($idArray){
        return EmployeeResumeModel::whereIn("id",$idArray)
                                    ->where("online_assessment",">",1)
                                    ->where("interview_ranking",">",1)
                                    ->where("refree_ranking",">",1)
                                    ->take(9)->with("userDetails")->get();
    }

    public function referenceNIDUpdateByResumeId($resumeId,$nid){
        $reference=ResumeReferenceModel::where("resume_id",$resumeId)->first();
        $reference->nid_number=$nid;
        return $reference->save();


    }


    /**
     * Social Info
     */
    public function findSocialInfoByResumeId($resumeId){
        return ResumeSocialInfoModel::where("resume_id",$resumeId)->first();
    }

    public function insertSocialInfo(Request $request){
        $insert=new ResumeSocialInfoModel();
        $insert->resume_id=$request->resumeId;
        $insert->skype=$request->skype;
        $insert->google_dive=$request->googleDrive;
        $insert->pinterest=$request->printerest;
        $insert->twitter=$request->twitter;
        $insert->instagram=$request->instagram;
        $insert->linked_in=$request->linkedIn;
        $insert->github=$request->github;
        return $insert->save();
    }

    public function updateSocialInfo(Request $request){
        $update=ResumeSocialInfoModel::where("resume_id",$request->resumeId)->first();
        $update->skype=$request->skype;
        $update->facebook=$request->facebook;
        $update->google_dive=$request->googleDrive;
        $update->pinterest=$request->printerest;
        $update->twitter=$request->twitter;
        $update->instagram=$request->instagram;
        $update->linked_in=$request->linkedIn;
        $update->github=$request->github;
        return $update->save();
    }

    public function updateInterviewSchedule(Request $request){
        $update=EmployeeResumeModel::where("id",$request->resumeId)->first();
        $update->interview_date_time=$request->schedule;
        $update->interview_assigned_to=$request->assignedTo;
        return $update->save();
    }

    public function updateOnlineAssessmentSubCategory(Request $request){
        $update=EmployeeResumeModel::where("id",$request->resumeId)->first();
        $update->selected_online_assessment_subcategory_id=$request->subCategoryId;
        return $update->save();
    }
}