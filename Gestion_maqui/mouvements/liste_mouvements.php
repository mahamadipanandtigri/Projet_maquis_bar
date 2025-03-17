<?php
require '../config/config.php';

try {
    $sql = "SELECT m.id_mouvement, m.type_mouvement, b.id_boisson AS boisson, m.quantite, m.date_mouvement
            FROM mouvements m
            JOIN Boissons b ON m.id_boisson = b.id_boisson";
    $stmt = $pdo->query($sql);
    $mouvements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des mouvements de stock : " . $e->getMessage());
}
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des mouvements de stock</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Liste des mouvements de stock</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Boisson</th>
                    <th>Quantité</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($mouvements)) : ?>
                    <?php foreach ($mouvements as $mouvement) : ?>
                        <tr>
                            <td><?= htmlspecialchars($mouvement['id_mouvement']) ?></td>
                            <td><?= htmlspecialchars($mouvement['type_mouvement']) ?></td>
                            <td><?= htmlspecialchars($mouvement['boisson']) ?></td>
                            <td><?= htmlspecialchars($mouvement['quantite']) ?></td>
                            <td><?= htmlspecialchars($mouvement['date_mouvement']) ?></td>
                            <td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">Aucun mouvement de stock trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="ajouter_mouvement.php" class="btn-link">Ajouter un nouveau mouvement</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>