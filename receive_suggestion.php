<?php
// receive_suggestion.php (Kwenye GitHub / Render.com)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Soma JSON kutoka kwenye ESP32
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if (!empty($data['sender']) && !empty($data['suggestion'])) {
    
    $file = 'suggestions.json';
    
    // Soma maoni ya zamani kama yapo
    $current_data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    
    // Ongeza maoni mapya
    $current_data[] = [
        'sender' => $data['sender'],
        'suggestion' => $data['suggestion'],
        'time' => date('Y-m-d H:i:s')
    ];
    
    // Save upya kwenye faili
    file_put_contents($file, json_encode($current_data, JSON_PRETTY_PRINT));
    
    echo json_encode([
        "status" => "success",
        "message" => "Maoni yamehifadhiwa salama kwenye Render Storage!"
    ]);
} else {
    // Ukifungua link hii kwenye browser ya kawaida, itakuonyesha maoni yote yaliyosaviwa!
    $file = 'suggestions.json';
    if (file_exists($file)) {
        echo file_get_contents($file);
    } else {
        echo json_encode(["status" => "empty", "message" => "No suggestions yet."]);
    }
}
?>
