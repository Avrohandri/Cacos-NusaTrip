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

class DiscoverController extends Database{
    public function getData(){
        $query = $this->pdo->prepare("SELECT * FROM discover");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        if($data){
            http_response_code(200);
            return sendResponse("success", "Data berhasil diambil", $data);
        }else{
            http_response_code(200);
            return sendResponse("success","Data kosong",$data);
        }
    }

    public function saveData($nama,$id_destinasi, $image, $deskripsi){
        $queryDestinasi = $this->pdo->prepare('SELECT nama FROM destinasi WHERE id_destinasi = ?');
        $queryDestinasi->execute([$id_destinasi]);
        $destinasi = $queryDestinasi->fetchColumn();
        if(!$destinasi){
            http_response_code(404);
            return sendResponse("error","Data destinasi tidak ditemukan");
        }

        $pathbackground = './images/discover/';
        $uniqueFileName = time() . '_' . $nama . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        move_uploaded_file($image['tmp_name'], $pathbackground . $uniqueFileName);



        $query = $this->pdo->prepare("INSERT INTO discover (nama, id_destinasi, destinasi, image, deskripsi) values (?,?,?,?,?)");
        $ress = $query->execute([$nama, $id_destinasi, $destinasi, $uniqueFileName, $deskripsi]);
        if($ress){
            $data = [
                'nama' => $nama,
                'id_destinasi'=> $id_destinasi,
                'destinasi'=> $destinasi,
                'deskripsi'=> $deskripsi,
                'image'=> $uniqueFileName
            ];
            return sendResponse("success","Data berhasil disimpan", $data);
        }else{
            return sendResponse("error","Data gagal disimpan");
        }
    }

    public function deleteData($id){
        $uploadDirectory = './images/discover/';
    
        $queryImages = $this->pdo->prepare("SELECT image FROM discover WHERE id_discover = ?");
        $queryImages->execute([$id]);
        $image = $queryImages->fetchColumn();
    
        if ($image) {
            $imageFilePath = $uploadDirectory . $image;
    
            if (is_file($imageFilePath)) {
                unlink($imageFilePath);

                $query = $this->pdo->prepare("DELETE FROM discover WHERE id_discover = ?");
                $ress = $query->execute([$id]);
    
                if($ress){
                    return sendResponse("success","Data berhasil dihapus");
                } else {
                    return sendResponse("error","Data gagal dihapus dari database");
                }
            } else {
                return sendResponse("error","Gambar tidak ditemukan");
            }
        } else {
            return sendResponse("error","Data tidak ditemukan");
        }
    }
    
    
    public function updateData($id, $nama, $id_destinasi, $image, $deskripsi){
        $uploadDirectory = './images/discover/';
    
        // Check if the destination exists
        $queryDestinasi = $this->pdo->prepare('SELECT destinasi FROM discover WHERE id_destinasi = ?');
        $queryDestinasi->execute([$id_destinasi]);
        $destinasi = $queryDestinasi->fetchColumn();
    
        if(!$destinasi){
            http_response_code(404);
            return sendResponse("error", "Data destinasi tidak ditemukan");
        }
    
        $queryImages = $this->pdo->prepare("SELECT image FROM discover WHERE id_discover = ?");
        $queryImages->execute([$id]);
        $imageOld = $queryImages->fetchColumn();
    
        // If there's an old image, delete it
        if ($imageOld) {
            $oldImageFilePath = $uploadDirectory . $imageOld;
            if (is_file($oldImageFilePath)) {
                unlink($oldImageFilePath);
            }
        }
    
        // If there's a new image, upload it
        if ($image) {
            $uniqueFileName = time() . '_' . $image['name'];
            move_uploaded_file($image['tmp_name'], $uploadDirectory . $uniqueFileName);
        }
    
        // Update data in the database
        $query = $this->pdo->prepare("UPDATE discover SET nama=?, id_destinasi=?, destinasi=?, image=?, deskripsi=? WHERE id_discover=?");
        $ress = $query->execute([$nama, $id_destinasi, $destinasi, $uniqueFileName ?? $imageOld, $deskripsi, $id]);
    
        if ($ress) {
            $data = [
                'nama' => $nama,
                'id_destinasi' => $id_destinasi,
                'destinasi' => $destinasi,
                'deskripsi' => $deskripsi,
                'image' => $uniqueFileName ?? $imageOld,
            ];
            return sendResponse("success", "Data berhasil diubah", $data);
        } else {
            return sendResponse("error", "Data gagal diubah di database");
        }
    }
    
    
    public function getByIdDestinasi($id_destinasi){
        $query = $this->pdo->prepare("SELECT * FROM discover WHERE id_destinasi = ?");
        $query->execute([$id_destinasi]);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        if($data){
            return sendResponse("success","Data Berhasil Diambil", $data);
        }else{
            http_response_code(404);
            return sendResponse("error","Data tidak ditemukan");
        }
    }
    
}

?>