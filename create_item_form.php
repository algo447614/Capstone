<!DOCTYPE html>
<html>
<head>
    <title>Create New Item</title>
</head>
<body>
    <h1>Create a New Item</h1>
    <form action="create_item.php" method="POST">
        <label for="name">Item Name:</label><br>
        <input type="text" name="name" id="name" required><br><br>

        <label for="photo_url">Photo URL:</label><br>
        <input type="text" name="photo_url" id="photo_url"><br><br>

        <label for="price">Price ($):</label><br>
        <input type="number" step="0.01" name="price" id="price" required><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" rows="4" cols="40"></textarea><br><br>

        <label for="quantity">Quantity:</label><br>
        <input type="number" name="quantity" id="quantity" required><br><br>

        <input type="submit" value="Create Item">
    </form>
</body>
</html>
