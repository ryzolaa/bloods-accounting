<?php 
    class Register {

        public function verify_register($pseudo, $mail, $pass, $passConf) {

            global $conn;
            
            $pseudo = (String) trim($pseudo);
            $mail = (String) trim($mail);
            $pass = (String) trim($pass);
            $passConf = (String) trim($passConf);

            $err_pseudo = null;
            $err_mail = null;
            $err_pass = null;
            $valid = (boolean) true;

            if (mb_strlen($pseudo, 'UTF-8') > 20) {
                $valid = false;
                $err_pseudo = 'Le ne peut pas faire plus de 20 caractères!';
            } else {
                $req = $conn->prepare("SELECT id
                    FROM user
                    WHERE pseudo = ?");
    
                $req->execute(array($pseudo));
                $req = $req->fetch();
    
                if (isset($req['id'])) {
                    $valid = false;
                    $err_pseudo = 'Ce pseudo est déjà pris!';
                }
            }
            if($valid) {
                if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
                    $valid = false;
                    $err_mail = 'Format du mail invalide!';
        
                } else {
                    $req = $conn->prepare("SELECT id
                    FROM user
                    WHERE mail = ?");
        
                    $req->execute(array($mail));
                    $req = $req->fetch();
        
                    if (isset($req['id'])) {
                        $valid = false;
                        $err_mail = 'Ce mail est déjà pris!';
                    }
                }
            }

            if($valid) {
                if ($pass <> $passConf) {
                    $valid = false;
                    $err_pass = 'Le mot de passe ne correspond pas!';
                }  
            }

    
            if($valid) {
                $crypt_pass = password_hash($pass, PASSWORD_DEFAULT);
                $date_creation = date('Y-m-d H:i:s');

                $req = $conn->prepare("INSERT INTO user(pseudo, mail, pass, date_creation, date_connexion) VALUES (?, ?, ?, ?, ?)");
                $req->execute(array($pseudo, $mail, $crypt_pass, $date_creation, $date_creation));
    
                header('Location: login.php');
                exit;
    
            } return [$err_pseudo, $err_mail, $err_pass];
        }
    }
?>