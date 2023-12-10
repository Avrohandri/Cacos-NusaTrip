<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

require_once './controllers/DestinasiController.php';

$restAPI = new DestinasiController();

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $restAPI->getById($id);
        }
        else{
            $restAPI->getData();
        }
        break;
    case 'POST':
        $nama =  $_POST['nama'];
        $subtitle = $_POST['subtitle'];
        $deskripsi = $_POST['deskripsi'];
        $image = $_FILES['image'];
        $background_image = $_FILES['background_image'];
        if (isset($_POST['nama'], $_POST['subtitle'], $_FILES['image'], $_POST['deskripsi'],$_FILES['background_image'])) {
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $restAPI->updateData($id, $nama, $subtitle, $image, $deskripsi, $background_image);
            }
            else{
                $restAPI->saveData($nama, $subtitle,$image,$deskripsi, $background_image);
            }
        }else{
            http_response_code(400);
            echo json_encode(['error' => 'Data tidak lengkap']);
        }
        break;
    case 'DELETE':
        $id = $_GET['id'];
        $restAPI->deleteData($id);
        break;
    default:
        break;
}