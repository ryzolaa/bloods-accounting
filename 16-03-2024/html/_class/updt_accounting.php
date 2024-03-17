<?php
require_once('../include.php');

if (isset($_POST['action'], $_POST['amount'], $_POST['reason'])) {
    $action = $_POST['action'];
    $amount = $_POST['amount'];
    $reason = $_POST['reason'];
    $user = $_SESSION['pseudo'];

    $total_query = "SELECT total FROM accounting ORDER BY id DESC LIMIT 1";
    $total_stmt = $conn->prepare($total_query);
    $total_stmt->execute();
    $total_result = $total_stmt->fetch(PDO::FETCH_ASSOC);
    $current_total = $total_result['total'];
    
    if ($action === 'add') {
        try {

            $new_total = $current_total + $amount;
            
            $accounting_query = "INSERT INTO accounting (total, op, reason, transac, user) VALUES (:total, :op, :reason, :transac, :user)";
            $accounting_stmt = $conn->prepare($accounting_query);
            $accounting_stmt->bindParam(':total', $new_total, PDO::PARAM_STR);
            $accounting_stmt->bindValue(':op', 'approvisionnement', PDO::PARAM_STR);
            $accounting_stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
            $accounting_stmt->bindValue(':transac', "+" . $amount, PDO::PARAM_STR);
            $accounting_stmt->bindParam(':user', $user, PDO::PARAM_STR);
            $accounting_stmt->execute();
            
        } catch (PDOException $e) {
            echo 'Erreur SQL : ' . $e->getMessage();
        }

    } elseif ($action === 'remove') {        
        try {
            $new_total = $current_total - $amount;
            
            $accounting_query = "INSERT INTO accounting (total, op, reason, transac, user) VALUES (:total, :op, :reason, :transac, :user)";
            $accounting_stmt = $conn->prepare($accounting_query);
            $accounting_stmt->bindParam(':total', $new_total, PDO::PARAM_STR);
            $accounting_stmt->bindValue(':op', 'retrait', PDO::PARAM_STR);
            $accounting_stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
            $accounting_stmt->bindValue(':transac', "-" . $amount, PDO::PARAM_STR);
            $accounting_stmt->bindParam(':user', $user, PDO::PARAM_STR);
            $accounting_stmt->execute();
            
        } catch (PDOException $e) {
            echo 'Erreur SQL : ' . $e->getMessage();
        }
    }
    header('Location: ../accounting.php');
    exit();
}
?>