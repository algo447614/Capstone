<?php
require_once __DIR__ . '/../includes/db.php';

// Step 1: Accept POST or GET
$id = $_POST['id'] ?? $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'id' parameter."]);
    exit;
}

try {
    // Step 2: Check if item exists
    $check = $pdo->prepare("SELECT id FROM items WHERE id = :id");
    $check->execute([':id' => $id]);
    if ($check->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(["error" => "Item not found."]);
        exit;
    }

    // Step 3: Perform the deletion
    $delete = $pdo->prepare("DELETE FROM items WHERE id = :id");
    $delete->execute([':id' => $id]);

    echo json_encode(["message" => "Item deleted successfully."]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
