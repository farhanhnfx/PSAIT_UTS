<?php
require_once "config.php";
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
   case 'GET':
         if(!empty($_GET["nim"]))
         {
            $nim=$_GET["nim"];
            get_mahasiswa($nim);
         }
         else
         {
            get_mahasiswa_all();
         }
         break;
   default:
      // Invalid Request Method
         header("HTTP/1.0 405 Method Not Allowed");
         break;
      break;
 }



   function get_mahasiswa_all()
   {
      global $mysqli;
      $query="SELECT * FROM mahasiswa";
      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Get All Mahasiswa Successfully.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }
 
   function get_mahasiswa($nim)
   {
      global $mysqli;
      $query="SELECT * FROM mahasiswa";
      if($nim != null || $nim != "")
      {
         $query.=" WHERE nim='".$nim."'";
      }
      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Get Mahasiswa Successfully.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
        
   }
 
 
?> 
