<?php
include 'includes/admin_header.php';
include '../includes/auth.php';
checkAdmin();
include '../includes/db.php';

// Get product ID
$id = $_GET['id'];

// Fetch product data
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

// Update product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    // Keep old image unless a new one is uploaded
    $imageName = $product['image'];

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $imageName);
    }

    $stmt = $pdo->prepare("
        UPDATE products
        SET name = ?, price = ?, category = ?, description = ?, image = ?
        WHERE id = ?
    ");

    $stmt->execute([$name, $price, $category, $description, $imageName, $id]);

    header("Location: products.php");
    exit;
}
?>

<div class="add-header">
    <h2 class="title">Edit Product</h2>

    <div class="add-buttons">
        <a href="products.php" class="btn-back">← Back</a>
        <button type="submit" form="editForm" class="btn-add">Update Product</button>
    </div>
</div>

<div class="edit-container">
    <form id="editForm" class="product-form" method="POST" enctype="multipart/form-data">

        <label>Product Name:</label>
        <input type="text" name="name" value="<?php echo $product['name']; ?>" required>

        <label>Price (SAR):</label>
        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>

        <label>Category:</label>
        <select name="category">
            <option value="Coffee" <?php if ($product['category'] == 'Coffee') echo 'selected'; ?>>Coffee</option>
            <option value="Cold Drinks" <?php if ($product['category'] == 'Cold Drinks') echo 'selected'; ?>>Cold Drinks</option>
            <option value="Dessert" <?php if ($product['category'] == 'Dessert') echo 'selected'; ?>>Dessert</option>
            <option value="Bakery" <?php if ($product['category'] == 'Bakery') echo 'selected'; ?>>Bakery</option>
        </select>

        <label>Description:</label>
        <textarea name="description" rows="4"><?php echo $product['description']; ?></textarea>

        <label>Current Image:</label>
        <?php if ($product['image']): ?>
            <img src="../assets/images/<?php echo $product['image']; ?>" width="120" style="border-radius:10px; margin-bottom:10px;">
        <?php else: ?>
            <p>No image uploaded</p>
        <?php endif; ?>

        <label>Upload New Image:</label>
        <input type="file" name="image">

    </form>
</div>

<?php include 'includes/admin_footer.php'; ?>


