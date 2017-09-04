<?php
require_once __DIR__.'/vendor/autoload.php';
require_once 'DbHandler.php';
require_once 'PassHash.php';
$app = new Silex\Application();
// Please set to false in a production environment
$app['debug'] = true;






$app->post('/add_guest', function (Silex\Application $app, Symfony\Component\HttpFoundation\Request $request) {
    $response = array();
    $name = $request->get('name');
    $email = $request->get('email');
    $address = $request->get('address');
    $message = $request->get('message');
     $ip = $request->get('ip');
    $browser = $request->get('client_browser');
    $os = $request->get('OSName');
    //print_r($_SERVER);die();
    $db = new DbHandler();
    $data=$db->add_info($name,$email,$address,$message,$ip,$browser,$os);
    if($data==1){
       $response["error"] = "false";
       $response["message"] = "Guest Inserted successfully";
               
        return json_encode($response);
    }else{
        $response["error"] = "false";
       $response["message"] = "smothing went wrong";
        return json_encode($response);
    }
    
    // Useful to return the newly added details
    // HTTP_CREATED = 200
    
});



$app->post('/get_result_per_page', function (Silex\Application $app, Symfony\Component\HttpFoundation\Request $request) {
    $response = array();
   $page_number = $request->get('page_number');
    $db = new DbHandler();
    $data=$db->get_data($page_number);
    
    if($data){
       $response["error"] = "false";
       $response["message"] = "Guest founded successfully";
       $response["data"] =$data;       
        return json_encode($response);
    }else{
        $response["error"] = "true";
       $response["message"] = "smothing went wrong";
        return json_encode($response);
    }
    
    // Useful to return the newly added details
    // HTTP_CREATED = 200
    
});
$app->run();