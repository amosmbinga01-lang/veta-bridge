<?php
// receive_suggestion.php (Itarun kwenye Render.com)

// Ruhusu request kutoka mahali popote
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// 1. MAELEZO YAKO YA DATABASE YA INFINITYFREE
$host = "sql110.infinityfree.com";
$db_user = "if0_42158015"; 
$db_pass = "0ftQyeRxTDjIBVr";     
$db_name = "if0_42158015_smartsuggestionbox";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database Connection failed"]);
    exit();
}

// 2. SOMA DATA YA JSON INAYOTOKA KWENYE ESP32
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if (!empty($data['sender']) && !empty($data['suggestion'])) {
    
    $sender = $conn->real_escape_string($data['sender']);
    $suggestion = $conn->real_escape_string($data['suggestion']);
    
    // Sukuma data kwenda kwenye table ya InfinityFree
    $sql = "INSERT INTO suggestions (suggestion_text, status, received_at) VALUES ('$suggestion', 'New', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Data Inserted to InfinityFree MySQL!"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No valid data received"]);
}

$conn->close();
?>