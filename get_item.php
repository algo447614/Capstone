<?php
require_once __DIR__ . '/../includes/db.php';

// Step 1: Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Missing 'id' parameter."]);
    exit;
}

$id = $_GET['id'];

// Step 2: Query the database for the item
try {
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        header('Content-Type: application/json');
        echo json_encode($item);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(["error" => "Item not found."]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
