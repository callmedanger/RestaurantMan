<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f8ff;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    h2 {
      color: #3a5f8a;
      font-weight: 600;
    }
    .table th {
      background-color: #3a5f8a;
      color: white;
    }
    .btn-primary {
      background-color: #3a5f8a;
      border: none;
    }
    .btn-primary:hover {
      background-color: #2e4e70;
    }
    .btn-warning, .btn-danger {
      font-size: 0.8rem;
      padding: 5px 10px;
    }
    .action-buttons {
      display: flex;
      justify-content: center;
      gap: 5px;
    }
    .table td {
      vertical-align: middle;
    }
    .navbar {
      background-color: #b0c4de;
    }
    .navbar-brand {
      font-weight: bold;
    }
  </style>
</head>
<body>

<!-- Navbar with Dashboard link -->
<nav class="navbar navbar-expand-lg navbar-light mb-4 shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="admin_dashboard.php"><i class="fas fa-arrow-left me-2"></i>Back to Dashboard</a>
  </div>
</nav>

<div class="container mt-2">
  <h2 class="text-center mb-4">Admin - Product Management</h2>

  <!-- Upload Form -->
  <div class="card p-4 mb-5">
    <h5 class="mb-3 text-primary">Add New Product</h5>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <input type="text" name="name" placeholder="Product Name" class="form-control" required>
      </div>
      <div class="mb-3">
        <textarea name="description" placeholder="Description" class="form-control" required></textarea>
      </div>
      <div class="mb-3">
        <input type="number" step="0.01" name="price" placeholder="Price" class="form-control" required>
      </div>
      <div class="mb-3">
        <input type="file" name="image" class="form-control" required>
      </div>
      <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-upload me-1"></i> Upload Product</button>
    </form>
  </div>

  <!-- Product Table -->
  <div class="card p-3">
    <h5 class="mb-3 text-primary">All Products</h5>
    <table class="table table-hover text-center align-middle">
      <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include "db.php";
        $result = $conn->query("SELECT * FROM products");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td><img src='uploads/{$row['image']}' width='80'></td>
                    <td>{$row['name']}</td>
                    <td>{$row['description']}</td>
                    <td><span class='text-success fw-bold'>\${$row['price']}</span></td>
                    <td>
                      <div class='action-buttons'>
                        <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>
                          <i class='fas fa-edit'></i>
                        </a>
                        <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>
                          <i class='fas fa-trash-alt'></i>
                        </a>
                      </div>
                    </td>
                  </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
