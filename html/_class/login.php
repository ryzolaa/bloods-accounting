<?php 
    class Login {

        public function verify_login($mail, $pass) {

            global $conn;
            
            $err_mail = null;
            $valid = (boolean) true;

            if (isset($_POST['login'])) {
                $mail = trim($mail);
                $pass = trim($pass);
        
                if ($valid) {
                    $req = $conn->prepare("SELECT pass
                        FROM user
                        WHERE mail = ?");
        
                    $req->execute(array($mail));
                    $req = $req->fetch();
        
                    if (isset($req['pass'])) {
        
                        if(!password_verify($pass, $req['pass'])) {
                            $valid = false;
                            $err_mail = 'La combinaison est incorecte!';
                        }
        
                    } else {
                        $valid = false;
                        $err_mail = 'La combinaison est incorecte!';
                    }
                } 
        
                if($valid) {
        
                    $req = $conn->prepare("SELECT *
                        FROM user
                        WHERE mail = ?");
        
                    $req->execute(array($mail));
        
                    $req_user = $req->fetch();
        
                    if (isset($req_user['id'])) {
        
                        $req->execute(array($req_user));
        
                    } else {
                        $valid = false;
                        $err_mail = 'La combinaison est incorecte!';
                    }
        
                    $_SESSION['id'] = $req_user['id'];
                    $_SESSION['pseudo'] = $req_user['pseudo'];
                    $_SESSION['mail'] = $req_user['mail'];
                    $_SESSION['role'] = $req_user['role'];

                    $date = date('d/m/Y H:i');
                    $req = $conn->prepare("UPDATE user SET date_connexion = ? WHERE id = ?");
                    $req->execute([$date, $_SESSION['id']]);
        
                    header('Location: accounting.php');
                    exit;
        
                } else {
                    $valid = false;
                    $err_mail = 'La combinaison ne correspond pas!';
                }
            } return [$err_mail];
        }
    }
?>