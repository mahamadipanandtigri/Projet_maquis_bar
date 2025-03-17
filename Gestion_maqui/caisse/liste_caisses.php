<?php
require '../config/config.php';

try {
    $sql = "SELECT * FROM Caisses";
    $stmt = $pdo->query($sql);
    $caisses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des caisses : " . $e->getMessage());
}
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des caisses</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Liste des caisses</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Montant initial</th>
                    <th>Montant actuel</th>
                    <th>Date d'ouverture</th>
                    <th>Date de fermeture</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($caisses)) : ?>
                    <?php foreach ($caisses as $caisse) : ?>
                        <tr>
                            <td><?= htmlspecialchars($caisse['id_caisse']) ?></td>
                            <td><?= htmlspecialchars($caisse['montant_initial']) ?> FCFA</td>
                            <td><?= htmlspecialchars($caisse['montant_actuel']) ?> FCFA</td>
                            <td><?= htmlspecialchars($caisse['date_ouverture']) ?></td>
                            <td><?= htmlspecialchars($caisse['date_fermeture']) ?></td>                        
                
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">Aucune caisse trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="ouvrir_caisse.php" class="btn-link">Ouvrir une nouvelle caisse</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>