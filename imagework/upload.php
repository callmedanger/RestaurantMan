 <?php include 'db.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "uploads/" . $img);

    $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$desc', '$price', '$img')";
    $conn->query($sql);
    header("Location:admin.php");
}
?>
