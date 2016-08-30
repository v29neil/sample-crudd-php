<?php
header("Content-type: image/jpeg");
// just so we know it is broken
error_reporting(E_ALL);
$username="root";
$password="";
$database="eldeco";
$host = 'localhost';

// some basic sanity checks
if(isset($_GET['title']) && is_numeric($_GET['title'])) {
	//connect to the db
//	$link = mysqli_connect("$host", "$user", "$pass")
//	or die("Could not connect: " . mysql_error());

	// select our database
	$conn = mysqli_connect($host, $username, $password, $database)
	or
	die("Some error occurred during connection " . mysqli_error($link));
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	// get the image from the db
	$sql = "SELECT image FROM images WHERE title=" .$_GET['title'] . ";";

	$ret = $conn->query($sql);
	$row = $ret->fetch_assoc();
	// the result of the query


	// set the header for the image
	$image = $row['image'];

	$sql2 = "SELECT * FROM eldeco_property WHERE title=" .$_GET['title'] . ";";
	$ret2 = $conn->query($sql2);
	$row2 = $ret2->fetch_assoc();
	echo $image;
	print_r($row2);

	// close the db link
$conn->close();
}
else {
	echo 'Please use a real id number';
}
?>