<?php
require '../config/config.php';

try {
    $sql = "SELECT id_client, nom, prenom, telephone FROM clients";
    $stmt = $pdo->query($sql);
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des clients : " . $e->getMessage());
}
?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des clients</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Liste des clients</h1>
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
                <?php if (!empty($clients)) : ?>
                    <?php foreach ($clients as $client) : ?>
                        <tr>
                            <td><?= htmlspecialchars($client['id_client']) ?></td>
                            <td><?= htmlspecialchars($client['nom']) ?></td>
                            <td><?= htmlspecialchars($client['prenom']) ?></td>
                            <td><?= htmlspecialchars($client['telephone']) ?></td>
                            <td>
    <a href="modifier_client.php?id=<?= $client['id_client'] ?>" class="btn-modifier">Modifier</a>
    <a href="supprimer_client.php?id=<?= $client['id_client'] ?>" class="btn-supprimer" data-id="<?= $client['id_client'] ?>">Supprimer</a>
</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Aucun client trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="ajouter_client.php" class="btn-link">Ajouter un nouveau client</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>