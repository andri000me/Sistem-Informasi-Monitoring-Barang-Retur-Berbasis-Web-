<?php// include headerinclude "header.php";$modified_date = date('Y-m-d H:i:s');$staffID = $_SESSION['staffID'];$staffID2 = $_POST['staffID2'];$staffCode = $_POST['staffCode'];$staffName = mysqli_real_escape_string($connect, $_POST['staffName']);$address = mysqli_real_escape_string($connect, $_POST['address']);$address2 = mysqli_real_escape_string($connect, $_POST['address2']);$village = mysqli_real_escape_string($connect, $_POST['village']);$district = mysqli_real_escape_string($connect, $_POST['district']);$city = mysqli_real_escape_string($connect, $_POST['city']);$zipCode = $_POST['zipCode'];$province = mysqli_real_escape_string($connect, $_POST['province']);$phone = mysqli_real_escape_string($connect, $_POST['phone']);$position = mysqli_real_escape_string($connect, $_POST['position']);$part = mysqli_real_escape_string($connect, $_POST['part']);$statusStaff = $_POST['statusStaff'];$level = $_POST['level'];$photo = $_POST['photo'];$foto = $_POST['foto'];$email = mysqli_real_escape_string($connect, $_POST['email']);$password = $_POST['password'];if ($staffID2 != '' && $staffCode != '' && $staffName != '' && $statusStaff != '' && $level != '' && $email != ''){		// set photo to thumbnail			if ($password != '')		{						$queryStaff = "UPDATE as_staffs SET	staffCode = '$staffCode',												staffName = '$staffName',												position = '$position',												status = '$statusStaff',												level = '$level',												email = '$email',												password = '$password'												WHERE staffID = '$staffID2'";		}		else		{			$queryStaff = "UPDATE as_staffs SET	staffCode = '$staffCode',												staffName = '$staffName',												position = '$position',												status = '$statusStaff',												level = '$level',												email = '$email'												WHERE staffID = '$staffID2'";		}			$sqlStaff = mysqli_query($connect, $queryStaff);		if ($sqlStaff)	{		echo json_encode(OK);		}}exit();?>