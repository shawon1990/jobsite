<?php
namespace App\Http\Controllers\coreBaseClass;


Class WalletMix {

    private $service_access_username;
    private $service_access_password;
    private $merchant_id;
    private $access_app_key;
    private $shipping_charge;
    private $discount;
    private $merchant_order_id;
    private $app_name;
    private $callback_url;
    private $currency;
    private $transaction_related_params = array();
    private $extra_data;
    private $product_description;
    private $amount;
    private $server_details_url;
    private $check_payment_url;
    private $database_driver;

    public function walletmix($service_access_username, $service_access_password, $merchant_id, $access_app_key) {
        $this->service_access_username = $service_access_username;
        $this->service_access_password = $service_access_password;
        $this->merchant_id = $merchant_id;
        $this->access_app_key = $access_app_key;
        $this->amount = 0;
        $this->product_description = '';

        /**
         * Sandbox
         */

//        $this->server_details_url = 'http://sandbox.walletmix.com/check-server';
//        $this->check_payment_url = 'http://sandbox.walletmix.com/check-payment';

        /**
         * Live
         */
        $this->server_details_url = 'https://epay.walletmix.com/check-server';
        $this->check_payment_url = 'https://epay.walletmix.com/check-payment';
    }
    public function set_shipping_charge($shipping_charge) {
        $this->shipping_charge = $shipping_charge;
    }
    public function set_discount($discount) {
        $this->discount = $discount;
    }
    public function set_product_description($products) {
        $quantity = 0;
        foreach($products as $product) {
            $price = $product['price'];
            $total_price = $product['quantity']*$price;
            $this->product_description .= '{'.$product['quantity'] . 'x' . $product['name'] . '['.$price.']=['.$total_price.']}+';
            $quantity += $product['quantity'];
            $this->amount += $total_price;
        }
        $this->amount = $this->amount+$this->shipping_charge-$this->discount;
        $this->product_description.='{shipping rate:'.$this->shipping_charge.'}-{discount amount:'.$this->discount.'}='.number_format( $this->amount, 2, '.', '' );

        return $this->product_description;
    }
    public function set_merchant_order_id($merchant_order_id) {
        $this->merchant_order_id = $merchant_order_id;
    }
    public function set_app_name($app_name) {
        $this->app_name = $app_name;
    }
    public function set_currency($currency) {
        $this->currency = $currency;
    }
    public function set_callback_url($url) {
        $this->callback_url = $url;
    }
    public function set_extra_json($extra_data) {
        $this->extra_data = json_encode($extra_data);
    }
    public function get_auth() {
        $encodeValue = base64_encode($this->service_access_username.':'.$this->service_access_password);
        $auth = 'Basic '.$encodeValue;
        return $auth;
    }
    public function get_options_value() {
        $options  = base64_encode('s='.$_SERVER['HTTP_HOST'].',i='.$_SERVER['SERVER_ADDR']);
        return $options;
    }
    public function get_cart_info() {
        $cart_info = $this->merchant_id.','.$_SERVER['HTTP_HOST'].','.$this->app_name;
        return $cart_info;
    }
    public function get_product_description() {
        return $this->product_description;
    }
    public function get_extra_json() {
        return $this->extra_data;
    }
    public function set_transaction_related_params($data) {
        $this->transaction_related_params['wmx_id'] = $this->merchant_id;
        $this->transaction_related_params['app_name'] = $this->app_name;
        $this->transaction_related_params['access_app_key'] = $this->access_app_key;
        $this->transaction_related_params['authorization'] = self::get_auth();
        $this->transaction_related_params['options'] = self::get_options_value();
        $this->transaction_related_params['callback_url'] = $this->callback_url;
        $this->transaction_related_params['currency'] = $this->currency;
        $this->transaction_related_params['merchant_order_id'] = $this->merchant_order_id;
        $this->transaction_related_params['merchant_ref_id'] = uniqid();
        $this->transaction_related_params['amount'] = $this->amount;
        $this->transaction_related_params['cart_info'] = self::get_cart_info();
        $this->transaction_related_params['product_desc'] = self::get_product_description();
        $this->transaction_related_params['extra_json'] = self::get_extra_json();
        foreach($data as $key=>$value){
            $this->transaction_related_params[$key] = $value;
        }
        return $this->transaction_related_params;
    }
    public function send_data_to_walletmix() {
        $getServerDetails = json_decode(self::curl_request_get($this->server_details_url));

        if($getServerDetails->selectedServer){
            $wmx_response = self::curl_request_post($getServerDetails->url,$this->transaction_related_params);
            $wmx_response_d = json_decode($wmx_response);


            return $wmx_response_d;




        }else{
            echo 'Server Two Temporary Down. Please Try After Sometime.';
        }
    }


    public function send_data_to_walletmix_second_step($token){

        $getServerDetails = json_decode(self::curl_request_get($this->server_details_url));

        $data = array('wmx_id'=>$this->merchant_id, 'authorization'=>self::get_auth(),'access_app_key'=>$this->access_app_key,'token'=>$token,'amount'=>$this->amount);

        if($this->database_driver == 'txt'){
            self::write_file($data);
        }elseif($this->database_driver == 'session'){
            self::reset_ression('wmx_token');
            self::reset_ression('amount');

            self::put_session('wmx_token',$token);
            self::put_session('amount',$this->amount);
        }
        $wmx_url = $getServerDetails->bank_payment_url."/".$token;
        header("Location:".$wmx_url);
        exit;
    }

    public function curl_request_get($url) {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST, 'GET');
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function curl_request_post($url,$params) {
        $postData = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch,CURLOPT_POST, count($postData));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $postData);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    public function write_file($data) {
        $file_name = fopen("data.txt", "w") or die("Unable to open file!");
        $data = json_encode($data);
        fwrite($file_name, $data);
        fclose($file_name);
    }
    public function check_payment($params) {
        $wmx_response = self::curl_request_post($this->check_payment_url,$params);
        return $wmx_response;
    }
    public function read_file() {
        $file_name = fopen("data.txt", "r") or die("Unable to open file!");
        $data =  fread($file_name,filesize("data.txt"));
        fclose($file_name);
        return $data;
    }
    public function read_data() {
        $data = array(
            'wmx_id'        =>  $this->merchant_id,
            'authorization' =>  self::get_auth(),
            'access_app_key'=>  $this->access_app_key,
            'token'         =>  self::get_session('wmx_token'),
            'amount'        =>  self::get_session('amount')
        );
        return json_encode($data);
    }

    public function put_session($key,$value){
        $_SESSION[$key] = $value;
    }
    public function set_database_driver($option){
        if($option == 'session'){
            self::start_session();
        }
        $this->database_driver = $option;
    }
    public function get_database_driver(){
        return $this->database_driver;
    }
    public function get_session($key){
        return $_SESSION[$key];
    }
    public function start_session(){
        if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    }
    public function reset_ression($key){
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
    }
    public function debug($data,$die = false) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if($die){die();}
    }


}