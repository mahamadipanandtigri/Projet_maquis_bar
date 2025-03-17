<?php
require '../config/config.php';

// Récupérer l'ID de la commande
$id_commande = $_GET['id'];

// Récupérer les détails de la commande
$sql = "SELECT c.id_commande, c.date_commande, c.montant_total, cl.nom AS nom_client, cl.prenom AS prenom_client, s.nom AS nom_serveuse, s.prenom AS prenom_serveuse
        FROM Commandes c
        JOIN Clients cl ON c.id_client = cl.id_client
        JOIN Serveuses s ON c.id_serveuse = s.id_serveuse
        WHERE c.id_commande = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_commande]);
$commande = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$commande) {
    die("Commande non trouvée.");
}

// Récupérer les boissons de la commande
$sql = "SELECT b.nom_boisson, dc.quantite, dc.prix_unitaire
        FROM Details_Commandes dc
        JOIN Boissons b ON dc.id_boisson = b.id_boisson
        WHERE dc.id_commande = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_commande]);
$boissons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la commande</title>
    <!-- Lien vers le fichier CSS -->
<link rel="stylesheet" href="assets/css/styles.css">
<link rel="stylesheet" href="../assets/css/stle.css">

<!-- Lien vers le fichier JavaScript -->
<script src="assets/js/script.js" defer></script>
</head>
<body>
    <h1>Détails de la commande #<?= $commande['id_commande'] ?></h1>
    <p><strong>Date :</strong> <?= $commande['date_commande'] ?></p>
    <p><strong>Montant total :</strong> <?= $commande['montant_total'] ?> FCFA</p>
    <p><strong>Client :</strong> <?= $commande['nom_client'] ?> <?= $commande['prenom_client'] ?></p>
    <p><strong>Serveuse :</strong> <?= $commande['nom_serveuse'] ?> <?= $commande['prenom_serveuse'] ?></p>

    <h2>Boissons commandées</h2>
    <table border="1">
        <tr>
            <th>Boisson</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
        </tr>
        <?php foreach ($boissons as $boisson): ?>
        <tr>
            <td><?= $boisson['nom_boisson'] ?></td>
            <td><?= $boisson['quantite'] ?></td>
            <td><?= $boisson['prix_unitaire'] ?> FCFA</td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="liste_commandes.php">Retour à la liste</a>
</body>
</html>
<?php include '../footer.php'; ?>