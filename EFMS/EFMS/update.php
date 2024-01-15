<?php
 include_once ("db.php");


 if(isset($_POST['update_number']))
{
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    

    $query = "UPDATE phonenumber SET number='$number' WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Phone Number Successfully Updated";
        header("Location: phone.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Phone Number Not Updated";
        header("Location: phone.php");
        exit(0);
    }

}
?>

