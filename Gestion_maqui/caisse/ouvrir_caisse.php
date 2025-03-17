<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $montant_initial = filter_input(INPUT_POST, 'montant_initial', FILTER_VALIDATE_FLOAT);
    $date_ouverture = date('Y-m-d H:i:s');

    // Valider le montant initial
    if ($montant_initial === false || $montant_initial <= 0) {
        die("Montant initial invalide. Veuillez entrer un nombre positif.");
    }

    try {
        // Insérer la nouvelle caisse dans la base de données
        $sql = "INSERT INTO Caisses (montant_initial, montant_actuel, date_ouverture) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$montant_initial, $montant_initial, $date_ouverture]);

        // Rediriger vers la page d'état de la caisse
        header("Location: etat_caisse.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de l'ouverture de la caisse : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ouvrir une caisse</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="../assets/js/script.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Ouvrir une caisse</h1>
        <form action="ouvrir_caisse.php" method="POST">
            <div class="form-group">
                <label for="montant_initial">Montant initial :</label>
                <input type="number" id="montant_initial" name="montant_initial" step="0.01" required>
            </div>

            <button type="submit" class="btn">Ouvrir la caisse</button>
        </form>
        <a href="etat_caisse.php" class="btn-link">Voir l'état de la caisse</a>
    </div>
</body>
</html>