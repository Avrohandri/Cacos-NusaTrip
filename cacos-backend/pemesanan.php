<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

require_once './controllers/PemesananController.php';

$restAPI = new PemesananController();

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            $db->getMenuResto($id);
        }
        else{
            $restAPI->getData();
        }
        break;
    case 'POST':
        $nama =  $_POST['nama'];
        $no_telepon = $_POST['no_telepon'];
        $destinasi = $_POST['destinasi'];
        $tanggal_pemesanan = $_POST['tanggal_pemesanan'];
        $restAPI->saveData($nama, $no_telepon,$destinasi,$tanggal_pemesanan);
        break;
    case 'DELETE':
        $id = $_GET['id'];
        $restAPI->deleteData($id);
        break;
    case 'PUT':
        $requestData = json_decode(file_get_contents('php://input'), true);
        if (isset($requestData['nama'], $requestData['no_telepon'], $requestData['destinasi'], $requestData['tanggal_pemesanan'])) {
            $id = $_GET['id'];
            $nama = $requestData['nama'];
            $no_telepon = $requestData['no_telepon'];
            $destinasi = $requestData['destinasi'];
            $tanggal_pemesanan = $requestData['tanggal_pemesanan'];
            $restAPI->updateData($id, $nama, $no_telepon, $destinasi, $tanggal_pemesanan);
        }else{
            http_response_code(400);
            echo json_encode(['error' => 'Data tidak lengkap']);
        }
    default:
        break;
}