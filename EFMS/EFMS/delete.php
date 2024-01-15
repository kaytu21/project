<?php
 include_once ("db.php");


$id = $_REQUEST['id'];


$sql = "DELETE FROM phonenumber WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if($result){
    
    echo "<script>location.href = 'phone.php'</script>";
    
    }else{
        echo "<script>alert('This is an error occurred')</script>";
}

?>
<?php
 
