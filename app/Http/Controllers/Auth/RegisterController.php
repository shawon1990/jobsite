<?php

namespace App\Http\Controllers\Auth;

use App\Dao\CompanyDetailsDao;
use App\Dao\CompanyUsersDao;
use App\Dao\EmployeeDetailsDao;
use App\Dao\EmployeeResumeDao;
use App\Dao\EmployerDetailsDao;
use App\Dao\UserDao;
use App\Dao\UserDetailsDao;
use App\Http\Controllers\EmailController;
use App\Model\CompanyDetailsModel;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */



    protected function validator(array $data)
    {


        if($data['user_type']=="employer"){
            return Validator::make($data, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'user_type' =>  'required|max:255',
                'company_name' =>  'required|max:255',
                'company_type' =>  'required|integer|between:1,100',
            ]);
        }else{
            return Validator::make($data, [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'user_type' =>  'required|max:255',
            ]);
        }



    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {


        $user= User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'user_type' => $data['user_type']
        ]);

        if($user!=''){
            $this->email=new EmailController();
            $this->userUpdate=new UserDao();
            $this->userDetails=new UserDetailsDao();

            $userDetails=[];

            $userDetails['user_id']=$user->id;
            $userDetails['first_name']=$data['first_name'];
            $userDetails['last_name']=$data['last_name'];


            if($user->user_type=='employer'){

                $this->comapanyDetailsDao=new CompanyDetailsDao();
                $this->comapanyUser=new CompanyUsersDao();

                $companyDetails=[];
                $companyDetails["name_of_company"]=$data['company_name'];
                $companyDetails["company_type_id"]=$data['company_type'];
                $companyDetails["name_of_contact_person"]=$data['first_name']." ".$data['last_name'];
                $companyDetails["email_of_contact_person"]=$data['email'];

                $company=$this->comapanyDetailsDao->insert($companyDetails);


                $companyUserDetails=[];
                $companyUserDetails["company_id"]=$company->id;
                $companyUserDetails["user_id"]=$user->id;
                $companyUserDetails["user_role"]="superadmin";
                $this->comapanyUser->insert($companyUserDetails);


                $userDetails['registration_number']=$this->generateRegistrationNumber('employer',$user->id);

                /**
                 * Update userDetails
                 */
                $this->userDetails->save($userDetails);


                $email_verification_code=$this->email->generateEmailVerificationCode('employer',$user->id);


            }

            if($user->user_type=='employee'){

                $this->employeeResumeDao=new EmployeeResumeDao();

                $resumeDetails=[];
                $resumeDetails['first_name']=$data['first_name'];
                $resumeDetails['last_name']=$data['last_name'];
                $resumeDetails['user_id']=$user->id;

                $this->employeeResumeDao->insert($resumeDetails);

                $userDetails['registration_number']=$this->generateRegistrationNumber('employee',$user->id);
                $email_verification_code=$this->email->generateEmailVerificationCode('employer',$user->id);

                /**
                 * Update userDetails
                 */
                $this->userDetails->save($userDetails);

                $this->email->interviewTipsEmail($data['last_name'],$data['email'], "info@valerejobs.com", "Valere Enterprise", "info@valerejobs.com", "info@valerejobs.com");
            }




            /*Registration email*/

            $emailUpdate=$this->userUpdate->updateEmailVerificationCodeById(trim($email_verification_code),$user->id);
            $sendEmail=$this->email->sendUserRegistrationEmail($data['last_name'],$email_verification_code,$user->email);




        }

        return $user;
    }


    public function generateRegistrationNumber($userType,$userId){

        $chars = '0123456789';
        $length=4;

        if($userType=='employee'){
            $number="JS".$userId.substr(str_shuffle($chars),0,$length).date("y");
        }elseif($userType=='employer'){
            $number="CM".$userId.substr(str_shuffle($chars),0,$length).date("y");
        }

        return $number;
    }





}
