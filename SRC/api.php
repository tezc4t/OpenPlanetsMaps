<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'OpenPlanetsMaps';
$username = 'admin';
$password = 'admin';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $planetId = isset($_GET['planet']) ? $_GET['planet'] : '';
    
    $tablesAutorisees = [
        'mercure' => 'MERCURY',
        'venus'   => 'VENUS',
        'terre'   => 'EARTH',
        'mars'    => 'MARS',
        'jupiter' => 'JUPITER',
        'saturne' => 'SATURN',
        'uranus'  => 'URANUS',
        'neptune' => 'NEPTUNE'
    ];
    
    if (!array_key_exists($planetId, $tablesAutorisees)) {
        echo json_encode([]);
        exit;
    }
    
    $nomTable = $tablesAutorisees[$planetId];
    $stmt = $pdo->prepare("SELECT * FROM $nomTable");
    $stmt->execute();
    
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données : ' . $e->getMessage()]);
}