<?php// include headerinclude "header.php";$modified_date = date('Y-m-d H:i:s');$staffID = $_SESSION['staffID'];$kursID = $_POST['currencyID'];$valas = mysqli_real_escape_string($connect, $_POST['valas']);$kurs = $_POST['kurs'];$status = $_POST['status'];if ($kursID != '' && $valas != '' && $status != '' && $kurs != ''){		$queryCurrency = "UPDATE as_kurs SET 	valas = '$valas',											kurs = '$kurs',											status = '$status',											modifiedDate = '$modified_date',											modifiedUserID = '$staffID'											WHERE kursID = '$kursID'";		$sqlCurrency = mysqli_query($connect, $queryCurrency);		if ($sqlCurrency)	{		echo json_encode(OK);		}}exit();?>