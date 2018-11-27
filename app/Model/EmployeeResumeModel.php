<?php namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class EmployeeResumeModel extends Model
{
    public $table='employee_resume';
    public $primaryKey='id';


    public function resumeImageByResumeId(){
        return $this->hasOne("App\Model\ResumeImageModel","resume_id","id");
    }
    public function resumeJobDetailsByResumeId(){
        return $this->hasOne("App\Model\ResumeJobDetailsModel","resume_id","id");
    }

    public function resumeReferenceByResumeId(){
        return $this->hasOne("App\Model\ResumeReferenceModel","resume_id","id");
    }

    public function resumePreferredJobCategoryByResumeId(){
        return $this->hasMany("App\Model\ResumePreferredJobCategoryModel","resume_id","id");
    }

    public function resumeTrainingCertificationByResumeId(){
        return $this->hasMany("App\Model\ResumeTrainingCertificationModel","resume_id","id");
    }

    public function resumeAcademicSummaryByResumeId(){
        return $this->hasMany("App\Model\ResumeAcademicSummaryModel","resume_id","id");
    }

    public function resumeWorkExperienceByResumeId(){
        return $this->hasMany("App\Model\ResumeWorkExperienceModel","resume_id","id");
    }


    public function resumeCoreSkillByResumeId(){
        return $this->hasMany("App\Model\ResumeSkillModel","resume_id","id");
    }

    public function resumeItSkillByResumeId(){
        return $this->hasMany("App\Model\ResumeItSkillModel","resume_id","id");
    }


    public function countryInfo(){
        return $this->hasOne("App\Model\CountryModel","id","country_id");
    }

    public function onlineAssessmentRankingCodes(){
        return $this->hasOne("App\Model\RankingCodes","id","online_assessment");
    }

    public function interviewRankingRankingCodes(){
        return $this->hasOne("App\Model\RankingCodes","id","interview_ranking");
    }


    public function resumeExtraCurricularActivitiesByResumeId(){
        return $this->hasMany("App\Model\ResumeExtraCurricularActivitiesModel","resume_id","id");
    }

    public function refreeRankingRankingCodes(){
        return $this->hasOne("App\Model\RankingCodes","id","refree_ranking");
    }

    public function resumeSocialInfo(){
        return $this->hasOne("App\Model\ResumeSocialInfoModel","resume_id","id");
    }

    public function resumeAcademicProjectByResumeId(){
        return $this->hasMany("App\Model\ResumeAcademicProjectModel","resume_id","id");
    }

    public function userDetailsByUserId(){
        return $this->hasOne("App\Model\UserDetailsModel","user_id","user_id");
    }

    public function interviewRankingDetails(){
        return $this->hasMany("App\Model\ResumeRankingModel","resume_id","id")->where("ranking_type","interview_ranking");
    }
    public function refereeRankingDetails(){
        return $this->hasMany("App\Model\ResumeRankingModel","resume_id","id")->where("ranking_type","refree_ranking");
    }
    public function onlineAssessmentRankingDetails(){
        return $this->hasMany("App\Model\ResumeRankingModel","resume_id","id")->where("ranking_type","online_assessment");
    }
    public function userDetails(){
        return $this->hasOne("App\Model\UserDetailsModel","user_id","user_id");
    }
    public function getSubCategoryDetails(){
        return $this->hasOne("App\Model\OnlineAssessmentQuestionSubCategoryModel","id","selected_online_assessment_subcategory_id");
    }


}

?>