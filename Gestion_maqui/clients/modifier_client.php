<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Récupérer l'ID du client à modifier
    $id = $_GET['id'];

    // Récupérer les informations du client
    $sql = "SELECT * FROM Clients WHERE id_client = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$client) {
        die("Client non trouvé.");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];

    // Mettre à jour le client dans la base de données
    $sql = "UPDATE Clients SET nom = ?, prenom = ?, telephone = ?, email = ? WHERE id_client = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $telephone, $email, $id]);

    // Rediriger vers la liste des clients
    header("Location: liste_clients.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un client</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="../assets/js/script.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Modifier un client</h1>
        <form action="modifier_client.php" method="POST">
            <input type="hidden" name="id" value="<?= $client['id_client'] ?>">

            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?= $client['nom'] ?>" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" value="<?= $client['prenom'] ?>" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone :</label>
                <input type="text" id="telephone" name="telephone" value="<?= $client['telephone'] ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" value="<?= $client['email'] ?>">
            </div>

            <button type="submit" class="btn">Modifier</button>
        </form>
        <a href="liste_clients.php" class="btn-link">Retour à la liste</a>
    </div>
</body>
</html>