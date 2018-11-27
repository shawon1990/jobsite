<?php namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JobCategoryModel extends Model
{
    public $table='job_category';
    public $primaryKey='id';



    public function jobCategoryType(){
        return $this->hasOne("App\Model\JobCategoryTypeModel","id","category_type");
    }

    public function jobCount(){
        return $this->hasMany("App\Model\JobPostModel","category_id","id")->select(DB::raw('count(*) as count'))->groupBy('id');
    }


}





?>