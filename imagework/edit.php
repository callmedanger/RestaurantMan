<?php
include 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    if ($_FILES['image']['name']) {
        $img = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $img);
        $conn->query("UPDATE products SET name='$name', description='$desc', price='$price', image='$img' WHERE id=$id");
    } else {
        $conn->query("UPDATE products SET name='$name', description='$desc', price='$price' WHERE id=$id");
    }
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Product - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f8ff;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
    }
    .btn-custom {
      background-color: #3a5f8a;
      color: white;
      border: none;
    }
    .btn-custom:hover {
      background-color: #2e4e70;
    }
    .navbar {
      background-color: #b0c4de;
    }
    .navbar .nav-link, .navbar-brand {
      color: #2e4e70 !important;
      font-weight: 600;
    }
    h3 {
      color: #3a5f8a;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg mb-4 shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="admin.php"><i class="fas fa-arrow-left me-2"></i>Back to Dashboard</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Edit Product Form -->
<div class="container mt-4">
  <div class="card p-4 w-75 mx-auto">
    <h3 class="mb-4 text-center">Edit Product</h3>
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" required><?= $row['description'] ?></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Price (PKR)</label>
        <input type="number" step="0.01" name="price" value="<?= $row['price'] ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Change Product Image</label>
        <input type="file" name="image" class="form-control">
        <?php if (!empty($row['image'])): ?>
          <img src="uploads/<?= $row['image'] ?>" alt="Current Image" class="mt-2" width="100">
        <?php endif; ?>
      </div>

      <button name="update" class="btn btn-custom w-100">Update Product</button>
    </form>
  </div>
</div>

</body>
</html>
