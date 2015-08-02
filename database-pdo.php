<!DOCTYPE html>
<html>
<head>
	<title>Demo PDO Database</title>
</head>
<body>
<h1>Contoh Manipulasi data dengan PDO</h1>
<?php
$host = 'localhost';
$dbName = 'dbname';
$username = 'root';
$password = '';

$dbCon = new PDO("mysql:host=".$host.";dbname=".$dbName, $username, $password);

pdo_select($dbCon);
pdo_update($dbCon);

?>
</body>
</html>

<?php

function pdo_query($dbCon, $sql)
{
	$stmt = $dbCon->prepare($sql);
	$stmt->execute();
	if(get_jumlah_baris($stmt)>0)
		tampil_hasil($stmt,[0,1,2,3]);
	else
		echo 'Hasil query tidak ada';
}
function pdo_select($dbCon)
{
	$sql = 'SELECT * FROM t_peg order by id desc LIMIT 10';
	$stmt = $dbCon->prepare($sql);
	$stmt->execute();
	tampil_hasil($stmt,[0,1,2,3]);	
}

function pdo_select1($dbCon) //with unnamed parameter
{
	$sql = 'SELECT * FROM t_peg WHERE id >= ?';
	$stmt = $dbCon->prepare($sql);
	$stmt->execute(array(90));
	tampil_hasil($stmt,[0,1,2,3]);
}

function pdo_select2($dbCon) //with named parameter
{
	$sql = 'SELECT * FROM t_peg WHERE id >= :idstart';
	$stmt = $dbCon->prepare($sql);

	$kriteria = array( 'idstart' => 90);
	$stmt->execute($kriteria);
	tampil_hasil($stmt,[0,1,2,3]);
}

function pdo_insert($dbCon)
{
	$sql = 'INSERT INTO t_peg(nama) VALUES(?)';
	$stmt = $dbCon->prepare($sql);
	$stmt->execute(array('bla bla bla'));
	echo 'Baris terinsert: ' .  get_jumlah_baris($stmt);
	echo '<br>Id last insert: ' . get_last_insertid($dbCon);
}
function pdo_update($dbCon)
{
	$sql = 'UPDATE t_peg set nama=:nama order by id desc limit 1';
	$stmt = $dbCon->prepare($sql);
	$stmt->execute(['nama'=>'Paijo Maksimal']);
	echo 'Baris terupdate: ' .  get_jumlah_baris($stmt);
	echo '<br>Id last insert: ' . get_last_insertid($dbCon);
}

function pdo_hapus($dbCon)
{
	$sql = 'DELETE FROM t_peg WHERE id';
	$DBH->exec();
}

function get_jumlah_baris($stmt) //$stmt: statement PDO
{
	return $stmt->rowCount();
}

function get_last_insertid($dbCon)
{
	return $dbCon->lastInsertId();
}

function tampil_hasil($stmt, $koloms, $delimiter = ' | ') //$stmt: statement PDO
{
	while ($baris = $stmt->fetch()) 
	{
		foreach ($koloms as $kolom) {
			echo (empty($baris[$kolom])?'-':$baris[$kolom]) . $delimiter;
		}
		echo '<br>';
	}
}
