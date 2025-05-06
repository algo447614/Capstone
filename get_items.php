<?php
require_once __DIR__ . '/../includes/db.php';

// Step 1: Prepare and execute the query
try {
    $stmt = $pdo->query("SELECT * FROM items");
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC); // Get all rows as associative arrays

    // Step 2: Set response header
    header('Content-Type: application/json');

    // Step 3: Output as JSON
    echo json_encode($items);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Database error: " . $e->getMessage()
    ]);
}
?>
