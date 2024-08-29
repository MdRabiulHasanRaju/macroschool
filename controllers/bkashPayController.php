<?php
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

    include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $amount = validate($_POST['amount']);
    $order_id = validate($_POST['order_id']);
    $user_id = validate($_POST['user_id']);

    $amount_err = $order_id_err = $user_id = $course_id = "";

    if (empty(trim($_POST["amount"]))) {
        $amount_err = "Amount cannot be blank";
        $_SESSION["amount_err"] = $amount_err;
        header("location: " . LINK . "dashboard");
        die();
    }

    if (empty(trim($_POST["order_id"]))) {
        $order_id_err = "Order cannot be blank";
        $_SESSION["order_id_err"] = $order_id_err;
        header("location: " . LINK . "dashboard");
        die();
    }

    if (empty(trim($_POST["user_id"]))) {
        $user_id_err = "User cannot be blank";
        $_SESSION["user_id_err"] = $user_id_err;
        header("location: " . LINK . "dashboard");
        die();
    }


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
                "app_key" : "'.$app_key.'", 
                "app_secret" : "jcUNPBgbcqEDedNKdvE4G1cAK7D3hCjmJccNPZZBq96QIxxwAMEx"
                }',
        ]
    );
    $response = json_decode($response->getBody());
    $id_token = $response->id_token;
    $_SESSION['id_token'] = $response->id_token;
    // End Grant Token




    $InvoiceNumber = $order_id;
    // Strat Create Payment
    $auth = $id_token;
    $requestbody = array(
        'mode' => '0011',
        'amount' => $amount,
        'currency' => 'BDT',
        'intent' => 'sale',
        'payerReference' => $InvoiceNumber,
        'merchantInvoiceNumber' => $InvoiceNumber,
        'callbackURL' => $callbackURL
    );
    $url = curl_init($base_url . '/v1.2.0-beta/tokenized/checkout/create');
    $requestbodyJson = json_encode($requestbody);
    $header = array(
        'Content-Type:application/json',
        'Authorization:' . $auth,
        'X-APP-Key:' . $app_key
    );
    curl_setopt($url, CURLOPT_HTTPHEADER, $header);
    curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
    curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $resultdata = curl_exec($url);
    curl_close($url);
    $obj = json_decode($resultdata);
    header("Location: " . $obj->{'bkashURL'});
    // End Create Payment
    ob_end_flush();

} else {
    header("location: " . LINK . "login");
    die();
}
