<?php
require_once('login.php');

if(!logged_in()) {
    login_page();
} else {

// Connect no matter what
$db = @mysql_connect($dbserv,$dbuser,$dbpass);
mysql_select_db($dbdb,$db);

if(isset($_GET['clear'])) {
    mysql_query("DELETE FROM kweets", $db);
}

if(posted($_POST['status'])) {
    $status = $_POST['status'];
    $user = $_COOKIE['aura'];
    $q = "INSERT INTO kweets VALUES('$status','$user','0')";
    mysql_query($q,$db);
}

?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <title>Kwitter</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
    <div id="main">
    <h2><a href="index.php">Kwitter</a> | 
        <a href="login.php?logout">Log out</a> |
        <a href="login.php?delete">Delete Account</a>
    </h2>
    What are you up to, <?php echo $_COOKIE['aura']; ?>?
    <form action="index.php" method="post">
    <textarea name="status" id="status" rows="10" cols="800"></textarea><br />
    <input type="submit" id="submit" value="Update" />
    </form>

    <h3>Lastest News:</h3>
    <?php
        $query = "SELECT * FROM kweets ORDER BY id DESC";
        $result = mysql_query($query,$db);
        if(mysql_num_rows($result) != 0) 
        {
            while($row = mysql_fetch_assoc($result)) 
            {
                $user = $row['user'];
                $status = $row['status'];
                echo "<b>$user</b> says: <i>$status</i><br /> \n";
            }
        }

    echo "</div></body></html>";
}
@mysql_close($db);
?>
