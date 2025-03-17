<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $telephone = htmlspecialchars(trim($_POST['telephone']));

    if (empty($nom) || empty($prenom) || empty($telephone)) {
        die("Tous les champs sont obligatoires.");
    }

    try {
        $sql = "INSERT INTO serveuses (nom, prenom, telephone) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $telephone]);

        echo "Serveuse ajoutée avec succès !";
        header("Location: liste_serveuses.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout de la serveuse : " . $e->getMessage());
    }
}
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une serveuse</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter une serveuse</h1>
        <form action="ajouter_serveuse.php" method="POST">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone :</label>
                <input type="text" id="telephone" name="telephone" required>
            </div>

            <button type="submit" class="btn">Ajouter</button>
        </form>
        <a href="liste_serveuses.php" class="btn-link">Voir la liste des serveuses</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>