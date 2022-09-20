<?php
require('send.php');
include('outcsv.php');
$form = $_POST['fname'];

if ($form == "visitor") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $callme = $_POST['checkone'];
}

if ($form == "prayer") {
    $prayer = $_POST['prayer'];
    $phonetwo = $_POST['phonetwo'];
    $callme = $_POST['checktwo'];
    $nametwo = $_POST['nametwo'];
}
//echo $form;

if ($form == "visitor") {
    $cols = "`name`,`email`,`phone`,`callme`";
    $vals = ":name,:email,:phone,:callme";
    $data = "'" . $name . "','" . $email . "','" . $phone . "','" . $callme . "'";
    $table = "visitors";
    $params = array(
        ':name'  => $name,
        ':phone' => $phone,
        ':email' => $email,
        ':callme' => $callme
    );
} else {
    $cols = "`name`,`phone`,`prayer`,`callme`";
    $vals = ":name,:phone,:prayer,:callme";
    $data = "'" . $nametwo . "','" . $phonetwo . "','" . $prayer . "','" . $callme . "'";
    $params = array(
        ':name'  => $nametwo,
        ':phone' => $phonetwo,
        ':prayer' => $prayer,
        ':callme' => $callme
    );
    $table = "prayer";
}

$sql = "insert into " . $table . " (" . $cols . ") values(" . $vals . ");";
//echo $sql;
?>
<?php
$servername = '127.0.0.1';
$username = 'auser';
$password = 'supereasypasslol';
$dbname = "awakenla";

$dsn = "mysql:host=" . $servername . ";dbname=" . $dbname . ";charset=UTF8";

try {
    $pdo = new PDO($dsn, $username, $password);

    if ($pdo) {
        //echo "Connected to the $dbname database successfully!";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<?php
if ($form == "visitor") {
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':name', $_POST['name']);
    $statement->bindValue(':email', $_POST['email']);
    $statement->bindValue(':phone', $_POST['phone']);
    $statement->bindValue(':callme', $_POST['checkone']);
    $inserted = $statement->execute();
    if ($inserted) {
        outcsv('id,name,phone,email', 'visitors');
    }
    //var_dump($inserted);
} else {
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':name', $_POST['nametwo']);
    $statement->bindValue(':phone', $_POST['phonetwo']);
    $statement->bindValue(':prayer', $_POST['prayertwo']);
    $statement->bindValue(':callme', $_POST['checkone']);
    //print_r($statement);
    $inserted = $statement->execute();
    outcsv('id,name,email,prayer', 'prayer');
    //echo $inserted;
}
//Mailer Section

$to = "pastoralex@nhfoursquare.org";
$subject = "A New " . $form . " Form Has Been Submitted.";


if ($form == "prayer") {
    $table = "prayer";
    $call = $callme ? 'Yes' : 'No';
    $body = "<html><body>Hi<br/>The followng information was submitted:<br/><br></br><table style-'border: none;' cellspacing='0' cellpadding='0'><tr><td>Name </td><td>" . $_POST['nametwo'] . "</td><tr><td>Phone: " . $_POST['phonetwo'] . "</td></tr><tr><td>Prayer Requested: <td>" . $_POST['prayer'] . "</td></tr><tr><td>Would like a call from the Pastor's: <td>" . $call . "</td></tr></table></body></html>"; // HTML  tags
    send($to, $subject, $body, 'prayer.csv');
}

if ($form == "visitor") {
    $table = "visitors";
    $call = $callme ? 'Yes' : 'No';
    $body = "<html><body>Hi<br/>The followng information was submitted:<br><br/><br></br><table style-'border: none;' cellspacing='0' cellpadding='0'><tr><td>Name:</td><td>" . $_POST['name'] . "</td></tr><tr><td>Email Address:</td><td>" . $_POST['email'] . "</td></tr><tr><td>Phone:</td><td>" . $_POST['phone'] . "</td></tr><tr><td>Would like the Pastor's to call: </td><td>" . $call . "</td></tr></table></body></html>";
    send($to, $subject, $body, 'visitors.csv');
}

?>