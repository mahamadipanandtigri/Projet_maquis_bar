<?php
require '../config/config.php';

try {
    $sql = "SELECT id_depense, description, montant, date_depense FROM depenses";
    $stmt = $pdo->query($sql);
    $depenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des dépenses : " . $e->getMessage());
}
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des dépenses</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Liste des dépenses</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Montant</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($depenses)) : ?>
                    <?php foreach ($depenses as $depense) : ?>
                        <tr>
                            <td><?= htmlspecialchars($depense['id_depense']) ?></td>
                            <td><?= htmlspecialchars($depense['description']) ?></td>
                            <td><?= htmlspecialchars($depense['montant']) ?> FCFA</td>
                            <td><?= htmlspecialchars($depense['date_depense']) ?></td>
                            <td>
    <a href="modifier_depense.php?id=<?= $depense['id_depense'] ?>" class="btn-modifier">Modifier</a>
    <a href="supprimer_depense.php?id=<?= $depense['id_depense'] ?>" class="btn-supprimer" data-id="<?= $depense['id_depense'] ?>">Supprimer</a>
</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Aucune dépense trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="ajouter_depense.php" class="btn-link">Ajouter une nouvelle dépense</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>