<?php

$table = $_POST['table'];
$name = $_POST['name'];
$nametwo = $_POST['nametwo'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$form = $_POST['fname'];
$prayer = $_POST['prayer'];
$phonetwo = $_POST['phonetwo'];
$checkone = $_POST['checkone'];
$checktwo = $_POST['checktwo'];

//echo $form;

if ($form == "visitor"){
    $cols = "name,email,phone,callme";
    $vals = $name . "," . $email . "," . $phone . "," .$checkone;
}
else{
    $cols = "name, phone, prayer,callme";
    $vals = $nametwo . "," . $phonetwo . "," . $prayer . "," .$checktwo;;
}

$sql = "insert into awakenla (".$cols.") values(".$vals.");";

?>
<?php
    $servername='localhost';
    $username='alauser';
    $password='Und3rGr@c3';
    $dbname = "awakenla";
    $conn=mysqli_connect($servername,$username,$password,"$dbname");
      if(!$conn){
          die('Could not Connect MySql Server:' .mysql_error());
        }
?>
<?php


if(mysqli_query($conn, $sql)) {
echo '1';
} else {
echo "Error: " . $sql . "" . mysqli_error($conn);
}
mysqli_close($conn);
?>