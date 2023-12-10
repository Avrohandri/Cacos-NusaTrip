<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

require_once './controllers/DiscoverController.php';

$restAPI = new DiscoverController();

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        if(isset($_GET['id_destinasi']))
        {
            $id_destinasi = $_GET['id_destinasi'];
            $restAPI->getByIdDestinasi($id_destinasi);
        }
        else{
            $restAPI->getData();
        }
        break;
    case 'POST':
        $nama =  $_POST['nama'];
        $id_destinasi = $_POST['id_destinasi'];
        $deskripsi = $_POST['deskripsi'];
        $image = $_FILES['image'];
        if (isset($_POST['nama'], $_POST['id_destinasi'], $_FILES['image'], $_POST['deskripsi'])) {
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $restAPI->updateData($id, $nama,$id_destinasi, $image, $deskripsi);
            }
            else{
                $restAPI->saveData($nama,$id_destinasi, $image, $deskripsi);
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