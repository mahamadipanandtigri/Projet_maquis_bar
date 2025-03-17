<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_client = filter_input(INPUT_POST, 'id_client', FILTER_VALIDATE_INT);
    $id_serveuse = filter_input(INPUT_POST, 'id_serveuse', FILTER_VALIDATE_INT);
    $id_boisson = filter_input(INPUT_POST, 'id_boisson', FILTER_VALIDATE_INT);
    $quantite = filter_input(INPUT_POST, 'quantite', FILTER_VALIDATE_INT);
    $date_commande = date('Y-m-d H:i:s');

    if (!$id_client || !$id_serveuse || !$id_boisson || !$quantite) {
        die("Données invalides. Veuillez vérifier les champs.");
    }

    try {
        // Commencer une transaction
        $pdo->beginTransaction();

        // Récupérer le prix de la boisson
        $sql = "SELECT prix FROM Boissons WHERE id_boisson = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_boisson]);
        $boisson = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$boisson) {
            die("Boisson non trouvée.");
        }

        $montant_total = $boisson['prix'] * $quantite;

        // Insérer la commande
        $sql = "INSERT INTO Commandes (id_client, id_serveuse, date_commande, montant_total) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_client, $id_serveuse, $date_commande, $montant_total]);

        // Décrémenter le stock de la boisson
        $sql = "UPDATE Boissons SET quantite_stock = quantite_stock - ? WHERE id_boisson = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$quantite, $id_boisson]);

        // Mettre à jour le montant de la caisse
        $sql = "SELECT id_caisse, montant_actuel FROM Caisses WHERE date_fermeture IS NULL ORDER BY date_ouverture DESC LIMIT 1";
        $stmt = $pdo->query($sql);
        $caisse = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($caisse) {
            $nouveau_montant = $caisse['montant_actuel'] + $montant_total;

            $sql = "UPDATE Caisses SET montant_actuel = ? WHERE id_caisse = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nouveau_montant, $caisse['id_caisse']]);

            echo "Commande ajoutée, stock mis à jour et caisse augmentée avec succès !";
        } else {
            echo "Aucune caisse ouverte. Impossible de mettre à jour le montant.";
        }

        // Valider la transaction
        $pdo->commit();

        header("Location: liste_commandes.php");
        exit();
    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
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
    <title>Ajouter une commande</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter une commande</h1>
        <form action="ajouter_commande.php" method="POST">
            <div class="form-group">
                <label for="id_client">ID Client :</label>
                <input type="number" id="id_client" name="id_client" required>
            </div>

            <div class="form-group">
                <label for="id_serveuse">ID Serveuse :</label>
                <input type="number" id="id_serveuse" name="id_serveuse" required>
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
        <a href="liste_commandes.php" class="btn-link">Voir la liste des commandes</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>