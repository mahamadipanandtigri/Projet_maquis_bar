<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Récupérer l'ID de la serveuse à modifier
    $id = $_GET['id'];

    // Récupérer les informations de la serveuse
    $sql = "SELECT * FROM Serveuses WHERE id_serveuse = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $serveuse = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$serveuse) {
        die("Serveuse non trouvée.");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];

    // Mettre à jour la serveuse dans la base de données
    $sql = "UPDATE Serveuses SET nom = ?, prenom = ?, telephone = ? WHERE id_serveuse = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $telephone, $id]);

    // Rediriger vers la liste des serveuses
    header("Location: liste_serveuses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une serveuse</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="../assets/js/script.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Modifier une serveuse</h1>
        <form action="modifier_serveuse.php" method="POST">
            <input type="hidden" name="id" value="<?= $serveuse['id_serveuse'] ?>">

            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?= $serveuse['nom'] ?>" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" value="<?= $serveuse['prenom'] ?>" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone :</label>
                <input type="text" id="telephone" name="telephone" value="<?= $serveuse['telephone'] ?>" required>
            </div>

            <button type="submit" class="btn">Modifier</button>
        </form>
        <a href="liste_serveuses.php" class="btn-link">Retour à la liste</a>
    </div>
</body>
</html>