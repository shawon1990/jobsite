<?php namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class CompanyDetailsModel extends Model
{
    public $table='company_details';
    public $primaryKey='id';


        public function companyType(){
            return $this->hasOne("App\Model\CompanyTypeModel","id","company_type_id");
        }


        public function companyImage(){
            return $this->hasOne("App\Model\CompanyImageModel","company_id","id");
        }


        public function premiumJobPost(){
            return $this->hasMany("App\Model\JobPostModel","company_id","id")
                        ->where("subscription_package_details_id",4)
                        ->where("created_at",">=",date('Y-m-d', strtotime('-12 days')))
                        ->where("application_deadline",">=",date('Y-m-d'));
        }




}





?>