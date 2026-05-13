<?php
session_start();

$message_status = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = 'openplanetsmaps@gmail.com';
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['objet']);
    $message = htmlspecialchars($_POST['demande']);
    
    $has_error = false;
    $attachment = '';

    // Gestion du fichier uploadé (téléversement)
    if (isset($_FILES['televersement']) && $_FILES['televersement']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['televersement']['tmp_name'];
        $file_name = $_FILES['televersement']['name'];
        $file_size = $_FILES['televersement']['size'];
        
        // Sécurisation : Vérification du type MIME réel et de la taille
        $file_type = mime_content_type($file_tmp_name);
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
        $max_size = 5 * 1024 * 1024; // Limite à 5 Mo
        
        if (!in_array($file_type, $allowed_types)) {
            $message_status = "<p style='color: #f87171; text-align: center; margin-bottom: 1rem;'>Format non autorisé. Seuls les fichiers JPG, PNG et PDF sont acceptés.</p>";
            $has_error = true;
        } elseif ($file_size > $max_size) {
            $message_status = "<p style='color: #f87171; text-align: center; margin-bottom: 1rem;'>Le fichier est trop volumineux (maximum 5 Mo).</p>";
            $has_error = true;
        } else {
            $content = file_get_contents($file_tmp_name);
            $encoded_content = chunk_split(base64_encode($content));
            
            $attachment = "Content-Type: $file_type; name=\"$file_name\"\r\n";
            $attachment .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
            $attachment .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $attachment .= $encoded_content . "\r\n\r\n";
        }
    }
    
    if (!$has_error) {
        // Générer une frontière (boundary) unique pour séparer le texte de la pièce jointe
        $boundary = md5(uniqid(time()));
        
        $headers = "From: $email\r\nReply-To: $email\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
        
        $body = "--$boundary\r\nContent-Type: text/plain; charset=utf-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= "Email: $email\nObjet: $subject\n\nDemande:\n$message\r\n\r\n";
        
        if (!empty($attachment)) {
            $body .= "--$boundary\r\n" . $attachment;
        }
        $body .= "--$boundary--\r\n";
        
        if (@mail($to, $subject, $body, $headers)) {
            $message_status = "<p style='color: #4ade80; text-align: center; margin-bottom: 1rem;'>Votre message a été envoyé avec succès !</p>";
        } else {
            $message_status = "<p style='color: #f87171; text-align: center; margin-bottom: 1rem;'>Erreur lors de l'envoi du message. Veuillez vérifier la configuration de votre serveur.</p>";
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
        input[type="file"] { cursor: pointer; padding: 0.6rem; }
        input[type="file"]::file-selector-button { background: #334155; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; margin-right: 1rem; transition: background 0.2s; }
        input[type="file"]::file-selector-button:hover { background: #475569; }
    </style>
</head>
<body>
    <div class="admin-box">
        <h1>Contact</h1>
        <?= $message_status ?>
        <!-- L'attribut enctype est requis pour envoyer des fichiers -->
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