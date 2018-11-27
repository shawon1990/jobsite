<?php

namespace App\Http\Controllers;

use App\Dao\EmployeeResumeDao;
use App\Dao\EmployerDetailsDao;
use App\Model\EmployeeResumeModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->username = 'ValereBD';
        $this->password = 'Valere@623581';
        $this->MULTIPART_BOUNDARY='-----------------------'.md5(time());

    }

    public function getBody($fields) {
        $content = '';
        foreach ($fields as $FORM_FIELD => $value) {
            $content .= '--' . $this->MULTIPART_BOUNDARY . "\r\n";
            $content .= 'Content-Disposition: form-data; name="' . $FORM_FIELD . '"' . "\r\n";
            $content .= "\r\n" . $value . "\r\n";
        }
        return $content . '--' . $this->MULTIPART_BOUNDARY . '--'; // Email body should end with "--"
    }

    /*
     * Method to get the headers for a basic authentication with username and passowrd
    */
    public function getHeader($username, $password){
        // basic Authentication
        $auth = base64_encode("$username:$password");

        // Define the header
        return array("Authorization:Basic $auth", 'Content-Type: multipart/form-data ; boundary=' . $this->MULTIPART_BOUNDARY );
    }


    public function sendEmail(){
        // URL to the API that sends the email.
        $url = 'https://api.infobip.com/email/1/send';

        // Associate Array of the post parameters to be sent to the API
        $postData = array(
            'from' => 'info@valerejobs.com',
            'to' => 'vikisaif@gmail.com',
            'subject' => 'Mail subject text',
            'text' => 'Mail body text',
        );

        // Create the stream context.
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => $this->getHeader('ValereBD', 'Valere@623581'),
                'content' =>  $this->getBody($postData),
            )
        ));

// Read the response using the Stream Context.
        $response = file_get_contents($url, false, $context);

        echo "<pre>";
        print_r($response);
        die;
    }


    public function testExcel(){
        $fileName=base_path() . '/public/sample.xlsx';

        Excel::load($fileName, function($doc) {

            $sheet = $doc->setActiveSheetIndex(0);
            $sheet->setCellValue('I1', '10');
            $sheet->setCellValue('J1', '11');
            $sheet->setCellValue('I2', '10');
            $sheet->setCellValue('J2', '11');
            $sheet->setCellValue('I3', '10');
            $sheet->setCellValue('J3', '11');
            $sheet->setCellValue('I4', '10');
            $sheet->setCellValue('J4', '11');


        })->download('xlsx');

//        Excel::filter('chunk')->load($fileName)->chunk(1000, function($results)
//        {
//            foreach($results as $key)
//            {
//                echo "<pre>";
//                print_r($key);
//                die;
//            }
//        });



//        $user_id=4;
//
//        Excel::create('User', function($excel) use ($user_id){
//            $excel->sheet('Sheet', function($sheet) use($user_id){
//
//                $user = EmployeeResumeModel::where('id', 4)->select('first_name', 'last_name')->get();
//            });
//        })->export('xls');
//
//        return "success";
    }




}
