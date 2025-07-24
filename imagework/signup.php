<?php
include 'db.php';

$msg = "";

if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "<div class='alert alert-danger'>Email already exists!</div>";
    } else {
        $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        mysqli_query($conn, $query);
        $msg = "<div class='alert alert-success'>Registration successful! <a href='login.php'>Login here</a></div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card p-4 shadow w-50 mx-auto">
    <h3 class="text-center text-primary mb-4">Create an Account</h3>
    <?= $msg ?>
    <form method="POST" action="signup.php">
      <input type="text" name="name" placeholder="Full Name" class="form-control mb-3" required>
      <input type="email" name="email" placeholder="Email" class="form-control mb-3" required>
      <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
      <select name="role" class="form-control mb-3" required>
        <option value="">Choose Role</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
      </select>
      <button name="signup" class="btn btn-primary w-100">Sign Up</button>
      <div class="text-center mt-2"><a href="login.php">Already have an account?</a></div>
    </form>
  </div>
</div>

</body>
</html>
