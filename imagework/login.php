<?php
session_start();
include 'db.php';

$msg = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid email or password!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card p-4 shadow w-50 mx-auto">
    <h3 class="text-center text-primary mb-4">Login</h3>
    <?= $msg ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" class="form-control mb-3" required>
      <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
      <button name="login" class="btn btn-primary w-100">Login</button>
      <div class="text-center mt-2"><a href="signup.php">Don't have an account? Register</a></div>
    </form>
  </div>
</div>

</body>
</html>
