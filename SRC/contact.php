<?php
session_start();

$message_status = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['objet']);
    $message = htmlspecialchars($_POST['demande']);
    
    $has_error = false;
    $file_path = null;

    if (isset($_FILES['televersement']) && $_FILES['televersement']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['televersement']['tmp_name'];
        $file_name = $_FILES['televersement']['name'];
        $file_size = $_FILES['televersement']['size'];
        
        $file_type = mime_content_type($file_tmp_name);
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
        $max_size = 5 * 1024 * 1024;
        
        if (!in_array($file_type, $allowed_types)) {
            $message_status = "<p style='color: #f87171; text-align: center; margin-bottom: 1rem;'>Format non autorisé. Seuls les fichiers JPG, PNG et PDF sont acceptés.</p>";
            $has_error = true;
        } elseif ($file_size > $max_size) {
            $message_status = "<p style='color: #f87171; text-align: center; margin-bottom: 1rem;'>Le fichier est trop volumineux (maximum 5 Mo).</p>";
            $has_error = true;
        } else {
            $upload_dir = 'UPLOADS/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $safe_file_name = time() . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', $file_name);
            $target_path = $upload_dir . $safe_file_name;
            
            if (move_uploaded_file($file_tmp_name, $target_path)) {
                $file_path = $target_path;
            } else {
                $message_status = "<p style='color: #f87171; text-align: center; margin-bottom: 1rem;'>Erreur lors de la sauvegarde du fichier.</p>";
                $has_error = true;
            }
        }
    }
    
    if (!$has_error) {
        try {
            $host = 'maps-db-unique';
            $dbname = 'OpenPlanetsMaps';
            $db_user = 'root';
            $db_pass = 'admin123';
            
            $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_EMULATE_PREPARES => false];
            $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8;protocol=tcp", $db_user, $db_pass, $options);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("INSERT INTO CONTACT (email, objet, demande, fichier, date_demande) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$email, $subject, $message, $file_path]);
            
            $message_status = "<p style='color: #4ade80; text-align: center; margin-bottom: 1rem;'>Votre demande a été enregistrée avec succès dans la base de données !</p>";
        } catch (PDOException $e) {
            $message_status = "<p style='color: #f87171; text-align: center; margin-bottom: 1rem;'>Erreur de base de données : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact - OpenPlanetsMaps</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-form">
    <div class="admin-box">
        <h1>Contact</h1>
        <?= $message_status ?>
        <form method="POST" action="contact.php" enctype="multipart/form-data">
            <div class="form-group"><label>Votre E-mail</label><input type="email" name="email" placeholder="nom@exemple.com" required></div>
            <div class="form-group"><label>Objet</label><input type="text" name="objet" placeholder="Sujet de votre demande" required></div>
            <div class="form-group"><label>Demande / Message</label><textarea name="demande" rows="5" placeholder="Détaillez votre message ici..." required></textarea></div>
            <div class="form-group"><label>Téléversement d'un fichier (Optionnel, Max 5Mo, JPG/PNG/PDF)</label><input type="file" name="televersement" accept=".jpg,.jpeg,.png,.pdf"></div>
            <button type="submit" class="btn-submit">Envoyer</button>
        </form>
        <div class="links"><a href="index.html">← Retour au site</a></div>
    </div>
</body>
</html>