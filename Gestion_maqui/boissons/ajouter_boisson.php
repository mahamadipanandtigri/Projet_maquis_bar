<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT);
    $quantite_stock = filter_input(INPUT_POST, 'quantite_stock', FILTER_VALIDATE_INT);

    if (empty($nom) || $prix === false || $quantite_stock === false) {
        die("Données invalides. Veuillez vérifier les champs.");
    }

    try {
        $sql = "INSERT INTO Boissons (nom_boisson, prix, quantite_stock) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prix, $quantite_stock]);

        echo "Boisson ajoutée avec succès !";
        header("Location: liste_boissons.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout de la boisson : " . $e->getMessage());
    }
}
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une boisson</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter une boisson</h1>
        <form action="ajouter_boisson.php" method="POST">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="prix">Prix :</label>
                <input type="number" id="prix" name="prix" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="quantite_stock">Quantité en stock :</label>
                <input type="number" id="quantite_stock" name="quantite_stock" required>
            </div>

            <button type="submit" class="btn">Ajouter</button>
        </form>
        <a href="liste_boissons.php" class="btn-link">Voir la liste des boissons</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>