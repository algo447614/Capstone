<?php
require_once __DIR__ . '/../includes/db.php';

// Step 1: Check for required POST input
$item_id = $_POST['item_id'] ?? null;
$qty_change = $_POST['quantity_change'] ?? null;

if ($item_id === null || $qty_change === null) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'item_id' or 'quantity_change'."]);
    exit;
}

try {
    // Step 2: Fetch the current quantity
    $stmt = $pdo->prepare("SELECT quantity FROM items WHERE id = :id");
    $stmt->execute([':id' => $item_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        http_response_code(404);
        echo json_encode(["error" => "Item not found."]);
        exit;
    }

    $new_qty = (int)$item['quantity'] + (int)$qty_change;

    // Step 3: Prevent negative quantity
    if ($new_qty < 0) {
        http_response_code(400);
        echo json_encode(["error" => "Not enough stock."]);
        exit;
    }

    // Step 4: Perform the update
    $updateStmt = $pdo->prepare("UPDATE items SET quantity = :qty WHERE id = :id");
    $updateStmt->execute([':qty' => $new_qty, ':id' => $item_id]);

    echo json_encode([
        "message" => "Quantity updated successfully.",
        "new_quantity" => $new_qty
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
