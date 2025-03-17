<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Récupérer l'ID de la dépense à modifier
    $id = $_GET['id'];

    // Récupérer les informations de la dépense
    $sql = "SELECT * FROM Depenses WHERE id_depense = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $depense = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$depense) {
        die("Dépense non trouvée.");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id = $_POST['id'];
    $description = $_POST['description'];
    $montant = $_POST['montant'];

    // Mettre à jour la dépense dans la base de données
    $sql = "UPDATE Depenses SET description = ?, montant = ? WHERE id_depense = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$description, $montant, $id]);

    // Rediriger vers la liste des dépenses
    header("Location: liste_depenses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une dépense</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="../assets/js/script.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Modifier une dépense</h1>
        <form action="modifier_depense.php" method="POST">
            <input type="hidden" name="id" value="<?= $depense['id_depense'] ?>">

            <div class="form-group">
                <label for="description">Description :</label>
                <input type="text" id="description" name="description" value="<?= $depense['description'] ?>" required>
            </div>

            <div class="form-group">
                <label for="montant">Montant :</label>
                <input type="number" id="montant" name="montant" step="0.01" value="<?= $depense['montant'] ?>" required>
            </div>

            <button type="submit" class="btn">Modifier</button>
        </form>
        <a href="liste_depenses.php" class="btn-link">Retour à la liste</a>
    </div>
</body>
</html>