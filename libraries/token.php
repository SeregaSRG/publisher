<?php
class Token {
    static function generate() {
        return hash('sha512', uniqid(rand(), true));
    }

    static function start($id) {
        global $pdo;

        $token  = self::generate();
        $device = $_SERVER['HTTP_USER_AGENT'];

        $QueryById = $pdo->prepare(
            "UPDATE tokens SET `closed`='1' WHERE `user_id`= :id"
        );
        $QueryById->execute([
            ':id'   => $id
        ]);

        $insertToken = $pdo->prepare(
            "INSERT INTO `tokens` (`user_id`,`token`, `device`) VALUES (:id, :token, :device)"
        );
        $insertToken->execute([
            ':id'     => $id,
            ':token'  => $token,
            ':device' => $device
        ]);

        $_SESSION['token'] = $token;
    }

    static function checkSuccess($token) {
        global $pdo;

        $result = [];

        if ( self::checkToken($token) ) {
            $user_id = self::getId($token);

            $isUserQuery = $pdo->prepare(
                "SELECT level, name FROM `users` WHERE id = :user_id"
            );
            $isUserQuery->execute([
                ':user_id'  => $user_id
            ]);

            $userData = $isUserQuery->fetch(PDO::FETCH_ASSOC);

            $result['code'] = 1;
            $result['name'] = $userData['name'];
            $result['level'] = $userData['level'];
        } else {
            // не валидный токен
            $result['code'] = -2;
        }
        
        return $result;
    }

    static function insert($id, $token, $type) {
        global $pdo;
        
        $QueryById = $pdo->prepare(
            "UPDATE tokens SET `closed`='1' WHERE `user_id`= :id AND `type` = :type"
        );
        $QueryById->execute([
            ':id'   => $id,
            ':type' => $type
        ]);
         
        $insertToken = $pdo->prepare(
            "INSERT INTO `tokens` (`user_id`,`token`, `type`) VALUES (:id, :token, :type)"
        );
        $insertToken->execute([
            ':id' => $id,
            ':token' => $token,
            ':type' => $type
        ]);
    }

    static function checkToken($token) {
        global $pdo;

        $QueryByToken = $pdo->prepare(
            "SELECT * FROM `tokens` WHERE `token` = :token AND `closed` = '0'"
        );
        $QueryByToken->execute([
            ':token' => $token
        ]);

        if ($QueryByToken) {
            if ($QueryByToken->rowCount()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            // TODO Обработка ошибок базы данных
            print_r($QueryByToken->errorInfo());
            return FALSE;
        }
    }

    static function close($token, $type) {
        global $pdo;

        $QueryById = $pdo->prepare(
            "UPDATE tokens SET `closed`='1' WHERE `token`= :token"
        );
        $QueryById->execute([
            ':token' => $token
        ]);
    }
    
    static function getId ($token){
        global $pdo;

        $tokeQuery = $pdo->prepare(
            "SELECT * FROM `tokens` WHERE token= :token AND closed='0'"
        );
        $tokeQuery->execute([
            ':token' => $token
        ]);

        if($tokeQuery->rowCount()) {
            return $tokeQuery->fetch()->user_id;
        } else {
            return -1;
        }
    }
}