<?php

$nim = $_GET['nim'];
$kode_mk = $_GET['kode_mk'];
// var_dump($_GET);

//Pastikan sesuai dengan alamat endpoint dari REST API di ubuntu
$url='localhost/sait_uts/nilai_mahasiswa_api.php?nim='.$nim.'&kode_mk='.$kode_mk.'';



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// pastikan method nya adalah delete
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$result = json_decode($result, true);

curl_close($ch);

header("Location: index.php");

//var_dump($result);
// tampilkan return statusnya, apakah sukses atau tidak
print("<center><br>status :  {$result["status"]} "); 
print("<br>");
print("message :  {$result["message"]} "); 
 //
echo "<br>Sukses menghapus data di ubuntu server !";
echo "<br><a href=index.php> OK </a>";

?>