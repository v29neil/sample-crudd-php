<html>
<head>
	<title>Insert details</title>
	<link rel="stylesheet" href="http://www.eldecobuilder.com/assets/plugins/bootstrap/css/bootstrap.min.css">
<!--	1. Title (text)-->
<!--	2. Image url multiple (upload)-->
<!--	3.Price (int)-->
<!--	4. Address (text)-->
<!--	5. Description (text area)-->
<!--	6. Builder name(text)-->
<!--	7. Status(text)-->
<!--	8. Detail(room/bathroom) (text)-->
<!--	9. contact no.(text)-->
<!--	10. backlink name(hidden)-->
<!--	11. banner(upload)-->
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
	<div >
		<label >Title</label>
		<input type="text" name="title" id="title" placeholder="Title">
	</div>
	<div >
		<label >Price</label>
		<input type="text"  name="price"  id="price" placeholder="Price">
	</div>
	<div >
		<label >Address</label>
		<input type="text"  name="address"  id="address" placeholder="Address">
	</div>
	<div>
		<label >Description</label>
		<textarea name="description"></textarea>
	</div>
	<div>
		<label >Builder name</label>
		<input type="text"  name="bName" id="builder-name" placeholder="Builder name">
	</div>
	<div>
		<label for="exampleInputPassword1">Status</label>
		<input type="text" name="status"  id="price" placeholder="Price">
	</div>
	<div>
		<label for="exampleInputPassword1">Details</label>
		<input type="text" name="details"  id="details" placeholder="Details">
	</div>
	<div>
		<label for="exampleInputPassword1">Contact number</label>
		<input type="text" name="contact"  id="contact" placeholder="Contact">
	</div>
	<div >
		<label>Upload Image</label>
		<input name="uImage" type="file" />
	</div>
	<div >
		<label>Upload Banner</label>
		<input name="uBanner" type="file" />
	</div>
	<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
	<input type="submit" value="Submit" />
</form>
<?php
if($_POST)
{
}
// check if a file was submitted
if(!isset($_FILES['uImage']))
{
	echo '<p>Please select a file</p>';
}
else
{
	try {
		$msg= submit();  //this will upload your image
		echo $msg;  //Message showing success or failure.
	}
	catch(Exception $e) {
		echo $e->getMessage();
		echo 'Sorry, could not upload file';
	}
}

// the upload function

function submit() {

$maxsize = 10000000; //set to approx 10 MB

//check associated error code
if($_FILES['uImage']['error']==UPLOAD_ERR_OK) {

//check whether file is uploaded with HTTP POST
if(is_uploaded_file($_FILES['uImage']['tmp_name'])) {

//checks size of uploaded image on server side
if( $_FILES['uImage']['size'] < $maxsize) {

//checks whether uploaded file is of image type
//if(strpos(mime_content_type($_FILES['uImage']['tmp_name']),"image")===0) {
$finfo = finfo_open(FILEINFO_MIME_TYPE);
if(strpos(finfo_file($finfo, $_FILES['uImage']['tmp_name']),"image")===0) {

// prepare the image for insertion
$imgData =addslashes (file_get_contents($_FILES['uImage']['tmp_name']));
$bannerData =addslashes (file_get_contents($_FILES['uBanner']['tmp_name']));

// put the image in the db...
// database connection
	$username="root";
	$password="";
	$database="eldeco";
	$host = 'localhost';
	$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}
$title = $_POST['title'];
// our sql query
$sql = "INSERT INTO test_image(image_name,image,banner,title,banner_name) VALUES('{$imgData}', '{$_FILES['uImage']['name']}','{$bannerData}', '{$title}','{$_FILES['uBanner']['name']}');";
$sql2 = "INSERT INTO eldeco_property(title, price,address,description,builder,status,flat_details,contact,backlink) VALUES('{$_POST['title']}', '{$_POST['price']}', '{$_POST['address']}','{$_POST['description']}','{$_POST['bName']}','{$_POST['status']}','{$_POST['details']}','{$_POST['contact']}','{$_POST['title']}');";
// insert the image

	if(!$mysqli->query($sql)){
		//image fail
	} else if(!$mysqli->query($sql2)) {
		//form fail
	} else {
		$msg='<p>Successfully saved in database with id ='.  $mysqli->insert_id .' </p>';
	}

	$mysqli->close();
}

else
$msg="<p>Uploaded file is not an image.</p>";
}
else {
// if the file is not less than the maximum allowed, print an error
$msg='<div>File exceeds the Maximum File limit</div>
<div>Maximum File limit is '.$maxsize.' bytes</div>
<div>File '.$_FILES['uImage']['name'].' is '.$_FILES['uImage']['size'].
	' bytes</div><hr />';
}
}
else
$msg="File not uploaded successfully.";

}
else {
$msg= file_upload_error_message($_FILES['uImage']['error']);
}
return $msg;

}

// Function to return error message based on error code

function file_upload_error_message($error_code) {
switch ($error_code) {
case UPLOAD_ERR_INI_SIZE:
return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
case UPLOAD_ERR_FORM_SIZE:
return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
case UPLOAD_ERR_PARTIAL:
return 'The uploaded file was only partially uploaded';
case UPLOAD_ERR_NO_FILE:
return 'No file was uploaded';
case UPLOAD_ERR_NO_TMP_DIR:
return 'Missing a temporary folder';
case UPLOAD_ERR_CANT_WRITE:
return 'Failed to write file to disk';
case UPLOAD_ERR_EXTENSION:
return 'File upload stopped by extension';
default:
return 'Unknown upload error';
}
}
?>
</body>
</html>
