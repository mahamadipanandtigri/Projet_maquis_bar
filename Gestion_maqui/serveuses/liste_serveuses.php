<?php
require '../config/config.php';

try {
    $sql = "SELECT id_serveuse, nom, prenom, telephone FROM serveuses";
    $stmt = $pdo->query($sql);
    $serveuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des serveuses : " . $e->getMessage());
}
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des serveuses</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Liste des serveuses</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($serveuses)) : ?>
                    <?php foreach ($serveuses as $serveuse) : ?>
                        <tr>
                            <td><?= htmlspecialchars($serveuse['id_serveuse']) ?></td>
                            <td><?= htmlspecialchars($serveuse['nom']) ?></td>
                            <td><?= htmlspecialchars($serveuse['prenom']) ?></td>
                            <td><?= htmlspecialchars($serveuse['telephone']) ?></td>
                            <td>
    <a href="modifier_serveuse.php?id=<?= $serveuse['id_serveuse'] ?>" class="btn-modifier">Modifier</a>
    <a href="supprimer_serveuse.php?id=<?= $serveuse['id_serveuse'] ?>" class="btn-supprimer" data-id="<?= $serveuse['id_serveuse'] ?>">Supprimer</a>
</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Aucune serveuse trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="ajouter_serveuse.php" class="btn-link">Ajouter une nouvelle serveuse</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>