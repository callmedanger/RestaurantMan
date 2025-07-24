<?php
include 'db.php';

$msg = "";
if (isset($_POST['book'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time_slot = $_POST['time_slot'];

    // Check if slot already booked
    $check = mysqli_query($conn, "SELECT * FROM bookings WHERE date='$date' AND time_slot='$time_slot'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "<div class='alert alert-danger'>This slot is already booked. Please choose another.</div>";
    } else {
        // Generate unique booking code
        $booking_code = strtoupper(substr(md5(uniqid()), 0, 8));

        // Insert booking
        $insert = "INSERT INTO bookings (name, date, time_slot, booking_code) 
                   VALUES ('$name', '$date', '$time_slot', '$booking_code')";
        mysqli_query($conn, $insert);

        $msg = "<div class='alert alert-success'>Table booked! Your booking code is <strong>$booking_code</strong></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Table Booking</title>
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
    .hero {
      background: linear-gradient(to right, #b0c4de, #e0e0e0);
      padding: 100px 20px;
      text-align: center;
      color: #333;
      animation: fadeIn 1.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
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
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
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
    .form-control:focus {
      border-color: #b0c4de;
    }
    .btn-primary {
      background-color: #b0c4de;
      border-color: #b0c4de;
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
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Cart</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        <li class="nav-item">
          <a class="nav-link" href="#book-table-section">
            <i class="fas fa-calendar-check"></i> Book a Table
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h1 class="display-4 fw-bold">Reserve Your Table at DelishBites</h1>
    <p class="lead">Book a table for a wonderful dining experience!</p>
  </div>
</section>

<!-- Booking Form Section -->
<div id="book-table-section" class="container my-5">
  <h2 class="text-center mb-4">Book a Table</h2>

  <!-- Display Message -->
  <?= $msg ?>

  <!-- Booking Form -->
  <form method="POST" class="card p-4 shadow-sm bg-white rounded">
    <div class="mb-3">
      <label class="form-label">Your Name</label>
      <input type="text" name="name" class="form-control" required />
    </div>

    <div class="mb-3">
      <label class="form-label">Select Date</label>
      <input type="date" name="date" class="form-control" required />
    </div>

    <div class="mb-3">
      <label class="form-label">Select Time Slot</label>
      <select name="time_slot" class="form-control" required>
        <option value="">Choose Slot</option>
        <option>12:00 PM - 1:00 PM</option>
        <option>1:00 PM - 2:00 PM</option>
        <option>2:00 PM - 3:00 PM</option>
        <option>7:00 PM - 8:00 PM</option>
        <option>8:00 PM - 9:00 PM</option>
      </select>
    </div>

    <button type="submit" name="book" class="btn btn-primary w-100">
      <i class="fas fa-check-circle"></i> Book Now
    </button>
  </form>
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
