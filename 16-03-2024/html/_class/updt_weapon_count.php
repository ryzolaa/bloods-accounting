<?php
require_once('../include.php');

if (isset($_POST['action'], $_POST['id'], $_POST['weapon'], $_POST['price'], $_POST['sell_price'], $_POST['quantity'])) {
    $action = $_POST['action'];
    $weapon_id = $_POST['id'];
    $weapon_name = $_POST['weapon'];
    $weapon_quantity = $_POST['quantity'];
    $user = $_SESSION['pseudo'];
    
    $weapons = "SELECT amount FROM weapon WHERE id = :id";
    $weaponsreq = $conn->prepare($weapons);
    $weaponsreq->bindParam(':id', $weapon_id, PDO::PARAM_INT);
    $weaponsreq->execute();
    $row = $weaponsreq->fetch(PDO::FETCH_ASSOC);

    if (empty($_POST['sell_price'])) {
        $weapon_price = $_POST['price'] * $weapon_quantity;
    } else {
        $weapon_price = $_POST['sell_price'] * $weapon_quantity;
    }

    if ($action === 'add') {
        $query = "UPDATE weapon SET amount = amount + $weapon_quantity WHERE id = :id";
        $log_type = "+$weapon_quantity"; // Ajout
        $new_stock = $row['amount'] + $weapon_quantity;
    } elseif ($action === 'remove') {
        $query = "UPDATE weapon SET amount = amount - $weapon_quantity WHERE id = :id";
        $log_type = "-$weapon_quantity"; // Retrait
        $new_stock = $row['amount'] - $weapon_quantity;
        
        try {
            $total_query = "SELECT total FROM accounting ORDER BY id DESC LIMIT 1";
            $total_stmt = $conn->prepare($total_query);
            $total_stmt->execute();
            $total_result = $total_stmt->fetch(PDO::FETCH_ASSOC);
            $current_total = $total_result['total'];
            $new_total = $current_total + $weapon_price;
            
            $accounting_query = "INSERT INTO accounting (total, op, reason, transac, user) VALUES (:total, :op, :reason, :transac, :user)";
            $accounting_stmt = $conn->prepare($accounting_query);
            $accounting_stmt->bindParam(':total', $new_total, PDO::PARAM_STR);
            $accounting_stmt->bindValue(':op', $log_type . " " . $weapon_name, PDO::PARAM_STR);
            $accounting_stmt->bindValue(':reason', 'vente', PDO::PARAM_STR);
            $accounting_stmt->bindValue(':transac', "+" . $weapon_price, PDO::PARAM_STR);
            $accounting_stmt->bindParam(':user', $user, PDO::PARAM_STR);
            $accounting_stmt->execute();
            
        } catch (PDOException $e) {
            echo 'Erreur SQL : ' . $e->getMessage();
        }
    }
    $if_weapon_add = '0';
    
    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $weapon_id, PDO::PARAM_INT);
        $stmt->execute();

        $date = date("Y-m-d H:i:s");
        $log_query = "INSERT INTO weapon_logs (stock, type, item, sell_price, user, date) VALUES (:stock, :type, :item, :sell_price, :user, :date)";
        $log_stmt = $conn->prepare($log_query);

        $log_stmt->bindParam(':stock', $new_stock, PDO::PARAM_STR);
        $log_stmt->bindParam(':type', $log_type, PDO::PARAM_STR);
        $log_stmt->bindParam(':item', $weapon_name, PDO::PARAM_STR);
        if($action === 'add') {
            $log_stmt->bindParam(':sell_price', $if_weapon_add, PDO::PARAM_STR);
        } else {
            $log_stmt->bindParam(':sell_price', $weapon_price, PDO::PARAM_STR);
        }
        $log_stmt->bindParam(':user', $user, PDO::PARAM_STR);
        $log_stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $log_stmt->execute();

        header('Location: ../accounting.php');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur SQL : ' . $e->getMessage();
    }
}
?>