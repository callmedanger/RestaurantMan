<?php
include 'db.php';
session_start(); // Ensure session is started
$session_id = session_id();

// Delete single item
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete from session
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            unset($_SESSION['cart'][$key]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex

    // ✅ Delete from database
    $stmt = $conn->prepare("DELETE FROM cart WHERE session_id = ? AND product_id = ?");
    $stmt->bind_param("si", $session_id, $id);
    $stmt->execute();

    header("Location: cart.php");
    exit();
}

// Delete all items
if (isset($_GET['delete_all'])) {
    // Delete session cart
    unset($_SESSION['cart']);

    // ✅ Delete all for this session in database
    $stmt = $conn->prepare("DELETE FROM cart WHERE session_id = ?");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();

    header("Location: cart.php");
    exit();
}

// Update quantity
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_qty'])) {
  session_start(); // Ensure session is active
  include 'db.php';

  $id = $_POST['id'];
  $qty = max(1, (int)$_POST['quantity']);
  $session_id = session_id();

  // Update session
  foreach ($_SESSION['cart'] as &$item) {
      if ($item['id'] == $id) {

          // ✅ Store the unit price before any calculation
          $unit_price = $item['price'] ; // Safely calculate unit price from stored total & quantity

          // ✅ Update session
          $item['quantity'] = $qty;
          // $item['price'] = $unit_price * $qty; // total price

          break;
      }
  }
  unset($item); // clear reference

  // ✅ Update in database
  $total_price = $unit_price * $qty;

  $stmt = $conn->prepare("UPDATE cart SET quantity = ?, price = ? WHERE session_id = ? AND product_id = ?");
  $stmt->bind_param("idsi", $qty, $total_price, $session_id, $id);
  $stmt->execute();

  header("Location: cart.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .table img {
      width: 80px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }
    .btn-sm {
      padding: 2px 10px;
    }
  </style>
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="text-center mb-4">🛒 Your Cart</h2>

  <?php if (!empty($_SESSION['cart'])): ?>
  <div class="table-responsive">
    <table class="table table-bordered bg-white">
      <thead class="table-primary">
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Total</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $grandTotal = 0;
          foreach ($_SESSION['cart'] as $item):
            $total = $item['price'] * $item['quantity'];
            $grandTotal += $total;
        ?>
        <tr>
          <td><img src="uploads/<?= $item['image'] ?>" alt=""></td>
          <td><?= $item['name'] ?></td>
          <td>$<?= number_format($item['price'], 2) ?></td>
          <td>
           <form action="cart.php" method="post" class="d-flex">
  <input type="hidden" name="id" value="<?= $item['id'] ?>">
  <input type="number" name="price" value="<?= $item['price'] ?>">
  <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="form-control form-control-sm w-50 me-2">
  <button type="submit" name="update_qty" class="btn btn-success btn-sm">Update</button>
</form>

          </td>
          <td>$<?= number_format($total) ?></td>
          <td>
            <a href="cart.php?delete=<?= $item['id'] ?>" onclick="return confirm('Remove item?')" class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="4" class="text-end fw-bold">Grand Total</td>
          <td colspan="2" class="fw-bold text-success">$<?= number_format($grandTotal) ?></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-between">
    <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
    <a href="checkout.php" class="btn btn-primary">checkout</a>
    <a href="cart.php?delete_all=1" onclick="return confirm('Clear entire cart?')" class="btn btn-danger">Delete All</a>
  </div>

  <?php else: ?>
    <div class="alert alert-info text-center">Your cart is empty.</div>
    <div class="text-center">
      <a href="index.php" class="btn btn-primary">Browse Menu</a>
  
    </div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
