<?php
include 'includes/admin_header.php';
include '../includes/auth.php';
checkAdmin();
include '../includes/db.php';

// Fetch all products ordered by category
$stmt = $pdo->query("SELECT * FROM products ORDER BY category, id DESC");
$products = $stmt->fetchAll();

// Group products by category
$grouped = [];
foreach ($products as $p) {
    $grouped[$p['category']][] = $p;
}
?>

<div class="products-header">
    <h2 class="title">Products Management</h2>
    <a href="add_product.php" class="btn-add">+ Add New Product</a>
</div>

<?php if (empty($products)): ?>

    <div class="no-orders">
        <h3>No Products Added Yet</h3>
        <p>Add products to start displaying them here.</p>
    </div>

<?php else: ?>

    <?php foreach ($grouped as $category => $items): ?>

        <div class="category-block">

            <h2 class="category-title"><?php echo $category; ?></h2>

            <table class="products-table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>

                <?php foreach ($items as $product): ?>
                    <tr>
                        <td><?= $product['id']; ?></td>
                        <td><?= $product['name']; ?></td>
                        <td><?= $product['price']; ?> SAR</td>
                        <td style="max-width:250px;"><?= $product['description']; ?></td>

                        <td>
                            <img src="../assets/images/<?= $product['image']; ?>" class="product-img">
                        </td>

                        <td>
                            <a href="edit_product.php?id=<?= $product['id']; ?>" class="btn-edit">Edit</a>
                            <a href="delete_product.php?id=<?= $product['id']; ?>" class="btn-delete"
                               onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>

        </div>

    <?php endforeach; ?>

<?php endif; ?>

<?php include 'includes/admin_footer.php'; ?>
