<?php// include headerinclude "header.php";$createdDate = date('Y-m-d H:i:s');$staffID = $_SESSION['staffID'];$spbFaktur = $_SESSION['spbFaktur'];$supplierID = $_POST['supplierID'];if ($supplierID != '' && $spbFaktur != ''){		$dataSupplier = mysqli_fetch_array(mysqli_query($connect, "SELECT kodeSupplier, namaSupplier, alamat FROM supplier WHERE supplierID = '$supplierID'"));	$namaSupplier = $dataSupplier['kodeSupplier']." ".$dataSupplier['namaSupplier'];		$alamat = $dataSupplier['alamat'];		$querySpb = "UPDATE purchaseorder SET supplierID = '$supplierID', namaSupplier = '$namaSupplier', alamatSupplier = '$alamat' WHERE spbFaktur = '$spbFaktur'";	$sqlSpb = mysqli_query($connect, $querySpb);		if ($sqlSpb)	{		echo json_encode(OK);	}	}exit();?>