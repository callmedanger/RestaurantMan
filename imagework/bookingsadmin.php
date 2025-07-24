<?php
include 'db.php';

// Fetch all bookings
$query = "SELECT * FROM bookings";
$result = mysqli_query($conn, $query);

if (isset($_GET['update_status'])) {
    $booking_id = $_GET['id'];
    $status = $_GET['status'];

    // Update the status of the booking
    $updateQuery = "UPDATE bookings SET status='$status' WHERE id='$booking_id'";
    mysqli_query($conn, $updateQuery);

    // Redirect to the same page after updating
    header("Location: booking.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Manage Bookings</title>
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
    .navbar-brand {
      font-weight: bold;
    }
    h2 {
      color: #3a5f8a;
      font-weight: 600;
    }
    .table th {
      background-color: #3a5f8a;
      color: white;
    }
    .btn-success {
      background-color: #4caf50;
      border: none;
    }
    .btn-danger {
      background-color: #dc3545;
      border: none;
    }
    .btn-success:hover {
      background-color: #3e8e41;
    }
    .btn-danger:hover {
      background-color: #c82333;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
  <div class="container">
    <a class="navbar-brand text-dark" href="#"><i class="fas fa-utensils me-2"></i>DelishBites Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navContent">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link text-dark" href="admin.php"><i class="fas fa-home me-1"></i>Home</a></li>
        <li class="nav-item"><a class="nav-link text-dark" href="booking.php"><i class="fas fa-calendar-check me-1"></i>Manage Bookings</a></li>
        <li class="nav-item">
          <a class="btn btn-outline-dark ms-3" href="admin_dashboard.php">
            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Bookings Table -->
<div class="container mt-5">
  <h2 class="text-center mb-4">Manage Table Bookings</h2>

  <div class="card p-4 shadow-sm">
    <table class="table table-bordered table-hover text-center align-middle">
      <thead>
        <tr>
          <th>Name</th>
          <th>Date</th>
          <th>Time Slot</th>
          <th>Booking Code</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
                  <td>{$row['name']}</td>
                  <td>{$row['date']}</td>
                  <td>{$row['time_slot']}</td>
                  <td><span class='fw-bold text-primary'>{$row['booking_code']}</span></td>
                  <td>
                    <span class='badge text-bg-" . 
                      ($row['status'] == 'pending' ? 'warning' : ($row['status'] == 'completed' ? 'success' : 'danger')) . 
                      "'>{$row['status']}</span>
                  </td>
                  <td>
                    <a href='?update_status=true&id={$row['id']}&status=completed' class='btn btn-success btn-sm me-1'>
                      <i class='fas fa-check'></i> Complete
                    </a>
                    <a href='?update_status=true&id={$row['id']}&status=canceled' class='btn btn-danger btn-sm'>
                      <i class='fas fa-times'></i> Cancel
                    </a>
                  </td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
