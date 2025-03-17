<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = htmlspecialchars(trim($_POST['description']));
    $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
    $date_depense = date('Y-m-d H:i:s');

    if (empty($description) || $montant === false || $montant <= 0) {
        die("Données invalides. Veuillez vérifier les champs.");
    }

    try {
        // Commencer une transaction
        $pdo->beginTransaction();

        // Insérer la dépense
        $sql = "INSERT INTO depenses (description, montant, date_depense) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$description, $montant, $date_depense]);

        // Mettre à jour le montant de la caisse
        $sql = "SELECT id_caisse, montant_actuel FROM Caisses WHERE date_fermeture IS NULL ORDER BY date_ouverture DESC LIMIT 1";
        $stmt = $pdo->query($sql);
        $caisse = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($caisse) {
            $nouveau_montant = $caisse['montant_actuel'] - $montant;

            $sql = "UPDATE Caisses SET montant_actuel = ? WHERE id_caisse = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nouveau_montant, $caisse['id_caisse']]);

            echo "Dépense ajoutée et caisse mise à jour avec succès !";
        } else {
            echo "Aucune caisse ouverte. Impossible de mettre à jour le montant.";
        }

        // Valider la transaction
        $pdo->commit();

        header("Location: liste_depenses.php");
        exit();
    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        die("Erreur lors de l'ajout de la dépense : " . $e->getMessage());
    }
}
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une dépense</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter une dépense</h1>
        <form action="ajouter_depense.php" method="POST">
            <div class="form-group">
                <label for="description">Description :</label>
                <input type="text" id="description" name="description" required>
            </div>

            <div class="form-group">
                <label for="montant">Montant :</label>
                <input type="number" id="montant" name="montant" step="0.01" required>
            </div>

            <button type="submit" class="btn">Ajouter</button>
        </form>
        <a href="liste_depenses.php" class="btn-link">Voir la liste des dépenses</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>