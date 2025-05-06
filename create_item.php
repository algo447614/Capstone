/*🔹 Functional Role:

create_item.php exists to:

    Accept a structured request (POST)

    Validate it

    Convert it into a database command

    Commit that new data into your system

It's like the "Add New" button on a backend admin dashboard, but through code. */

<?php
require_once __DIR__ . '/../includes/db.php';

// Step 1: Ensure method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Step 2: Collect POST values
    $name = $_POST['name'] ?? '';
    $photo_url = $_POST['photo_url'] ?? '';
    $price = $_POST['price'] ?? '';
    $description = $_POST['description'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    // Step 3: Basic validation
    if (empty($name) || empty($price) || empty($quantity)) {
        echo "Missing required fields.";
        exit;
    }

    // Step 4: Prepare query
    $stmt = $pdo->prepare("INSERT INTO items (name, photo_url, price, description, quantity)
                           VALUES (:name, :photo_url, :price, :description, :quantity)");

    // Step 5: Execute
    try {
        $stmt->execute([
            ':name' => $name,
            ':photo_url' => $photo_url,
            ':price' => $price,
            ':description' => $description,
            ':quantity' => $quantity
        ]);
        echo "Item created successfully.";
        // Optionally: header("Location: dashboard.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "Invalid request method.";
}
?>
