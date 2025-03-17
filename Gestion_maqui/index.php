<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Maquis</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Gestion du Maquis</h1>
            <nav>
                <ul class="menu">
                    <li><a href="boissons/liste_boissons.php">Préparer les boissons</a></li>
                    <li><a href="clients/liste_clients.php">Préparer les clients</a></li>
                    <li><a href="serveuses/liste_serveuses.php">Préparer les serveuses</a></li>
                    <li><a href="commandes/liste_commandes.php">Préparer les commandes</a></li>
                    <li><a href="caisse/etat_caisse.php">Préparer le casse</a></li>
                    <li><a href="depenses/liste_depenses.php">Préparer les dépenses</a></li>
                    <li><a href="mouvements/liste_mouvements.php">Gérer les mouvements de stock</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">
        <section>
            <ul class="features">
                <li><h1>BIENVENU SUR LA BASE DE GESTION DE TON MAQUIS</H1></li>
            </ul>
        </section>
    </main>
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Gestion du Maquis. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>