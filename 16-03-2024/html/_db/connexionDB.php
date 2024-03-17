<?php
function connectToDatabase() {
    $host = '';
    $dbname = '';
    $username = '';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        // En cas d'erreur, afficher le message d'erreur et arrêter l'exécution du script
        die("Erreur de connexion à la base de données: " . $e->getMessage());
    }
}

$conn = connectToDatabase();
?>
