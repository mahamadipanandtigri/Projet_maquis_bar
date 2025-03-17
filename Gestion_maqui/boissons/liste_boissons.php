<?php
require '../config/config.php';

try {
    $sql = "SELECT id_boisson, nom_boisson, prix, quantite_stock FROM Boissons";
    $stmt = $pdo->query($sql);
    $boissons = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des boissons : " . $e->getMessage());
}

?>
<?php include '../header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des boissons</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/stle.css">
</head>
<body>
    <div class="container">
        <h1>Liste des boissons</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Quantité en stock</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($boissons)) : ?>
                    <?php foreach ($boissons as $boisson) : ?>
                        <tr>
                            <td><?= htmlspecialchars($boisson['id_boisson']) ?></td>
                            <td><?= htmlspecialchars($boisson['nom_boisson']) ?></td>
                            <td><?= htmlspecialchars($boisson['prix']) ?> FCFA</td>
                            <td><?= htmlspecialchars($boisson['quantite_stock']) ?></td>
                            <td><a href="modifier_boisson.php?id=<?= $boisson['id_boisson'] ?>" class="btn-modifier">Modifier</a>
                            <a href="supprimer_boisson.php?id=<?= $boisson['id_boisson'] ?>" class="btn-supprimer" data-id="<?= $boisson['id_boisson'] ?>">Supprimer</a>
                           </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Aucune boisson trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="ajouter_boisson.php" class="btn-link">Ajouter une nouvelle boisson</a>
    </div>
</body>
</html>
<?php include '../footer.php'; ?>