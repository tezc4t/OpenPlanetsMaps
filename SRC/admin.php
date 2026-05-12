<?php
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Incorrect credentials.';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

$host = '172.17.0.1';
$dbname = 'OpenPlanetsMaps';
$db_user = 'root';
$db_pass = 'admin123';

$message = '';
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    try {
        $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $planete = $_POST['planete'];
        $nom = $_POST['nom'];
        $date = $_POST['date'];
        $url = $_POST['url'];
        $description = $_POST['description'];
        
        $allowedTables = [
            'mercury' => 'MERCURY', 'venus' => 'VENUS', 'earth' => 'EARTH', 
            'mars' => 'MARS', 'jupiter' => 'JUPITER', 'saturn' => 'SATURN', 
            'uranus' => 'URANUS', 'neptune' => 'NEPTUNE'
        ];
        
        if (array_key_exists($planete, $allowedTables)) {
            $nomTable = $allowedTables[$planete];
            $stmt = $pdo->prepare("INSERT INTO $nomTable (title, date, url, explanation) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $date, $url, $description]);
            
            $message = "<p style='color: #4ade80; text-align: center; margin-bottom: 1rem;'>Row successfully added to the $nomTable table!</p>";
        }
    } catch (PDOException $e) {
        $message = "<p style='color: #f87171; text-align: center; margin-bottom: 1rem;'>SQL Error: " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - OpenPlanetsMaps</title>
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
            <h1>Admin Login</h1>
            <?php if ($error): ?><p style="color: #f87171; text-align: center; margin-bottom: 1rem;"><?= $error ?></p><?php endif; ?>
            <form method="POST">
                <input type="hidden" name="action" value="login">
                <div class="form-group"><label>Username</label><input type="text" name="username" required></div>
                <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
                <button type="submit" class="btn-submit">Login</button>
            </form>
            <div class="links"><a href="index.html">← Back to site</a></div>
        <?php else: ?>
            <h1>Add a row</h1>
            <?= $message ?>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="form-group"><label>Target planet</label><select name="planete" required>
                    <option value="mercury">Mercury</option><option value="venus">Venus</option><option value="earth">Earth</option>
                    <option value="mars">Mars</option><option value="jupiter">Jupiter</option><option value="saturn">Saturn</option>
                    <option value="uranus">Uranus</option><option value="neptune">Neptune</option>
                </select></div>
                <div class="form-group"><label>Mission / Element name</label><input type="text" name="nom" required></div>
                <div class="form-group"><label>Date (e.g., 24/01/1986)</label><input type="text" name="date"></div>
                <div class="form-group"><label>URL (Link to an image or site)</label><input type="url" name="url"></div>
                <div class="form-group"><label>Description / Explanation</label><textarea name="description" rows="4"></textarea></div>
                <button type="submit" class="btn-submit">Add to data</button>
            </form>
            <div class="links"><a href="admin.php?logout=1" style="color: #f87171;">Logout</a><a href="index.html">← Back to site</a></div>
        <?php endif; ?>
    </div>
</body>
</html>