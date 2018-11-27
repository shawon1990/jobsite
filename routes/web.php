<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('email', 'EmailController@testTemplates')->name('email');
Route::get('emailTest', 'EmailController@testMail')->name('email-test');
Route::get('testEmail', 'TestController@sendEmail')->name('email');
Route::get('testSMS', 'SMSController@singleDestination')->name('single.destination');
Route::get('emailAttachmentTest', 'EmailController@testAttachment')->name('test.attachment');
Route::get('skype', 'HomeController@skype')->name('skype');
Route::get('phpinfo', 'HomeController@phpInfo')->name('phpinfo');
Route::any('excel', 'TestController@testExcel')->name('testExcel');
Route::any('imageResize', 'ImageController@imageResizeDev')->name('resize.image');





Route::get('/', 'HomeController@index')->name('/');
Route::get('home', 'SiteController@index');
Route::any('findjobs', 'SiteController@findJobs')->name('findJobs');
Route::any('findjobs/{title}', 'SiteController@findJobsWithTitle')->name('findJobsWithTitle');
Route::any('women-online-jobs', 'SiteController@womenOnlineJobs')->name('womenOnlineJobs');
Route::any('handicap-jobs', 'SiteController@handicapJobs')->name('handicapJobs');
Route::any('overseas-jobs', 'SiteController@overseasJobs')->name('overseasJobs');
Route::get('findresume', 'SiteController@findResume')->name('findResume');
Route::get('about', 'SiteController@aboutUs')->name('aboutUs');
Route::get('business-update', 'SiteController@businessUpdate')->name('businessUpdate');
Route::get('whyus', 'SiteController@whyUs')->name('whyUs');
Route::get('ourResume', 'SiteController@ourResume')->name('our.resume');
Route::get('web-guide', 'SiteController@webGuide')->name('web.guide');
Route::get('benifits', 'SiteController@benifits')->name('benifits');
Route::get('contact', 'SiteController@contactUs')->name('contactUs');
Route::get('terms', 'SiteController@terms')->name('terms');
Route::get('jobDetails/{jobDetails}/{jobId}/{companyId}', 'SiteController@jobDetails')->name('job.details');
Route::get('resumeDetails/{resumeId}', 'SiteController@resumeDetails')->name('resume.details');
Route::get('referee/verification/{token}', 'SiteController@refereeVerification')->name('referee.verification');
Route::post('referee/verification/submit', 'SiteController@refereeVerificationSubmit')->name('referee.verification.submit');
Route::get('blog/blog-details', 'SiteController@blogDetails')->name('blog');
Route::get('blog/blog-article', 'SiteController@blog')->name('blog');

Route::get('register/{registerType}', 'SiteController@register')->name('register');
Route::get('verify-email', 'SiteController@emailVerification')->name('email.verification');



Route::any('walletmix/payment', 'User\WalletMixController@paymentCheck')->name('walletmix.payment');
Route::any('walletmix/callback', 'User\WalletMixCallBackController@callBack')->name('walletmix.callBack');




Auth::routes();
/*common Start*/
Route::get('/dashboard', 'User\UserController@index')->name('dashboard');
Route::get('/logout', 'Auth\LoginController@userLogout')->name('logout');


Route::get('/profile', 'User\ProfileController@view')->name('user.profile.view');
Route::get('edit/profile', 'User\ProfileController@edit')->name('user.profile.edit');
Route::post('/update/profile', 'User\ProfileController@updateProfile')->name('user.profile.update');


Route::get('/system/email', 'User\SystemEmailController@systemEmail')->name('user.system.email');


Route::get('/view/all/notification', 'User\NotificationController@viewAllNotification')->name('view.all.notification');
/*common End*/
Route::any('employee/profileImage/upload','User\ImageController@uploadProfileImage');





/*Employee Start*/
Route::get('/edit/resume', 'User\ResumeController@editResume')->name('resume.edit');
Route::get('/edit/extended/resume', 'User\ResumeController@editResumeExtended')->name('resume.edit.extended');
Route::get('/view/resume', 'User\ResumeController@viewResume')->name('resume.view');


Route::get('/manage/activity', 'User\ManageActivityController@employeeManageActivity')->name('manage.activity');
Route::get('/online/application', 'User\JobController@employeeOnlineApplication')->name('employee.online.application');
Route::get('/job/view/{jobid}/{companyid}', 'User\JobController@viewJobDetails')->name('view.job');
Route::get('/job/apply/{id}', 'User\JobController@applyJob')->name('apply.job');


Route::get('/job/search', 'User\SearchController@jobSearch')->name('job.search');


Route::get('/self-assessment', 'User\SelfAssessmentController@testInstruction')->name('self.test.instruction');
Route::get('/self-assessment/start', 'User\SelfAssessmentController@selfTestStart')->name('self.test.start');
Route::post('/self-assessment/submit', 'User\SelfAssessmentController@submitTest')->name('self.test.submit');
Route::get('/self-assessment/result', 'User\SelfAssessmentController@selfAssessmentResult')->name('self.test.result');


Route::get('/online-assessment', 'User\SelfAssessmentController@userBackgroundConfirmation')->name('online.test.background-confirmation');
Route::get('online-assessment/instruction', 'User\SelfAssessmentController@onlineAssessmentInstruction')->name('online.test.instruction');
Route::get('online-assessment/start', 'User\SelfAssessmentController@onlineAssessmentStart')->name('online.test.instruction');
Route::post('online-assessment/submission', 'User\SelfAssessmentController@submitOnlineAssessment')->name('online.test.submit');

Route::get('/self-assessment/start', 'User\SelfAssessmentController@selfTestStart')->name('self.test.start');
Route::post('/self-assessment/submit', 'User\SelfAssessmentController@submitTest')->name('self.test.submit');
Route::get('/self-assessment/result', 'User\SelfAssessmentController@selfAssessmentResult')->name('self.test.result');

Route::get('/employee/onlinejob-details', 'User\JobController@employeeOnlineJobDetails')->name('employee.onlinejob.details');

/*Employee end */





/*Employer Start*/
Route::get('/company/profile', 'User\CompanyProfileController@view')->name('company.profile.view');
Route::get('edit/company/profile', 'User\CompanyProfileController@editProfile')->name('company.profile.edit');
Route::post('update/company/profile', 'User\CompanyProfileController@updateProfile')->name('company.profile.update');

Route::get('/create/post-a-job', 'User\JobController@createJobPost')->name('employer.create.jobpost');
Route::get('/edit/jobpost/{companyId}/{postId}', 'User\JobController@editJobPost')->name('employer.edit.jobpost');
Route::get('created/job-list', 'User\JobController@createdJobList')->name('employer.created.joblist');

Route::get('/create/handicap/jobpost', 'User\JobController@createHandicapJobPost')->name('employer.create.handicap.jobpost');

Route::get('/edit/companyprofile', 'User\UserController@editEmployer')->name('employer.edit');
Route::post('/update/companyprofile', 'User\UserController@updateEmployer')->name('employer.profile.update');

Route::get('/create/vacancy/announcement', 'User\VacancyController@createVacancy')->name('create.vacancy');
Route::post('/save/vacancy', 'User\VacancyController@saveVacancy')->name('save.vacancy');
Route::get('/edit/vacancy/announcement/{id}', 'User\VacancyController@editVacancy')->name('edit.vacancy');
Route::post('/update/vacancy/{id}', 'User\VacancyController@updateVacancy')->name('update.vacancy');

Route::get('/employer/vacancy/list', 'User\VacancyController@vacancyList')->name('vacancy.list');


Route::get('/manage/candidates', 'User\ManageActivityController@employerManageCandidates')->name('manage.candidates');
Route::get('/manage/candidates/details/{jobId}/{id}', 'User\ManageActivityController@manageCandidatesDetails')->name('manage.candidates.details');

Route::get('/manage/candidates/cv', 'User\ManageActivityController@employerManageCVCandidates')->name('manage.candidates.cv');
Route::any('cv/manage/candidates/details/{manageCadidatesId}/{resumeId}', 'User\ManageActivityController@employerManageCVCandidatesDetails')->name('manage.candidates.cv.details');

Route::get('/responded/candidates', 'User\ManageActivityController@employerRespondedCandidates')->name('responded.candidates');

Route::get('employer/resume/view/{resumeId}', 'User\ResumeController@employerViewResumeDetails')->name('view.resume');


Route::get('/resume/search', 'User\SearchController@resumeSearch')->name('resume.search');
/*Subscription Package*/
Route::get('/company/package', 'User\PackageController@employerPackage')->name('employer.package');
Route::any('/company/package/purchase/{id}', 'User\PackageController@packagePurchase')->name('employer.package');
Route::any('/company/purchase/confirmation', 'User\PackageController@packagePurchaseConfirmation')->name('employer.package.purchase.confirmation');
Route::any('/company/purchase/payment', 'User\PackageController@packagePurchasePayment')->name('employer.package.purchase.payment');
Route::any('/company/purchase/cheque', 'User\PackageController@packagePurchaseChequePayment')->name('employer.package.purchase.cheque.payment');
Route::any('/company/purchase/cheque/confirmation', 'User\PackageController@packagePurchaseChequePaymentConfirmation')->name('employer.package.purchase.cheque.payment');
Route::any('/cheque/invoice/{id}', 'User\PdfController@generateChequeInvoice')->name('employer.package.purchase.cheque.invoice');
Route::any('/export/invoice/{id}', 'User\PdfController@generateExportInvoice')->name('employer.package.purchase.export.invoice');

Route::get('/company/premiumpackage/request', 'User\PackageController@premiumPackageRequest')->name('employer.premiumpackage.request');

Route::get('/company/package/transaction-history', 'User\PackageController@transactionHistory')->name('employer.transactionHistory');

Route::get('/employer/onlinejob', 'User\JobController@employerOnlineJob')->name('employee.onlinejob');
/*Subscription Package*/

/*Employer end */


Route::get('/pdf/output', 'User\PdfController@testPdf')->name('pdf.output');



Route::prefix('admin')->group(function (){
    /*login start*/
    Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');
    /*login end*/

    /*profile start*/
    Route::get('/profile', 'Admin\AdminController@showProfile')->name('admin.profile');
    Route::post('/profile/updateAdminUser','Admin\AdminController@updateAdminProfile')->name('admin.profile.update');
    Route::post('/profile/changePassword','Admin\AdminController@changeAdminPassword')->name('admin.profile.changepassword');
    /*profile end*/

    /*User Management start*/
    Route::get('/list/admin', 'Admin\UserController@adminList')->name('admin.list');
    Route::get('/list/jobseeker', 'Admin\UserController@jobSeekerList')->name('admin.jobseeker');
    Route::get('/list/employer', 'Admin\UserController@employerList')->name('admin.employer');

    Route::get('/employee/profile/{id}', 'Admin\UserController@employeeProfile')->name('admin.employee.profile');
    Route::get('/employer/profile/{id}', 'Admin\UserController@employerProfile')->name('admin.employer.profile');
    Route::get('resumeDetails/{resumeId}', 'Admin\ResumeController@resumeDetails')->name('admin.resume.details');

    Route::get('/create/admin', 'Admin\UserController@createAdmin')->name('admin.create.admin');
    Route::post('/save/admin', 'Admin\UserController@saveAdmin')->name('admin.save.admin');

    Route::any('/delete/adminUser/{id}','Admin\UserController@deleteAdminUser')->name('admin.delete.adminUser');
    Route::any('/edit/adminUser','Admin\UserController@editAdminUser')->name('admin.edit.adminUser');
    Route::post('/update/adminUser','Admin\UserController@updateAdminUser')->name('admin.update.admin');
    Route::any('/adminUser/changepassword','Admin\UserController@updateAdminUserPassword')->name('admin.updatepassword.admin');
    //Route::get('/notFound404','Admin\UserController@deleteAdminUser');
//    Route::get('/create/jobseeker', 'Admin\UserController@createJobSeeker')->name('admin.create.jobseeker');
//    Route::get('/create/employer', 'Admin\UserController@createEmployer')->name('admin.create.employer');
//    Route::post('/save/{user}', 'Admin\UserController@save')->name('admin.user.save');
    /*User Management end*/

    /*Notification start*/
    Route::get('/timeline', 'Admin\NotificationController@timeLine')->name('admin.timeline');
    /*Notification end*/

    /*Job Category*/
    Route::get('/list/jobCategory', 'Admin\JobController@jobCategoryList')->name('admin.list.jobcategorylist');
    Route::get('/create/jobCategory', 'Admin\JobController@createJobCategory')->name('admin.create.jobcategory');
    Route::get('/create/jobseeker', 'Admin\UserController@createJobSeeker')->name('admin.create.jobseeker');
    Route::get('/create/employer', 'Admin\UserController@createEmployer')->name('admin.create.employer');
    Route::post('/save/{user}', 'Admin\UserController@save')->name('admin.user.save');
    /*Job Category*/

    /*package start*/
    Route::get('/package/premium/request', 'Admin\PackageController@getAllPremiumRequest')->name('admin.list.premium.request');
    Route::get('/premium/cv/request/details/{id}', 'Admin\PackageController@getPremiumRequestDetails')->name('admin.premium.request.details');
    Route::get('/search/cv/for/premium/{id}', 'Admin\SearchController@premiumCVSearch')->name('admin.premium.cv.search');


    Route::get('/package/payment/request/{type}', 'Admin\PackageController@getPaymentRequest')->name('admin.list.payment');
    Route::get('/package/activated', 'Admin\PackageController@getAllActivatedPackage')->name('admin.list.package.activated');

    /*package end*/

    Route::get('/searchCandidate', 'Admin\SearchController@searchCandidates')->name('admin.search.candidates');


    Route::get('/govtSection', 'Admin\JobController@govtSection')->name('admin.govt.section');

    Route::post('saveGovtSection', 'Admin\JobController@saveGovtSection')->name('admin.save.govt.section');
    Route::get('deleteGovtSection/{id}', 'Admin\JobController@deleteGovtSection')->name('admin.delete.govt.section');

    Route::get('postedJob', 'Admin\JobController@postedJob')->name('admin.posted.job');
    /**
     *System Email Start
     */
    Route::get('/system/email', 'Admin\SystemEmailController@systemEmail')->name('admin.system-email.view');

    /**
     *System Email End
     */


    /**
     * Business Update
     */
    Route::get('/testResize', 'Admin\BusinessUpdateController@resizeImage')->name('admin.business-update.resize');
    Route::get('/businessUpdate', 'Admin\BusinessUpdateController@businessUpdate')->name('admin.business-update.view');
    Route::get('/businessUpdate/create', 'Admin\BusinessUpdateController@createBusinessUpdate')->name('admin.create.business-update');
    Route::post('/businessUpdate/save', 'Admin\BusinessUpdateController@saveBusinessUpdate')->name('admin.save.business-update');
    Route::get('/businessUpdate/edit/{id}', 'Admin\BusinessUpdateController@editBusinessUpdate')->name('admin.edit.business-update');
    Route::post('/businessUpdate/update/{id}', 'Admin\BusinessUpdateController@updateBusinessUpdate')->name('admin.update.business-update');
    Route::get('/businessUpdate/delete/{id}', 'Admin\BusinessUpdateController@deleteBusinessUpdateById')->name('admin.delete.business-update');








    /**
     * Online Assessment
     */

    Route::get('/online-assessment', 'Admin\OnlineAssessmentController@onlineAssessment')->name('admin.online-assessment.view');
    Route::any('/online-assessment/list', 'Admin\OnlineAssessmentController@onlineAssessmentList')->name('admin.online-assessment.list');
    Route::post('/online-assessment/questionSet/save', 'Admin\OnlineAssessmentController@onlineAssessmentquestionSetSave')->name('admin.online-assessment.save.questionSet');
    Route::any('/online-assessment/list/subCategory/{subCategoryId}', 'Admin\OnlineAssessmentController@onlineAssessmentListWithSubCategoryId')->name('admin.online-assessment.list.subCategoryId');
    Route::any('/online-assessment/questionSet/delete/{subCategoryId}/{id}', 'Admin\OnlineAssessmentController@onlineAssessmentQuestionSetDelete')->name('admin.online-assessment.list.questionSet.delete');
    Route::any('/online-assessment/list/upload', 'Admin\OnlineAssessmentController@onlineAssessmentListUpload')->name('admin.online-assessment.question-list.upload');
    Route::any('/online-assessment/sample/download/{id}', 'Admin\OnlineAssessmentController@onlineAssessmentSampleDownload')->name('admin.online-assessment.question-sample.download');
    Route::get('/online-assessment/category', 'Admin\OnlineAssessmentController@onlineAssessmentCategory')->name('admin.online-assessment.question.category');
    Route::get('/online-assessment/subCategory', 'Admin\OnlineAssessmentController@onlineAssessmentSubCategory')->name('admin.online-assessment.question.subCategory');
    Route::post('/online-assessment/category/save', 'Admin\OnlineAssessmentController@onlineAssessmentCategorySave')->name('admin.online-assessment.save.category');
    Route::post('/online-assessment/subCategory/save', 'Admin\OnlineAssessmentController@onlineAssessmentSubCategorySave')->name('admin.online-assessment.save.subCategory');
    Route::post('/online-assessment/questionType/save', 'Admin\OnlineAssessmentController@onlineAssessmentSubCategorySave')->name('admin.online-assessment.save.questionType');
    Route::any('/online-assessment/questionType', 'Admin\OnlineAssessmentController@onlineAssessmentQuestionType')->name('admin.online-assessment.questionType');
    Route::any('/online-assessment/subCategory/delete/{id}', 'Admin\OnlineAssessmentController@onlineAssessmentSubCategoryDelete')->name('admin.online-assessment.subCategory.delete');
    Route::any('/online-assessment/category/delete/{id}', 'Admin\OnlineAssessmentController@onlineAssessmentCategoryDelete')->name('admin.online-assessment.category.delete');


    /**
     * Sms/Email Marketing
     */
    Route::get('/marketing/contactList', 'Admin\MarketingController@contactList')->name('admin.marketing.contact.list');
    Route::post('save/marketing/contactList', 'Admin\MarketingController@saveContactList')->name('admin.marketing.save.contact.list');
    Route::get('/marketing/groupList', 'Admin\MarketingController@groupList')->name('admin.marketing.group.list');


    Route::get('/pdf/output/{userId}', 'User\PdfController@downResumeById')->name('admin.pdf.output');
});




Route::prefix('forum')->group(function (){
    Route::get('/', 'Forum\DiscussionController@allDiscussion')->name('forum.allDiscussion');

    Route::get('/login/{loginToken}', 'Forum\UserController@forumUserLogin')->name('forum.login');
    Route::get('/logout', 'Forum\UserController@forumUserLogout')->name('forum.login');
    Route::get('discussion/{subCategoryId}', 'Forum\DiscussionController@subCategoryDiscussion')->name('forum.subCategory.discussion');
    Route::get('discussion-details/{title}/{id}', 'Forum\DiscussionController@discussionDetails')->name('forum.discussionDetails');

    Route:: post('/postComment','API\Service\ForumController@saveComment')->name('forum.postComment');

   // Route::get('discussion-details/{id}', 'API\Service\ForumController@getComment')->name('forum.discussionDetails');
    Route::get('/privacy-policy', 'Forum\DiscussionController@privacyPolicy')->name('forum.privacy-policy');


    /**
     * Social Login
     */
    Route::get('/redirect', 'Forum\UserController@redirect');
    Route::get('/callback', 'Forum\UserController@callback');


    Route::get('/gmail/redirect', 'Forum\UserController@gmailRedirectToProvider');
    Route::get('/gmail/callback', 'Forum\UserController@gmailCallback');
});

