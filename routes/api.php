<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::any('support/email','API\Service\EmailController@supportEmail');

Route::any('partial/findjobs/search','API\Service\SearchController@partialJobSearch');
Route::any('partial/employee/findjobs/search','API\Service\SearchController@partialEmployeeJobSearch');
Route::any('partial/findresume/search','API\Service\SearchController@partialResumeSearch');
Route::any('partial/searchJobCountWithTypeCategory','API\Service\SearchController@partialJobCountWithTypeCategory');

Route::any('send/forgot/password','API\Service\UserController@sendForgotPasswordEmail');
Route::any('send/verification/email','API\Service\UserController@reSendVerificationCode');
Route::any('create/job/alert','API\Service\UserController@createJobAlert');



/**
 * Walletmix
 */
Route::any('walletmix/payment', 'User\WalletMixController@paymentCheck')->name('walletmix.payment');
Route::any('walletmix/callback', 'API\Service\WalletMixCallBackController@callBack')->name('walletmix.callBack');


//*********************************************Employee start*****************************************//
/*
 * Resume start
 */

/*
 * partial view
 */
Route::any('partial/resume/academic_info','API\Service\ResumeController@partialAcademic');
Route::any('partial/resume/academic_project','API\Service\ResumeController@partialAcademicProject');
Route::any('partial/resume/experience_info','API\Service\ResumeController@partialExperience');
Route::any('partial/resume/training_info','API\Service\ResumeController@partialTraining');
Route::any('partial/resume/skill_info','API\Service\ResumeController@partialSkill');
Route::any('partial/resume/it_skill_info','API\Service\ResumeController@partialItSkill');
Route::any('partial/resume/basic-language','API\Service\ResumeController@partialBasicLanguage');
Route::any('partial/resume/modalView','API\Service\ResumeController@partialResumeModalView');
Route::any('partial/resume/eca_info','API\Service\ResumeController@partialResumeECA');

/*
 * partial view end
*/

Route::any('save/resume_preferred_job','API\Service\ResumeController@updateResumePreferredJob');
Route::any('save/resume_basic','API\Service\ResumeController@updateBasic');
Route::any('save/resume_academic','API\Service\ResumeController@updateResumeAcademic');
Route::any('save/resume_academic_project','API\Service\ResumeController@updateResumeAcademicProject');
Route::any('save/resume_experience','API\Service\ResumeController@updateResumeExperience');
Route::any('save/resume_training','API\Service\ResumeController@updateResumeTraining');
Route::any('save/resume_skill','API\Service\ResumeController@updateResumeSkill');
Route::any('get/resume_skill','API\Service\ResumeController@findResumeSkill');
Route::any('save/resume_it_skill','API\Service\ResumeController@updateResumeItSkill');
Route::any('save/resume_eca','API\Service\ResumeController@updateResumeEca');
Route::any('get/resume_it_skill','API\Service\ResumeController@findResumeItSkill');
Route::any('save/resume_reference','API\Service\ResumeController@updateResumeReference');
Route::any('findresume/searchIT','API\Service\SearchController@searchITSkill');
Route::any('findresume/searchCoreCompetencies','API\Service\SearchController@searchCoreCompetencies');
Route::any('findresume/searchInstitutionName','API\Service\SearchController@searchInstitutionName');
Route::any('save/resume_social','API\Service\ResumeController@updateResumeSocial');
Route::any('change/jobLooking','API\Service\ResumeController@updateJobLookingStatus');
/*
 * Resume End
 */
/**
 * Online-Assessment
 */
Route::any('online-assessment/category','API\Service\SelfAssessmentController@getCategoryByLevelId');
Route::any('online-assessment/subCategory','API\Service\SelfAssessmentController@getSubCategoryByCategoryId');
Route::any('online-assessment/save/subCategoryId','API\Service\SelfAssessmentController@saveSubCategoryId');


//*********************************************Employee End*****************************************//

//*********************************************Employer start*****************************************//
/*
 * Job start
 */
/*
 * partial view start
 */
Route::any('view/job_details','API\Service\JobController@partialJobDetailsModal');


/*
 * partial view end
 */
Route::any('save/job_post','API\Service\JobController@createJobPost');
Route::any('update/job_post','API\Service\JobController@updateJobPost');
Route::any('delete/job_post','API\Service\JobController@deleteJobPost');
Route::any('job/applyWithExpectedSalary','API\Service\JobController@applyWithExpectedSalary');


Route::any('manageCandidates/search','API\Service\ManageActivityController@searchCandidates');

Route::any('respondedCandidates/search','API\Service\ManageActivityController@searchRespondedCandidates');
/*
 * Job end
 */
/*
 * partial start
 */
Route::post('partial/manage/candidates/resume','API\Service\ManageActivityController@partialCandidateResumeDetails');

Route::post('partial/manage/cv/candidates/resume','API\Service\ManageActivityController@partialCVCandidateResumeDetails');
/*
 * partial end
 */

Route::post('manage/candidates/status','API\Service\ManageActivityController@candidateStatus');

Route::post('manage/cv/candidates/status','API\Service\ManageActivityController@cvCandidateStatus');

Route::post('manage/candidates/cv/move','API\Service\ManageActivityController@moveCVToManageCandidates');

Route::any('manageCandidates/cv/list','API\Service\ManageActivityController@manageCandidatesCVList');
Route::any('partial/manageCandidates/cv/list','API\Service\ManageActivityController@partialManageCandidatesCVList');



Route::any('save/requestedPremiumCV','API\Service\PackageController@createRequestedPremiumCV');

Route::post('purchase/package/confirm','API\Service\PackageController@purchaseConfirmation');
Route::post('purchase/package/payment','API\Service\PackageController@packageConfirmationPayment');
Route::any('company/purchase/cheque/confirmation','API\Service\PackageController@packagePurchaseChequePaymentConfirmation');

Route::any('update/transactionTrackingNumber','API\Service\PackageController@updateTransactionTrackingNumber');

Route::any('partial/suggestive/candidate','API\Service\SearchController@partialCandidateSuggestion');

Route::any('partial/suggestive/jobs','API\Service\SearchController@partialJobsSuggestion');




//********************************************Employer end*****************************************//


//********************************************Common start*****************************************//
/**
 * profile start
 */
/*partial*/
Route::any('profile/edit','API\Service\ProfileController@partialEdit');
/*partial*/

Route::any('profile/update','API\Service\ProfileController@update');
Route::any('profile/changePassword','API\Service\ProfileController@changePassword');



/**
 * profile end
 */

Route::any('partial/user/unread/notification','API\Service\NotificationController@partialUnreadNotification');
Route::any('partial/user/unread/emails','API\Service\SystemEmailController@partialUnreadEmails');


/**
 * System Email start
 */
/**
 * partial start
 */
Route::any('/partial/system/email/content','API\Service\SystemEmailController@partialLoadContent');
Route::any('/partial/system/email/content/details','API\Service\SystemEmailController@partialLoadContentDetails');


/**
 * partial end
 */
Route::any('company/candidates/email','API\Service\SystemEmailController@companyTOCandidateEmail');
Route::any('candidates/company/email','API\Service\SystemEmailController@candidateToCompanyEmail');
Route::any('compose/email','API\Service\SystemEmailController@composeEmail');
Route::any('user/admin/email','API\Service\SystemEmailController@userToAdminEmail');
Route::any('admin/user/email','API\Service\SystemEmailController@adminToUserEmail');

/**
 * System Email End
 */
//********************************************Common end*****************************************//






/*dropzone*/
Route::any('file/service/img/upload','API\Service\FileController@saveTempProfileImage');
Route::post('profilepic/tempimage/remove','API\Service\FileController@removeProfilePicTempImage');

Route::post('employee/resume/upload','API\Service\FileController@saveImageByToken');
Route::any('employee/profileimage/get','API\Service\FileController@getProfileImageByUserId');

/*dropzone*/

/*admin*/
/**
 * Email Start
 */
/**
 * partial Start
 */

/**
 * partial end
 */
/**
 * Email end
 */
Route::any('admin/jobSeeker','API\Service\UserController@getJobSeeker');
Route::any('admin/user/statusUpdate','API\Service\UserController@updateUserStatus');
Route::any('admin/user/resume/ranking/update','API\Service\ResumeController@updateResumeRanking');
Route::any('admin/user/resume/operation/interviewRanking','API\Service\ResumeController@updateInterviewRanking');


/**
 * Employer
 */
Route::any('admin/employer/handicapJob/status','API\Service\CompanyProfileController@updateHandicapJobStatus');





Route::any('admin/premium/cv/statusUpdate','API\Service\PackageController@updatePremiumRequestStatus');
Route::any('admin/partial/findresume/search','API\Service\SearchController@adminResumeSearch');
Route::any('admin/addCVToPremium','API\Service\PackageController@addCVToPremium');
Route::any('admin/removeCVFromPremium','API\Service\PackageController@removeCVFromPremium');
Route::any('admin/premium/cv/confirm/update','API\Service\PackageController@premiumCVConfirmationUpdate');
Route::any('admin/change/package/payment/status','API\Service\PackageController@changePackagePaymentStatus');
Route::any('admin/change/package/payment/amount','API\Service\PackageController@changePackagePaymentAmount');
Route::any('admin/change/package/status','API\Service\PackageController@changePackageStatus');



Route::any('admin/user/resume/operation/interviewSchedule','API\Service\ResumeController@updateInterviewSchedule');
Route::any('admin/user/resume/operation/changeResumeStatus','API\Service\ResumeController@updateResumeStatus');
Route::any('admin/user/resume/operation/resumeComment','API\Service\ResumeController@updateResumeComment');
Route::any('admin/user/resume/operation/resumeSearchingKeyword','API\Service\ResumeController@updateResumeSearchingKeyword');


Route::any('admin/editGovtSection', 'API\Service\JobController@editGovtSection');
Route::any('admin/updateGovtSection', 'API\Service\JobController@updateGovtSection');

/**
 * marketing
 */
Route::any('admin/save/groupInfo', 'API\Service\MarketingController@saveGroupInfo');



Route::any('admin/online-assessment/save/questionType','API\Service\SelfAssessmentController@saveQuestionType');
Route::any('admin/online-assessment/questionType/list','API\Service\SelfAssessmentController@questionTypeList');
Route::any('admin/online-assessment/questionType/delete','API\Service\SelfAssessmentController@questionTypeDelete');

//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return "I am here";
//});
//Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function(){
//    Route::get('test1',function(){
//        return response([1,2,3,4],200);
//    });
//
//});
//Route::prefix('admin')->group(function (){
//    Route::middleware('auth:admin-api')->get('/user', function () {
//        return "I am here";
//    });
//});


//********************************************Forum*****************************************//

Route::any('forum/registration', 'API\Service\ForumController@registration');
Route::any('forum/login', 'API\Service\ForumController@login');
Route::any('forum/subCategory', 'API\Service\ForumController@subCategory');
Route::any('forum/save/discussion', 'API\Service\ForumController@saveDiscussion');
Route::any('forum/save/postComment', 'API\Service\ForumController@saveComment');
Route::any('forum/comment/edit/{id}', 'API\Service\ForumController@editComment');
Route::any('forum/comment/update', 'API\Service\ForumController@updateComment');
//Edit & update post
Route::any('/forum/post/edit', 'API\Service\ForumController@editPost');
Route::any('/forum/post/update', 'API\Service\ForumController@UpdatePost');

//Delete comment
Route::any('/forum/post/delete', 'API\Service\ForumController@deletePost');
Route::any('/forum/comment/delete', 'API\Service\ForumController@deleteComment');

Route::any('/forum/comment/vote/update', 'API\Service\ForumController@commentVoteUpdate');

Route::any('/forum/changepassword', 'API\Service\ForumController@changePassword');

Route::any('/forum/send/forgot/password','API\Service\ForumController@sendForgotPasswordEmail');

//Edit & update post End

