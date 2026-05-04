<?php
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Identifiants incorrects.';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

$host = 'localhost';
$dbname = 'OpenPlanetsMaps';
$db_user = 'admin';
$db_pass = 'admin';

$message = '';
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $planete = $_POST['planete'];
        $nom = $_POST['nom'];
        $date = $_POST['date'];
        $url = $_POST['url'];
        $description = $_POST['description'];
        
        $tablesAutorisees = [
            'mercure' => 'MERCURY', 'venus' => 'VENUS', 'terre' => 'EARTH', 
            'mars' => 'MARS', 'jupiter' => 'JUPITER', 'saturne' => 'SATURN', 
            'uranus' => 'URANUS', 'neptune' => 'NEPTUNE'
        ];
        
        if (array_key_exists($planete, $tablesAutorisees)) {
            $nomTable = $tablesAutorisees[$planete];
            $stmt = $pdo->prepare("INSERT INTO $nomTable (nom, date, url, description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $date, $url, $description]);
            
            $message = "<p style='color: #4ade80; text-align: center; margin-bottom: 1rem;'>Ligne ajoutée avec succès dans la table $nomTable !</p>";
        }
    } catch (PDOException $e) {
        $message = "<p style='color: #f87171; text-align: center; margin-bottom: 1rem;'>Erreur SQL : " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - OpenPlanetsMaps</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background-color: #0f172a; color: #e0e0e0; display: flex; justify-content: center; align-items: center; padding: 2rem; min-height: 100vh; }
        .admin-box { background-color: #1e293b; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.5); width: 100%; max-width: 500px; border: 1px solid #334155; }
        .admin-box h1 { color: #00bfff; text-align: center; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #b9bbbe; font-size: 0.9rem; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.75rem; background: #0f172a; border: 1px solid #334155; border-radius: 4px; color: white; font-family: inherit; }
        .btn-submit { width: 100%; padding: 0.75rem; background-color: #00bfff; color: white; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; margin-top: 1rem; transition: background 0.2s; }
        .btn-submit:hover { background-color: #009acd; }
        .links { text-align: center; margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem; }
        .links a { color: #94a3b8; text-decoration: none; font-size: 0.9rem; transition: color 0.2s; }
        .links a:hover { color: #ffffff; }
    </style>
</head>
<body>
    <div class="admin-box">
        <?php if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true): ?>
            <h1>Connexion Admin</h1>
            <?php if ($error): ?><p style="color: #f87171; text-align: center; margin-bottom: 1rem;"><?= $error ?></p><?php endif; ?>
            <form method="POST">
                <input type="hidden" name="action" value="login">
                <div class="form-group"><label>Utilisateur</label><input type="text" name="username" required></div>
                <div class="form-group"><label>Mot de passe</label><input type="password" name="password" required></div>
                <button type="submit" class="btn-submit">Se connecter</button>
            </form>
            <div class="links"><a href="index.html">← Retour au site</a></div>
        <?php else: ?>
            <h1>Ajouter une ligne</h1>
            <?= $message ?>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="form-group"><label>Planète cible</label><select name="planete" required>
                    <option value="mercure">Mercure</option><option value="venus">Vénus</option><option value="terre">Terre</option>
                    <option value="mars">Mars</option><option value="jupiter">Jupiter</option><option value="saturne">Saturne</option>
                    <option value="uranus">Uranus</option><option value="neptune">Neptune</option>
                </select></div>
                <div class="form-group"><label>Nom de la mission / de l'élément</label><input type="text" name="nom" required></div>
                <div class="form-group"><label>Date (ex: 24/01/1986)</label><input type="text" name="date"></div>
                <div class="form-group"><label>URL (Lien vers une image ou un site)</label><input type="url" name="url"></div>
                <div class="form-group"><label>Description / Explication</label><textarea name="description" rows="4"></textarea></div>
                <button type="submit" class="btn-submit">Ajouter aux données</button>
            </form>
            <div class="links"><a href="admin.php?logout=1" style="color: #f87171;">Se déconnecter</a><a href="index.html">← Retour au site</a></div>
        <?php endif; ?>
    </div>
</body>
</html>