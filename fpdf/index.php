<?php
if(isset($_POST['download']))
{

	require('fpdf.php');
	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(40,10,'Hello World!');
	echo $pdf->Output();		
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Create PDF</title>
</head>
<body>
<h1>Coba PDF with FPDF</h1>

<form method="POST">
	<input type="submit" value="Download" name="download">
</form>
</body>
</html>

