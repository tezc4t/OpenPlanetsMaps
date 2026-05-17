<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config.php';

try {
    $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_EMULATE_PREPARES => false];
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8;protocol=tcp", $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $planetId = isset($_GET['planet']) ? $_GET['planet'] : '';
    
    $allowedTables = [
    'mercury' => 'MERCURY',
    'venus'   => 'VENUS',
    'earth'   => 'EARTH',
    'mars'    => 'MARS',
    'jupiter' => 'JUPITER',
    'saturn'  => 'SATURN',
    'uranus'  => 'URANUS',
    'neptune' => 'NEPTUNE',
    'sun'     => 'SUN',    
    'moon'    => 'MOON',   
    ]; 
    
    if ($planetId === 'quiz') {
        $queries = [];
        $seed = date('Ymd');
        foreach ($allowedTables as $key => $table) {
            $planetName = ucfirst($key);
            $queries[] = "(SELECT explanation, '$planetName' AS planete_nom, url FROM $table WHERE explanation IS NOT NULL AND explanation != '' ORDER BY RAND($seed) LIMIT 3)";
        }
        $unionQuery = implode(' UNION ALL ', $queries);
        
        $stmt = $pdo->prepare("SELECT * FROM ($unionQuery) as all_data ORDER BY RAND($seed) LIMIT 10");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $questions = [];
        $allPlanets = ['Mercury', 'Venus', 'Earth', 'Mars', 'Jupiter', 'Saturn', 'Uranus', 'Neptune','Sun' , 'Moon'];
        
        foreach ($results as $row) {
            $correctEn = $row['planete_nom'];
            
            $optionsEn = [$correctEn];
            $others = array_diff($allPlanets, [$correctEn]);
            shuffle($others);
            $optionsEn = array_merge($optionsEn, array_slice($others, 0, 3));
            shuffle($optionsEn); 
            
            $text = substr($row['explanation'], 0, 200) . '...';
            
            $questions[] = [
                'q'       => "Which celestial body does this description refer to? « " . $text . " »",
                'options' => $optionsEn,
                'a'       => $correctEn,
                'img'     => isset($row['url']) ? $row['url'] : ''
            ];
        }
        
        echo json_encode($questions);
        exit;
    }
    
    if (!array_key_exists($planetId, $allowedTables)) {
        echo json_encode([]);
        exit;
    }
    
    $tableName = $allowedTables[$planetId];
    $stmt = $pdo->prepare("SELECT * FROM $tableName");
    $stmt->execute();
    
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}