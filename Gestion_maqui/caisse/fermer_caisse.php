<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_caisse = filter_input(INPUT_POST, 'id_caisse', FILTER_VALIDATE_INT);
    $date_fermeture = date('Y-m-d H:i:s');

    if (!$id_caisse || $id_caisse <= 0) {
        die("ID de la caisse invalide.");
    }

    try {
        $sql = "UPDATE Caisses SET date_fermeture = ? WHERE id_caisse = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$date_fermeture, $id_caisse]);

        echo "Caisse fermée avec succès !";
        header("Location: etat_caisse.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la fermeture de la caisse : " . $e->getMessage());
    }
}
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fermer une caisse</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Fermer une caisse</h1>
        <form action="fermer_caisse.php" method="POST">
            <div class="form-group">
                <label for="id_caisse">ID de la caisse :</label>
                <input type="number" id="id_caisse" name="id_caisse" required>
            </div>

            <button type="submit" class="btn">Fermer la caisse</button>
        </form>
        <a href="etat_caisse.php" class="btn-link">Voir l'état de la caisse</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>