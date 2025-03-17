<?php
require '../config/config.php';

try {
    $sql = "SELECT * FROM Caisses WHERE date_fermeture IS NULL ORDER BY date_ouverture DESC LIMIT 1";
    $stmt = $pdo->query($sql);
    $caisse = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération de l'état de la caisse : " . $e->getMessage());
}
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>État de la caisse</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>État de la caisse</h1>
        <?php if ($caisse): ?>
            <p><strong>ID de la caisse :</strong> <?= htmlspecialchars($caisse['id_caisse']) ?></p>
            <p><strong>Montant initial :</strong> <?= htmlspecialchars($caisse['montant_initial']) ?> FCFA</p>
            <p><strong>Montant actuel :</strong> <?= htmlspecialchars($caisse['montant_actuel']) ?> FCFA</p>
            <p><strong>Date d'ouverture :</strong> <?= htmlspecialchars($caisse['date_ouverture']) ?></p>
            <a href="fermer_caisse.php?id_caisse=<?= $caisse['id_caisse'] ?>" class="btn-link">Fermer la caisse</a>
            <a href="liste_caisses.php" class="btn-liste-caisses">Liste Caisse</a>
        <?php else: ?>
            <p>Aucune caisse ouverte.</p>
            <a href="ouvrir_caisse.php" class="btn-link">Ouvrir une nouvelle caisse</a>
        <?php endif; ?>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>