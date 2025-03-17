<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Récupérer l'ID de la boisson à modifier
    $id = $_GET['id'];

    // Récupérer les informations de la boisson
    $sql = "SELECT * FROM Boissons WHERE id_boisson = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $boisson = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$boisson) {
        die("Boisson non trouvée.");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];

    // Mettre à jour la boisson dans la base de données
    $sql = "UPDATE Boissons SET nom_boisson = ?, type_boisson = ?, prix = ?, quantite_stock = ? WHERE id_boisson = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $type, $prix, $quantite, $id]);

    // Rediriger vers la liste des boissons
    header("Location: liste_boissons.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une boisson</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="../assets/js/script.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Modifier une boisson</h1>
        <form action="modifier_boisson.php" method="POST">
            <input type="hidden" name="id" value="<?= $boisson['id_boisson'] ?>">

            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?= $boisson['nom_boisson'] ?>" required>
            </div>

            <div class="form-group">
                <label for="type">Type :</label>
                <select id="type" name="type" required>
                    <option value="Alcoolisé" <?= $boisson['type_boisson'] === 'Alcoolisé' ? 'selected' : '' ?>>Alcoolisé</option>
                    <option value="Sucré" <?= $boisson['type_boisson'] === 'Sucré' ? 'selected' : '' ?>>Sucré</option>
                </select>
            </div>

            <div class="form-group">
                <label for="prix">Prix :</label>
                <input type="number" id="prix" name="prix" step="0.01" value="<?= $boisson['prix'] ?>" required>
            </div>

            <div class="form-group">
                <label for="quantite">Quantité en stock :</label>
                <input type="number" id="quantite" name="quantite" value="<?= $boisson['quantite_stock'] ?>" required>
            </div>

            <button type="submit" class="btn">Modifier</button>
        </form>
        <a href="liste_boissons.php" class="btn-link">Retour à la liste</a>
    </div>
</body>
</html>