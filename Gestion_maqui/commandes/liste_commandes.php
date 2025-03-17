<?php
require '../config/config.php';

try {
    $sql = "SELECT id_commande, id_client, id_serveuse, date_commande, montant_total FROM Commandes";
    $stmt = $pdo->query($sql);
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des commandes : " . $e->getMessage());
}

?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des commandes</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Liste des commandes</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Client</th>
                    <th>ID Serveuse</th>
                    <th>Date</th>
                    <th>Montant total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($commandes)) : ?>
                    <?php foreach ($commandes as $commande) : ?>
                        <tr>
                            <td><?= htmlspecialchars($commande['id_commande']) ?></td>
                            <td><?= htmlspecialchars($commande['id_client']) ?></td>
                            <td><?= htmlspecialchars($commande['id_serveuse']) ?></td>
                            <td><?= htmlspecialchars($commande['date_commande']) ?></td>
                            <td><?= htmlspecialchars($commande['montant_total']) ?> FCFA</td>
                            <td>
    <a href="modifier_commande.php?id=<?= $commande['id_commande'] ?>" class="btn-modifier">Modifier</a>
    <a href="supprimer_commande.php?id=<?= $commande['id_commande'] ?>" class="btn-supprimer" data-id="<?= $commande['id_commande'] ?>">Supprimer</a>
</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">Aucune commande trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="ajouter_commande.php" class="btn-link">Ajouter une nouvelle commande</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>