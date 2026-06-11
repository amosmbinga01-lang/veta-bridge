<?php
// receive_suggestion.php (Kwenye Render.com)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Soma JSON kutoka kwenye ESP32
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if (!empty($data['sender']) && !empty($data['suggestion'])) {
    
    // !!! BADILISHA HAPA: Weka link kamili ya faili lako la kupokelea data lililopo kule INFINITYFREE !!!
    // Mfano: http://esuggestionboxmanagementportal.free.je/api/receive_suggestion.php
    $infinityfree_url = "http://esuggestionboxmanagementportal.free.je/api/receive_suggestion.php";
    
    // Andaa data ya kutumwa kwa njia ya POST ya kawaida
    $post_fields = http_build_query([
        'sender' => $data['sender'],
        'suggestion' => $data['suggestion']
    ]);
    
    // MTAMBO WA CURL: Unapiga bypass ulinzi wa InfinityFree kwa kubeba kuki bandia au kuigiza kama browser ya ndani
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $infinityfree_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    echo json_encode([
        "status" => "forwarded",
        "server_response" => $response
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "No data received"]);
}
?>    }
} else {
    echo json_encode(["status" => "error", "message" => "No valid data received"]);
}

$conn->close();
?>
