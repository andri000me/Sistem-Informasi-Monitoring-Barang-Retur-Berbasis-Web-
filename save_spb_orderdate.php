<?php// include headerinclude "header.php";$createdDate = date('Y-m-d H:i:s');$staffID = $_SESSION['staffID'];$spbFaktur = $_SESSION['spbFaktur'];$spbNo = $_POST['spbNo'];$oDate = explode("-", $_POST['tanggal']);if ($spbNo != '' && $spbFaktur != '' && $oDate != ''){	$tanggal = $oDate[2]."-".$oDate[1]."-".$oDate[0];		$querySpb = "UPDATE purchaseorder SET tanggal = '$tanggal' WHERE spbFaktur = '$spbFaktur' AND spbNo = '$spbNo'";	$sqlSpb = mysqli_query($connect, $querySpb);		if ($sqlSpb)	{		echo json_encode(OK);	}	}exit();?>