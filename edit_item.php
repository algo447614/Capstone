<?php
require_once __DIR__ . '/../includes/db.php';

// Step 1: Ensure method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit;
}

// Step 2: Extract ID and ensure it's present
$id = $_POST['id'] ?? null;
if (!$id) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required 'id' field."]);
    exit;
}

// Step 3: Build array of fields to update
$fields = [];
$params = [':id' => $id];

if (!empty($_POST['name'])) {
    $fields[] = "name = :name";
    $params[':name'] = $_POST['name'];
}
if (!empty($_POST['photo_url'])) {
    $fields[] = "photo_url = :photo_url";
    $params[':photo_url'] = $_POST['photo_url'];
}
if (!empty($_POST['price'])) {
    $fields[] = "price = :price";
    $params[':price'] = $_POST['price'];
}
if (!empty($_POST['description'])) {
    $fields[] = "description = :description";
    $params[':description'] = $_POST['description'];
}
if (isset($_POST['quantity']) && $_POST['quantity'] !== '') {
    $fields[] = "quantity = :quantity";
    $params[':quantity'] = $_POST['quantity'];
}

// Step 4: If no fields to update, exit
if (empty($fields)) {
    http_response_code(400);
    echo json_encode(["error" => "No fields provided for update."]);
    exit;
}

try {
    // Step 5: Ensure item exists
    $check = $pdo->prepare("SELECT id FROM items WHERE id = :id");
    $check->execute([':id' => $id]);
    if ($check->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(["error" => "Item not found."]);
        exit;
    }

    // Step 6: Build and execute the update
    $sql = "UPDATE items SET " . implode(', ', $fields) . " WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode(["message" => "Item updated successfully."]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
