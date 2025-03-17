<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type_mouvement = $_POST['type_mouvement'];
    $id_boisson = filter_input(INPUT_POST, 'id_boisson', FILTER_VALIDATE_INT);
    $quantite = filter_input(INPUT_POST, 'quantite', FILTER_VALIDATE_INT);
    $date_mouvement = date('Y-m-d H:i:s');

    if (!$id_boisson || !$quantite || !in_array($type_mouvement, ['Entrée', 'Sortie'])) {
        die("Données invalides. Veuillez vérifier les champs.");
    }

    try {
        // Récupérer le prix de la boisson
        $sql = "SELECT prix FROM Boissons WHERE id_boisson = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_boisson]);
        $boisson = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$boisson) {
            die("Boisson non trouvée.");
        }

        $montant = $boisson['prix'] * $quantite;

        // Insérer le mouvement de stock
        $sql = "INSERT INTO mouvements (type_mouvement, id_boisson, quantite, date_mouvement) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$type_mouvement, $id_boisson, $quantite, $date_mouvement]);

        // Mettre à jour le stock de la boisson
        if ($type_mouvement === 'Entrée') {
            $sql = "UPDATE Boissons SET quantite_stock = quantite_stock + ? WHERE id_boisson = ?";
        } else {
            $sql = "UPDATE Boissons SET quantite_stock = quantite_stock - ? WHERE id_boisson = ?";
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$quantite, $id_boisson]);

        // Mettre à jour le montant de la caisse
        $sql = "SELECT id_caisse, montant_actuel FROM Caisses WHERE date_fermeture IS NULL ORDER BY date_ouverture DESC LIMIT 1";
        $stmt = $pdo->query($sql);
        $caisse = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($caisse) {
            if ($type_mouvement === 'Entrée') {
                $nouveau_montant = $caisse['montant_actuel'] - $montant; // Achat de stock
            } else {
                $nouveau_montant = $caisse['montant_actuel'] + $montant; // Vente de stock
            }

            $sql = "UPDATE Caisses SET montant_actuel = ? WHERE id_caisse = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nouveau_montant, $caisse['id_caisse']]);

            echo "Mouvement de stock enregistré, stock mis à jour et caisse mise à jour avec succès !";
        } else {
            echo "Aucune caisse ouverte. Impossible de mettre à jour le montant.";
        }

        header("Location: liste_mouvements.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un mouvement de stock</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un mouvement de stock</h1>
        <form action="ajouter_mouvement.php" method="POST">
            <div class="form-group">
                <label for="type_mouvement">Type de mouvement :</label>
                <select id="type_mouvement" name="type_mouvement" required>
                    <option value="Entrée">Entrée</option>
                    <option value="Sortie">Sortie</option>
                </select>
            </div>

            <div class="form-group">
                <label for="id_boisson">ID Boisson :</label>
                <input type="number" id="id_boisson" name="id_boisson" required>
            </div>

            <div class="form-group">
                <label for="quantite">Quantité :</label>
                <input type="number" id="quantite" name="quantite" required>
            </div>

            <button type="submit" class="btn">Ajouter</button>
        </form>
        <a href="liste_mouvements.php" class="btn-link">Voir la liste des mouvements</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>