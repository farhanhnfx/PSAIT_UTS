<?php
require_once "config.php";
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
   case 'GET':
         if(!empty($_GET["nim"]))
         {
            $nim=$_GET["nim"];
            get_nilai_mahasiswa($nim);
         }
         else
         {
            get_nilai_mahasiswa_all();
         }
         break;
   case 'POST':
         if(!empty($_GET["nim"]))
         {
            $nim=$_GET["nim"];
            $kode_mk=$_GET["kode_mk"];
            update_nilai_mahasiswa($nim, $kode_mk);
         }
         else
         {
            insert_nilai_mahasiswa();
         }     
         break; 
   case 'DELETE':
         $nim=$_GET["nim"];
         $kode_mk=$_GET["kode_mk"];
         delete_nilai_mahasiswa($nim, $kode_mk);
         break;
   default:
      // Invalid Request Method
         header("HTTP/1.0 405 Method Not Allowed");
         break;
      break;
 }



   function get_nilai_mahasiswa_all()
   {
      global $mysqli;
      $query="SELECT mahasiswa.*, matakuliah.*, perkuliahan.nilai 
               FROM (perkuliahan JOIN mahasiswa ON perkuliahan.nim = mahasiswa.nim) 
                     JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk;";
      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Get Nilai All Mahasiswa Successfully.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }
 
   function get_nilai_mahasiswa($nim)
   {
      global $mysqli;
      $query="SELECT mahasiswa.*, matakuliah.*, perkuliahan.nilai 
               FROM (perkuliahan JOIN mahasiswa ON perkuliahan.nim = mahasiswa.nim) 
                     JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk";
      if($nim != null || $nim != "")
      {
         $query.=" WHERE mahasiswa.nim='".$nim."'";
      }
      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Get Nilai Mahasiswa Successfully.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
        
   }
 
   function insert_nilai_mahasiswa()
      {
         global $mysqli;
         if(!empty($_POST["nilai"])){
            $data=$_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('nim' => '','kode_mk' => '', 'nilai' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         
         if($hitung == count($arrcheckpost)){
          
               $result = mysqli_query($mysqli, "INSERT INTO perkuliahan SET
                           nim = '$data[nim]',
                           kode_mk = '$data[kode_mk]',
                           nilai = '$data[nilai]'");                
               if($result)
               {
                  $response=array(
                     'status' => 1,
                     'message' =>'Nilai Mahasiswa Added Successfully.'
                  );
               }
               else
               {
                  $response=array(
                     'status' => 0,
                     'message' =>'Nilai Mahasiswa Addition Failed.'
                  );
               }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Parameter Do Not Match'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
 
   function update_nilai_mahasiswa($nim, $kode_mk)
      {
         global $mysqli;
         if(!empty($_POST["nilai"])){
            $data=$_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('nilai' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         
         if($hitung == count($arrcheckpost)){    

            $result = mysqli_query($mysqli, "UPDATE perkuliahan SET
                        nilai = '$data[nilai]'
                        WHERE nim = '$nim' AND kode_mk = '$kode_mk'");
          
            if($result)
            {
               $response=array(
                  'status' => 1,
                  'message' =>'Nilai Mahasiswa Updated Successfully.'
               );
            }
            else
            {
               $response=array(
                  'status' => 0,
                  'message' =>'Nilai Mahasiswa Updation Failed.'
               );
            }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Parameter Do Not Match'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
 
   function delete_nilai_mahasiswa($nim, $kode_mk)
   {
      global $mysqli;
      $query="DELETE FROM perkuliahan WHERE nim='".$nim."' AND kode_mk='".$kode_mk."'";
      if(mysqli_query($mysqli, $query))
      {
         $response=array(
            'status' => 1,
            'message' =>'Nilai Mahasiswa Deleted Successfully.'
         );
      }
      else
      {
         $response=array(
            'status' => 0,
            'message' =>'Nilai Mahasiswa Deletion Failed.'
         );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }

 
?> 
