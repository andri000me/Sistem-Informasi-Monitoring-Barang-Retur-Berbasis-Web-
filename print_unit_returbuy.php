<?php
include "header.php";

// if session is null, showing up the text and exit
if ($_SESSION['staffID'] == '' && $_SESSION['email'] == '')
{
	// show up the text and exit
	echo "You have not authorization for access the modules.";
	exit();
}

else{
	
	ob_start();
	require ("includes/html2pdf/html2pdf.class.php");
	
	$act = $_GET['act'];
	$module = $_GET['module'];
	
	if ($module == 'returbuy' && $act == 'print')
	{
		$returID = $_GET['returID'];
		$returNo = $_GET['returNo'];
		$nofaktur = $_GET['nofaktur
		'];
		$now = date('Y-m-d');
		
		$filename="retur_pembelian.pdf";
		$content = ob_get_clean();
		
		// showing up the main retur data
		$queryMain = "SELECT * FROM retur WHERE returID = '$returID' AND returNo = '$returNo'";
		$sqlMain = mysqli_query($connect, $queryMain);
		$dataMain = mysqli_fetch_array($sqlMain);
		
		$tanggalretur = tgl_indo2($dataMain['tanggalretur']);
		
		$subtotal = rupiah($dataMain['subtotal']);
		$grandtotal = rupiah($dataMain['grandtotal']);
		
		$content = "<table style='padding-bottom: 10px; width: 240mm;'>
						<tr valign='top'>
							<td style='width: 150mm;' valign='middle'>
								<div style='font-weight: bold; padding-bottom: 5px; font-size: 12pt;'>
									PT. LOTTE MART INDONESIA CABANG MAKASSAR
								</div>
							</td>
							<td style='width: 83mm;'></td>
						</tr>
						<tr valign='top'>
							<td><span style='font-size: 8pt;'>Mall Panakukang, Jl.Boulevard Raya No.1<br>Makassar, Sulawesi Selatan, Indonesia
								</span>
							</td>
							<td>
								<span style='font-size: 11pt;'><b>BUKTI RETUR PEMBELIAN</b></span>
							</td>
						</tr>
					</table>
					<table cellpadding='0' cellspacing='0' style='width: 240mm;'>
						<tr>
							<td style='padding: 2px 0px 2px 0px; font-size: 9pt; width: 28mm;'>Nomor Retur</td>
							<td style='padding: 2px 0px 2px 0px; font-size: 9pt; width: 3mm;'>:</td>
							<td style='padding: 2px 0px 2px 0px; font-size: 9pt; width: 35mm;'>$dataMain[returNo]</td>
							<td style='padding: 2px 0px 2px 0px; font-size: 9pt; width: 28mm;'>No Faktur Beli</td>
							<td style='padding: 2px 0px 2px 0px; font-size: 9pt; width: 3mm;'>:</td>
							<td style='padding: 2px 0px 2px 0px; font-size: 9pt; width: 35mm;'>$dataMain[nofaktur]</td>
							<td style='padding: 2px 0px 2px 0px; font-size: 9pt; width: 28mm;'>Kepada Yth,</td>
							<td colspan='2'></td>
						</tr>
						<tr>
							<td style='padding: 2px 0px 2px 0px; font-size: 9pt;'>Tanggal</td>
							<td style='padding: 2px 0px 2px 0px; font-size: 9pt;'>:</td>
							<td style='padding: 2px 0px 2px 0px; font-size: 9pt;'>$tanggalretur</td>
							<td></td><td></td><td></td>
							<td style='padding: 2px 0px 2px 0px; font-size: 9pt;' colspan='3' text-align>$dataMain[namaSupplier]</td>
						</tr>
						
					</table>
					<br>
					<table cellpadding='0' cellspacing='0' style='width: 240mm; border-bottom: 1px solid #000;'>
						<tr>
							<th style='width: 10mm; padding: 2px 0px 2px 0px; font-size: 9pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>NO.</th>
							<th style='width: 90mm; padding: 2px 0px 2px 0px; font-size: 9pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>NAMA BARANG</th>
							<th style='width: 30mm; padding: 2px 0px 2px 0px; font-size: 9pt; border-top: 1px solid #000; border-bottom: 1px solid #000;'>KETERANGAN</th>
							<th style='width: 35mm; padding: 2px 0px 2px 0px; font-size: 9pt; border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: center;'>HARGA</th>
							<th style='width: 35mm; padding: 2px 0px 2px 0px; font-size: 9pt; border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: center;'>QTY</th>
							<th style='width: 35mm; padding: 2px 0px 2px 0px; font-size: 9pt; border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: right;'>SUBTOTAL</th>
						</tr>";
						
						// showing the retur detail
						$queryReturDetail = "SELECT * FROM detail_retur WHERE returNo = '$returNo' ORDER BY detailID ASC";
						$sqlReturDetail = mysqli_query($connect, $queryReturDetail);
						
						// fetch data
						$i = 1;
						while ($dtReturDetail = mysqli_fetch_array($sqlReturDetail))
						{
							$productName = chunk_split($dtReturDetail['productName'], 50, "<br>");
							$subtotal = rupiah($dtReturDetail['qty'] * $dtReturDetail['harga']);
							$harga = rupiah($dtReturDetail['harga']);
							$ket = $dtReturDetail['note'];
							
							$content .= "
									<tr valign='top'>
										<td style='padding: 2px 0px 2px 0px; font-size: 9pt;'>$i</td>
										<td style='padding: 2px 0px 2px 0px; font-size: 9pt;'>$productName</td>
										<td style='padding: 2px 45px 2px 0px; font-size: 9pt; text-align: right;'>$ket</td>
										<td style='padding: 2px 30px 2px 0px; font-size: 9pt; text-align: right;'>$harga</td>
										<td style='padding: 2px 0px 2px 0px; font-size: 9pt; text-align: center;'>$dtReturDetail[qty]</td>
										<td style='padding: 2px 0px 2px 0px; font-size: 9pt; text-align: right;'>$subtotal</td>
									</tr>
							";
							
							$i++;
						}
			$content .= 
						"
						
					</table>
					
					<table cellpadding='0' cellspacing='0' style='width: 230mm;'>
						<tr valign='top'>
							<td style='padding: 5px 0px 5px 0px; font-size: 9pt; text-align: center; width: 130mm;' rowspan='5'><br><br><br>HORMAT KAMI,<br><br><br><br><br><br>Administrasi</td>
							<td style='padding: 5px 0px 5px 0px; font-size: 9pt; text-align: right; width: 100mm;'>
								<table>
									<tr>
										<td style='width: 60mm; text-align: right;'><b>TOTAL</b></td>
										<td style='width: 5mm;'>:</td>
										<td style='text-align: right; width: 35mm;'><b>$subtotal</b></td>
									</tr>
									
								</table>
							</td>
						</tr>
					</table>
					";
	}
	
	ob_end_clean();
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('L', array('240', '130'),'fr', false, 'ISO-8859-15',array(2, 2, 2, 2)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>