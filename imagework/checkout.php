<?php
session_start();
include('db.php');
// Agar cart empty hai to redirect
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Total calculate karo
$grandTotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $grandTotal += $item['price'] * $item['quantity'];
}

// Form submit hua
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Normally yahan database ya email system hota
    // Yahan sirf success message dikhayenge

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $orderdate=date("Y-m-d H:i:s");
    $query="insert into orders (customer_name	,customer_email	,customer_address	,total_amount	,order_date) values 
    
    ('$name','$email','$address','$grandTotal',' $orderdate')";

    $run=mysqli_query($conn,$query);

    // Session cart khali karo
    unset($_SESSION['cart']);

    $message = "Thank you <strong>$name</strong>! Your order has been placed successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="text-center mb-4">🧾 Checkout</h2>

  <?php if (!empty($message)): ?>
    <div class="alert alert-success text-center"><?= $message ?></div>
    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-primary">Back to Home</a>
    </div>
  <?php else: ?>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card p-4">
        <h5 class="mb-3">Order Summary</h5>
        <p><strong>Items:</strong> <?= count($_SESSION['cart']) ?></p>
        <p><strong>Total Amount:</strong> $<?= number_format($grandTotal, 2) ?></p>

        <form method="post">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" required class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" required class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Delivery Address</label>
            <textarea name="address" rows="3" required class="form-control"></textarea>
          </div>
          <button type="submit" class="btn btn-success w-100">Place Order</button>
        </form>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

</body>
</html>
