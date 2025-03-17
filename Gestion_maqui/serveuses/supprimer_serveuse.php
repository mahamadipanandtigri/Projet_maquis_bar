<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Supprimer la serveuse de la base de données
        $sql = "DELETE FROM Serveuses WHERE id_serveuse = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        // Renvoyer une réponse JSON
        echo json_encode(["success" => true, "message" => "Serveuse supprimée avec succès !"]);
    } catch (PDOException $e) {
        // En cas d'erreur, renvoyer un message d'erreur
        echo json_encode(["success" => false, "message" => "Erreur lors de la suppression : " . $e->getMessage()]);
    }
} else {
    // Si l'ID n'est pas spécifié, renvoyer une erreur
    echo json_encode(["success" => false, "message" => "ID non spécifié."]);
}
?>