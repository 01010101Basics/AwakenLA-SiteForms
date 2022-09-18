<?php
require('send.php');
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$form = $_POST['fname'];
$callme = $_POST['checkone'];

if ($form == "prayer") {    $prayer = $_POST['prayer'];    $phonetwo = $_POST['phonetwo'];    $callme = $_POST['checktwo'];    $nametwo = $_POST['nametwo'];
}
//echo $form;

if ($form == "visitor") {
    $cols = "`name`,`email`,`phone`,`callme`";
    $vals = ":name,:email,:phone,:callme";
    $data = "'" . $name . "','" . $email . "','" . $phone . "','" . $callme . "'";
    $table = "visitors";
    $params = array(
        ':name' => $name,
        ':phone' => $phone,
        ':email' => $email,
        ':callme' => $callme
    );
}
else {
    $cols = "`name`,`phone`,`prayer`,`callme`";
    $vals = ":name,:phone,:prayer,:callme";
    $data = "'" . $nametwo . "','" . $phonetwo . "','" . $prayer . "','" . $callme . "'";
    $params = array(
        ':name' => $nametwo,
        ':phone' => $phonetwo,
        ':prayer' => $prayer,
        ':callme' => $callme
    );
    $table = "prayer";
}
?>
<?php
$servername = '127.0.0.1';
$username = 'auser';
$password = 'Und3rGr@c3';
$dbname = "awakenla";
//$conn=mysqli_connect($servername,$username,$password,"$dbname");
$dsn = "mysql:host=" . $servername . ";dbname=" . $dbname . ";charset=UTF8";

try {
    $pdo = new PDO($dsn, $username, $password);

    if ($pdo) {
    //echo "Connected to the $dbname database successfully!";
    }
}
catch (PDOException $e) {
    echo $e->getMessage();
}
$sql = "insert into ". $table ." (".$cols.") values(".$vals.");";
?>
<?php
//Preparing and Binding SQL
if ($form == "visitor") {    $statement = $pdo->prepare($sql);    $statement->bindValue(':name', $_POST['name']);    $statement->bindValue(':email', $_POST['email']);    $statement->bindValue(':phone', $_POST['phone']);    $statement->bindValue(':callme', $_POST['checkone']);    $inserted = $statement->execute();

}
else {

    $statement = $pdo->prepare($sql);    $statement->bindValue(':name', $_POST['nametwo']);    $statement->bindValue(':phone', $_POST['phonetwo']);    $statement->bindValue(':prayer', $_POST['prayertwo']);    $statement->bindValue(':callme', $_POST['checkone']);    $inserted = $statement->execute();

}


$to = "pastoralex@nhfoursquare.org";
$subject = "A New ". $form . " Form Has Been Submitted.";

if ($form == "prayer") {    $call = $callme ? yes : no;    $body = "<html>

<body>Hi<br />The followng information was submitted:<br /><br></br>
    <table style-'border: none;' cellspacing='0' cellpadding='0'>
        <tr>
            <td>Name </td>
            <td>" . $_POST['nametwo'] . "</td>
        <tr>
            <td>Phone: " . $_POST['phonetwo'] . "</td>
        </tr>
        <tr>
            <td>Prayer Requested:
            <td>" . $_POST['prayer'] . "</td>
        </tr>
        <tr>
            <td>Would like a call from the Pastor's:
            <td>" . $call . "</td>
        </tr>
    </table>
</body>

</html>"; // HTML tags    echo $body;
Send_Mail($to,$subject,$body);

}

if ($form == "visitor") {    $call = $callme ? yes : no;    $body = "<html>

<body>Hi<br />The followng information was submitted:<br><br /><br></br>
    <table style-'border: none;' cellspacing='0' cellpadding='0'>
        <tr>
            <td>Name:</td>
            <td>" . $_POST['name'] . "</td>
        </tr>
        <tr>
            <td>Email Address:</td>
            <td>" . $_POST['email'] . "</td>
        </tr>
        <tr>
            <td>Phone:</td>
            <td>" . $_POST['phone'] . "</td>
        </tr>
        <tr>
            <td>Would like the Pastor's to call: </td>
            <td>" . $call . "</td>
        </tr>
    </table>
</body>

</html>";    Send_Mail($to, $subject, $body);

}

?>