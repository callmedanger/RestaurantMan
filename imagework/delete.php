 <?php
include 'db.php';

if(isset($_GET['id'])){

$id = $_GET['id'];

$query="DELETE FROM products WHERE id='$id' ";
$run=mysqli_query($conn,$query);

if($run){

echo "<script> alert(' data deleted 😁')

</script>";
header('Location: admin.php');
}
else{

    echo "<script> alert(' data  not deleted 😑')
 
    </script>";
    header('Location: admin.php');
    }
    
}

?>
