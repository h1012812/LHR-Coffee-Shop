<?php
include 'includes/admin_header.php';
include '../includes/auth.php';
checkAdmin();
include '../includes/db.php';

// Insert product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    // Image upload
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $imageName);
    }

    $stmt = $pdo->prepare("
        INSERT INTO products (name, price, category, description, image)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([$name, $price, $category, $description, $imageName]);

    header("Location: products.php");
    exit;
}
?>

<div class="add-header">
    <h2 class="title">Add New Product</h2>

    <div class="add-buttons">
        <a href="products.php" class="btn-back">← Back</a>
        <button type="submit" form="addForm" class="btn-add">+ Add Product</button>
    </div>
</div>

<div class="edit-container">
    <form id="addForm" class="product-form" method="POST" enctype="multipart/form-data">

        <label>Product Name:</label>
        <input type="text" name="name" required>

        <label>Price (SAR):</label>
        <input type="number" name="price" step="0.01" required>

        <label>Category:</label>
        <select name="category" required>
            <option value="Coffee">Coffee</option>
            <option value="Cold Drinks">Cold Drinks</option>
            <option value="Dessert">Dessert</option>
            <option value="Bakery">Bakery</option>
        </select>

        <label>Description:</label>
        <textarea name="description" rows="4"></textarea>

        <label>Product Image:</label>
        <input type="file" name="image">

    </form>
</div>

<?php include 'includes/admin_footer.php'; ?>

