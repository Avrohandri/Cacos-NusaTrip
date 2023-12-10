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

class DestinasiController extends Database{
    public function getData(){
        $query = $this->pdo->prepare("SELECT * FROM destinasi");
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

    public function saveData($nama, $subtitle, $image, $deskripsi, $background_image){
        $uploadDirectory = './images/';
        $pathbackground = './images/background/';
        $uniqueFileName1 = time() . '_' . $nama . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $uniqueFileName2 = time() . '_background_' . $nama . '.' . pathinfo($background_image['name'], PATHINFO_EXTENSION);
        move_uploaded_file($image['tmp_name'], $uploadDirectory . $uniqueFileName1);
        move_uploaded_file($background_image['tmp_name'], $pathbackground . $uniqueFileName2);

        $query = $this->pdo->prepare("INSERT INTO destinasi (nama, subtitle, image, deskripsi, background_image) values (?,?,?,?,?)");
        $ress = $query->execute([$nama, $subtitle, $uniqueFileName1, $deskripsi,$uniqueFileName2]);
        if($ress){
            $data = [
                'nama' => $nama,
                'subtitle'=> $subtitle,
                'deskripsi'=> $deskripsi,
                'image'=> $uniqueFileName1,
                'background_image'=> $uniqueFileName2
            ];
            return sendResponse("success","Data berhasil disimpan", $data);
        }else{
            return sendResponse("error","Data gagal disimpan");
        }
    }

    public function deleteData($id){
        $uploadDirectory = './images/';
        $pathBackground = './images/background/';

        $queryImages = $this->pdo->prepare("SELECT image, background_image FROM destinasi WHERE id_destinasi = ?");
        $queryImages->execute([$id]);
        $images = $queryImages->fetch(PDO::FETCH_ASSOC);
    
        if ($images) {
            if (!empty($images['image'])) {
                $imageFilePath = $uploadDirectory . $images['image'];
                if (is_file($imageFilePath)) {
                    unlink($imageFilePath);
                }
            }
    
            if (!empty($images['background_image'])) {
                $backgroundFilePath = $pathBackground . $images['background_image'];
                if (is_file($backgroundFilePath)) {
                    unlink($backgroundFilePath);
                }
            }
    
            $query = $this->pdo->prepare("DELETE FROM destinasi WHERE id_destinasi = ?");
            $ress = $query->execute([$id]);
    
            if($ress){
                return sendResponse("success","Data berhasil dihapus");
            } else {
                return sendResponse("error","Data gagal dihapus dari database");
            }
        } else {
            return sendResponse("error","Data tidak ditemukan");
        }
    }
    
    public function updateData($id, $nama, $subtitle, $image, $deskripsi, $background_image){
        $uploadDirectory = './images/';
        $pathBackground = './images/background/';
    
        $queryImage = $this->pdo->prepare("SELECT image, background_image FROM destinasi WHERE id_destinasi = ?");
        $queryImage->execute([$id]);
        $oldImages = $queryImage->fetch(PDO::FETCH_ASSOC);
    
        if ($oldImages !== false) {
            if (!empty($oldImages['image'])) {
                $oldImageFilePath = $uploadDirectory . $oldImages['image'];
                if (is_file($oldImageFilePath)) {
                    unlink($oldImageFilePath);
                }
            }
    
            if (!empty($oldImages['background_image'])) {
                $oldBackgroundFilePath = $pathBackground . $oldImages['background_image'];
                if (is_file($oldBackgroundFilePath)) {
                    unlink($oldBackgroundFilePath);
                }
            }
    
            if ($image) {
                $uniqueFileName = time() . '_' . $image['name'];
                move_uploaded_file($image['tmp_name'], $uploadDirectory . $uniqueFileName);
            }
    
            if ($background_image) {
                $uniqueBackgroundFileName = time() . '_background_' . $background_image['name'];
                move_uploaded_file($background_image['tmp_name'], $pathBackground . $uniqueBackgroundFileName);
            }
    
            // Update data di database
            $query = $this->pdo->prepare("UPDATE destinasi SET nama=?, subtitle=?, image=?, background_image=?, deskripsi=? WHERE id_destinasi=?");
            $ress = $query->execute([$nama, $subtitle, $uniqueFileName ?? $oldImages['image'], $uniqueBackgroundFileName ?? $oldImages['background_image'], $deskripsi, $id]);
    
            if ($ress) {
                $data = [
                    'nama' => $nama,
                    'subtitle' => $subtitle,
                    'image' => $uniqueFileName ?? $oldImages['image'],
                    'background_image' => $uniqueBackgroundFileName ?? $oldImages['background_image'],
                    'deskripsi' => $deskripsi
                ];
                return sendResponse("success", "Data berhasil diubah", $data);
            } else {
                return sendResponse("error", "Data gagal diubah di database");
            }
        } else {
            return sendResponse("error", "Data tidak ditemukan");
        }
    }
    
    public function getById($id){
        $query = $this->pdo->prepare("SELECT * FROM destinasi WHERE id_destinasi = ?");
        $query->execute([$id]);
        $ress = $query->fetch(PDO::FETCH_ASSOC);
        if($ress){
            return sendResponse("success","Data Berhasil Diambil", $ress);
        }else{
            http_response_code(404);
            return sendResponse("error","Data tidak ditemukan");
        }
    }
    
}

?>