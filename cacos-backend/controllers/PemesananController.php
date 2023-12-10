<?php  

require_once 'database.php';

function sendResponse($status, $message, $data = null) {
    $response = array(
        "status" => $status,
        "message" => $message,
        "data" => $data
    );
    echo json_encode($response);
}


class PemesananController extends Database{
    public function getData(){
        $query = $this->pdo->prepare("SELECT * FROM pemesanan");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        if($data){
            http_response_code(200);
            return sendResponse("success", "Data berhasil diambil", $data);
        }else{
            http_response_code(500);
            return sendResponse("error","Gagal mengambil data");
        }
    }

    public function saveData($nama, $no_telepon, $destinasi, $tanggal_pemesanan){
        $query = $this->pdo->prepare("INSERT INTO pemesanan (nama, no_telepon, destinasi, tanggal_pemesanan) values (?,?,?,?)");
        $ress = $query->execute([$nama, $no_telepon, $destinasi, $tanggal_pemesanan,]);
        if($ress){
            $data = [
                'nama' => $nama,
                'no_telepon'=> $no_telepon,
                'destinasi' => $destinasi,
                'tanggal_pemesanan' => $tanggal_pemesanan
            ];
            http_response_code(200);
            return sendResponse("success","Data berhasil disimpan", $data);
        }else{
            http_response_code(400);
            return sendResponse("error","Data gagal disimpan");
        }
    }

    public function deleteData($id){
        $query = $this->pdo->prepare("DELETE FROM pemesanan WHERE id_pemesanan = ?");
        $ress = $query->execute([$id]);

        if($ress){
            http_response_code(200);
            return sendResponse("success","Data berhasil dihapus");
        }else{
            http_response_code(400);
            return sendResponse("error","Data gagal dihapus");
        }
    }

    public function updateData($id, $nama, $no_telepon, $destinasi, $tanggal_pemesanan){
        $query = $this->pdo->prepare("UPDATE pemesanan SET nama=?, no_telepon=?, destinasi=?, tanggal_pemesanan=? WHERE id_pemesanan=?");
        $ress = $query->execute([$nama, $no_telepon, $destinasi, $tanggal_pemesanan, $id]);

        if($ress){
            $data = [
                'nama' => $nama,
                'no_telepon'=> $no_telepon,
                'destinasi' => $destinasi,
                'tanggal_pemesanan' => $tanggal_pemesanan
            ];
            http_response_code(200);
            return sendResponse("success","Data berhasil diubah", $data);
        }else{
            http_response_code(400);
            return sendResponse("error","Data gagal dihapus");
        }
    }

}

?>