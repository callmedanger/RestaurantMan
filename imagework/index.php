<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Delish Bites</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f0f8ff;
      font-family: 'Segoe UI', sans-serif;
    }

    .navbar {
      background-color: #b0c4de;
    }
    .navbar .badge {
  font-size: 0.7rem;
  padding: 5px 7px;
}

    .hero {
      background: linear-gradient(to right, #b0c4de, #e0e0e0);
      padding: 100px 20px;
      text-align: center;
      color: #333;
      animation: fadeIn 1.5s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .quote {
      font-size: 1.5rem;
      font-style: italic;
      margin: 50px auto;
      text-align: center;
      color: #444;
    }

    .card:hover {
      transform: scale(1.02);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card {
      transition: all 0.3s ease;
      border-radius: 15px;
      overflow: hidden;
    }

    .card img {
      height: 200px;
      object-fit: cover;
    }

    .footer {
      background-color: #dcdcdc;
      padding: 20px 0;
      text-align: center;
      color: #555;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">DelishBites</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navContent">
        <ul class="navbar-nav ms-auto">

          <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Menu</a></li>
          <!-- cart code -->
          <?php
          $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
          ?>
          <li class="nav-item">
            <a class="nav-link position-relative" href="cart.php">
              <i class="fas fa-shopping-cart"></i> Cart
              <?php if ($cartCount > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $cartCount ?>
                </span>
              <?php endif; ?>
            </a>
          </li>

          <!-- cart code -->
          <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
          <li class="nav-item">
            <!-- Book a Table Icon -->
            <a class="nav-link" href="booking.php">
              <i class="fas fa-calendar-check"></i> Book a Table
            </a>

          </li>
          <li>
            <a class="nav-link text-white" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <h1 class="display-4 fw-bold">Delicious Meals Delivered Fresh</h1>
      <p class="lead">Order your favorites now and enjoy a bite of happiness!</p>
    </div>
  </section>

  <!-- Food Menu Cards -->
  <div class="container my-5">
    <h2 class="text-center mb-4">Our Popular Dishes</h2>
    <div class="row g-4">


      <?php
      include 'db.php';
     
      $result = $conn->query("SELECT * FROM products");
      while ($row = $result->fetch_assoc()) {
        echo "
    
    <div class='col-md-4'>
      <div class='card shadow'>
      <img src='uploads/{$row['image']}' class='card-img-top' alt='Pasta'>
       <div class='card-body'>
  <h5 class='card-title'>{$row['name']}</h5>
  <p class='card-text text-muted'>{$row['description']}</p>
  <div class='d-flex justify-content-between align-items-center'>
    <span class='fw-bold text-success'>\${$row['price']}</span>
    <form method='post' action='addtocart.php'>
      <input type='hidden' name='id' value='{$row['id']}'>
      <input type='hidden' name='quantity' value='1'>
      <button type='submit' class='btn btn-primary btn-sm'>
        <i class='fas fa-cart-plus'></i> Add to Cart
      </button>
    </form>
  </div>
</div>
      </div>
    </div>
    ";
      }
      ?>
    </div>
  </div>

  <!-- Food Quote -->
  <div class="quote">
    <em>"Food is symbolic of love when words are inadequate." — Alan D. Wolfelt</em>
  </div>

  <!-- Footer -->
  <footer class="footer mt-5">
    <div class="container">
      <p>&copy; 2025 DelishBites. All rights reserved.</p>
      <div>
        <a href="#"><i class="fab fa-facebook-f me-3"></i></a>
        <a href="#"><i class="fab fa-twitter me-3"></i></a>
        <a href="#"><i class="fab fa-instagram me-3"></i></a>
        <a href="#"><i class="fab fa-youtube me-3"></i></a>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>