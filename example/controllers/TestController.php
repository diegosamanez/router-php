<?php 

namespace controllers;

class TestController
{
    public function index(){
        include __DIR__ . "/../views/home_example.php";
    }

    public function paramRequestExample($id){
        include __DIR__ . "/../views/param_request_example.php";
    }

    public function formExample(){
        include __DIR__ . "/../views/form_example.php";
    }

    public function postExample($request, $file){
        include __DIR__ . "/../views/post_example.php";
    }

    public function error(){
        include __DIR__ . "/../views/error_example.php";
    }
}