<?php
require_once "config.php";
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
   case 'GET':
         if(!empty($_GET["kode_mk"]))
         {
            $kode_mk=$_GET["kode_mk"];
            get_matakuliah($kode_mk);
         }
         else
         {
            get_matakuliah_all();
         }
         break;
   default:
      // Invalid Request Method
         header("HTTP/1.0 405 Method Not Allowed");
         break;
      break;
 }



   function get_matakuliah_all()
   {
      global $mysqli;
      $query="SELECT * FROM matakuliah";
      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Get All Mata Kuliah Successfully.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }
 
   function get_matakuliah($kode_mk)
   {
      global $mysqli;
      $query="SELECT * FROM matakuliah";
      if($kode_mk != null || $kode_mk != "")
      {
         $query.=" WHERE kode_mk='".$kode_mk."'";
      }
      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Get Mata Kuliah Successfully.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
        
   }
 
 
?> 
