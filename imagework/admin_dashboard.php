<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel - DelishBites</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #f0f8ff;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background-color: #b0c4de;
    }
    .sidebar {
      background-color: #d3d3d3;
      min-height: 100vh;
      padding-top: 30px;
      transition: all 0.3s ease;
    }
    .sidebar a {
      display: block;
      padding: 10px 20px;
      color: #333;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    .sidebar a:hover {
      background-color: #b0c4de;
      color: #000;
    }
    .main {
      padding: 30px;
      animation: fadeIn 1s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .icon {
      margin-right: 10px;
    }
    .card {
      border-radius: 15px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light shadow">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">DelishBites Admin</a>
    <div class="d-flex">
    
      <a class="btn btn-danger btn-sm" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>
</nav>

<!-- Layout -->
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 sidebar shadow">
      <a href="admin.php"><i class="fas fa-utensils icon"></i> Upload Products</a>
      <a href="bookingsadmin.php"><i class="fas fa-calendar-check icon"></i> View Bookings</a>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 main">
      <div class="card p-4 shadow-sm bg-white">
        <h3 class="fw-bold"><i class="fas fa-user-shield text-primary"></i> Welcome, Admin</h3>
        <p class="text-muted">Use the menu on the left to manage products and table bookings.</p>
        <hr>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="card p-3 bg-light border-0 shadow-sm">
              <h5><i class="fas fa-plus-circle text-success me-2"></i>Add or Manage Products</h5>
              <p class="text-muted">Upload new food items and update their details.</p>
              <a href="admin.php" class="btn btn-outline-primary btn-sm">Go to Products</a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card p-3 bg-light border-0 shadow-sm">
              <h5><i class="fas fa-book text-warning me-2"></i>Manage Bookings</h5>
              <p class="text-muted">View, update, or cancel table bookings.</p>
              <a href="booking.php" class="btn btn-outline-primary btn-sm">Go to Bookings</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
