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


class UsersController extends Database{
    public function register($username, $password) {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = $this->pdo->prepare("INSERT INTO users (username, password, token) VALUES (?, ?, ?)");
        $ress = $query->execute([$username, $hashPassword, ""]);
        if ($ress) {
            $data = [
                "username"=> $username,
                "password"=> $hashPassword,
            ];
            http_response_code(200);
            return sendResponse("success","Berhasil registrasi", $data);
        }else{
            http_response_code(400);
            return sendResponse("error","Gagal registrasi");
        }
    }

    public function login($username, $password) {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute([$username]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $token = bin2hex(random_bytes(32));
            $updateTokenQuery = $this->pdo->prepare("UPDATE users SET token = ? WHERE id_user = ?");
            $updateTokenQuery->execute([$token, $user['id_user']]);
            $data = [
                "username"=> $username,
                "password"=> $user['password'],
                'token'=> $token,
            ];
            http_response_code(200);
            return sendResponse("success","Berhasil registrasi", $data);
        }else{
            http_response_code(404);
            return sendResponse("error","User tidak ditemukan");
        }
    }
    

}

?>