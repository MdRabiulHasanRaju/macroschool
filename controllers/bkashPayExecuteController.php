<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {


    include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";

    require_once('bkashPay/vendor/autoload.php');

    $callbackURL = LINK . 'controllers/bkashPayExecuteController.php';

    $app_key = '0vWQuCRGiUX7EPVjQDr0EUAYtc';
    $app_secret = 'jcUNPBgbcqEDedNKdvE4G1cAK7D3hCjmJccNPZZBq96QIxxwAMEx';
    $username = '01770618567';
    $password = 'D7DaC<*E*eG';
    $base_url = 'https://tokenized.sandbox.bka.sh';

    // Start Grant Token
    $client = new \GuzzleHttp\Client();
    $response = $client->request(
        'POST',
        $base_url . '/v1.2.0-beta/tokenized/checkout/token/grant',
        [
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'password' => $password,
                'username' => $username,
            ],
            'body' =>
            '{
                "app_key" : "0vWQuCRGiUX7EPVjQDr0EUAYtc", 
                "app_secret" : "jcUNPBgbcqEDedNKdvE4G1cAK7D3hCjmJccNPZZBq96QIxxwAMEx"
                }',
        ]
    );
    $response = json_decode($response->getBody());
    $id_token = $response->id_token;
    // End Grant Token


    // execute payment
    if (isset($_GET['paymentID'], $_GET['status']) && $_GET['status'] == 'success') {
        $paymentID = $_GET['paymentID'];
        $auth = $id_token;
        $post_token = array('paymentID' => $paymentID);
        $url = curl_init($base_url . '/v1.2.0-beta/tokenized/checkout/execute');
        $posttoken = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            'Authorization:' . $auth,
            'X-APP-Key:' . $app_key,
            'Accept:application/json',
        );
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $posttoken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);
        $obj = json_decode($resultdata);

        $customerMsisdn = $obj->customerMsisdn;
        $paymentID = $obj->paymentID;
        $trxID = $obj->trxID;
        $merchantInvoiceNumber = $obj->merchantInvoiceNumber;
        $time = $obj->paymentExecuteTime;
        $transactionStatus = $obj->transactionStatus;
        $amount = $obj->amount;
        $statusMessage = $obj->statusMessage;

        //print_r($obj);
        //die();

        $order_sql = "insert into `payment_transaction`(user_id,customerNumber,paymentID,trxID,InvoiceNumber, transactionStatus, amount,statusMessage,time) values(?,?,?,?,?,?,?,?,?)";
        $order_stmt = mysqli_prepare($connection, $order_sql);
        mysqli_stmt_bind_param(
            $order_stmt,
            "issssssss",
            $param_user_id,
            $param_customerNumber,
            $param_paymentID,
            $param_trxID,
            $param_InvoiceNumber,
            $param_transactionStatus,
            $param_amount,
            $param_statusMessage,
            $param_time
        );

        $param_user_id = $_SESSION['id'];
        $param_customerNumber = $customerMsisdn;
        $param_paymentID = $paymentID;
        $param_trxID = $trxID;
        $param_InvoiceNumber = $merchantInvoiceNumber;
        $param_transactionStatus = $transactionStatus;
        $param_amount = $amount;
        $param_statusMessage = $statusMessage;
        $param_time = $time;

        if (mysqli_stmt_execute($order_stmt)) {
            // echo "success";

            $insert_sql = "UPDATE `order` SET status=? WHERE id=?";
            $insert_stmt = mysqli_prepare($connection, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "ii", $param_status, $param_id);
            $param_status = '2';
            $param_id = (substr($merchantInvoiceNumber, 3));
            mysqli_stmt_execute($insert_stmt);

            header("location: " . LINK . "dashboard");
        }
    } else {
        header("location: " . LINK . "dashboard");
    }
    // execute payment

} else {
    header("location: " . LINK . "login");
    die();
}
