<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;

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

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
