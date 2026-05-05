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
    
    if ($planetId === 'quizz') {
        $queries = [];
        $seed = date('Ymd');
        foreach ($tablesAutorisees as $key => $table) {
            $queries[] = "(SELECT explanation, planete_nom FROM $table WHERE explanation IS NOT NULL AND explanation != '' ORDER BY RAND($seed) LIMIT 3)";
        }
        $unionQuery = implode(' UNION ALL ', $queries);
        
        $stmt = $pdo->prepare("SELECT * FROM ($unionQuery) as all_data ORDER BY RAND($seed) LIMIT 10");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $questions = [];
        $allPlanets = ['Mercury', 'Venus', 'Earth', 'Mars', 'Jupiter', 'Saturn', 'Uranus', 'Neptune'];
        
        $traductions = [
            'Mercury' => 'Mercure', 'Venus' => 'Vénus', 'Earth' => 'Terre', 
            'Mars' => 'Mars', 'Jupiter' => 'Jupiter', 'Saturn' => 'Saturne', 
            'Uranus' => 'Uranus', 'Neptune' => 'Neptune'
        ];
        
        foreach ($results as $row) {
            $correctEn = $row['planete_nom'];
            $correctFr = isset($traductions[$correctEn]) ? $traductions[$correctEn] : $correctEn;
            
            $optionsEn = [$correctEn];
            $others = array_diff($allPlanets, [$correctEn]);
            shuffle($others);
            $optionsEn = array_merge($optionsEn, array_slice($others, 0, 3));
            
            $optionsFr = array_map(function($p) use ($traductions) {
                return isset($traductions[$p]) ? $traductions[$p] : $p;
            }, $optionsEn);
            shuffle($optionsFr); 
            
            $text = substr($row['explanation'], 0, 200) . '...';
            
            $questions[] = [
                'q' => "De quel astre parle cette description ? « " . $text . " »",
                'options' => $optionsFr,
                'a' => $correctFr
            ];
        }
        
        echo json_encode($questions);
        exit;
    }
    
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