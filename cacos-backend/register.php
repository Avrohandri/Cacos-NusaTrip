<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

require_once './controllers/UsersController.php';

$restAPI = new UsersController();

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $username =  $_POST['username'];
        $password = $_POST['password'];
        $restAPI->register($username, $password);
        break;
    default:
        break;
}