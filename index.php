<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 100%;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
            
            $('.editButton').click(function(){
                var nim = $(this).data('nim'); // Get the student ID
                var kode_mk = $(this).data('kode_mk'); // Get the course code
                var nilai = $(this).data('nilai'); // Get the grade
                $('#editData').modal('show');

                console.log(nim);

                // Populate the form fields with existing data
                $('#editData').find('select[name="nim"]').val(nim);
                $('#editData').find('select[name="kode_mk"]').val(kode_mk);
                $('#editData').find('select[name="nim_hidden"]').val(nim);
                $('#editData').find('select[name="kode_mk_hidden"]').val(kode_mk);
                $('#editData').find('input[name="nilai"]').val(nilai);
            });

            $('.deleteButton').click(function(){
                var nim = $(this).data('nim'); // Get the student ID
                var kode_mk = $(this).data('kode_mk'); // Get the course code
                $('#deleteData').modal('show');

                // Store the data in the delete button for later use
                $('#deleteButton').data('nim', nim);
                $('#deleteButton').data('kode_mk', kode_mk);

                $('#deleteData').find('input[name="nim"]').val(nim);
                $('#deleteData').find('input[name="kode_mk"]').val(kode_mk);
                console.log(kode_mk)
            });

        });
    </script>
    <style>
        div.scroll {

        width: 100%;
        height: 800px;
        overflow: scroll;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Data Nilai Mahasiswa</h2>
                        <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target="#createData"><i class="fa fa-plus"></i>Tambah Data</a>
                    </div>

                    
                    <div class="modal fade" id="createData">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title"><strong>Tambah Data</strong></h5>
                                </div>

                                <div class="modal-body">
                                    <form action="insertNilaiMhsDo.php" method="POST">
                                    
                                        <?php
                                            $curl= curl_init();
                                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                            //Pastikan sesuai dengan alamat endpoint dari REST API di UBUNTU, 
                                            curl_setopt($curl, CURLOPT_URL, 'localhost/sait_uts/mahasiswa_api.php');
                                            $resMhs = curl_exec($curl);
                                            $jsonMhs = json_decode($resMhs, true);

                                            curl_setopt($curl, CURLOPT_URL, 'localhost/sait_uts/matakuliah_api.php');
                                            $resMk = curl_exec($curl);
                                            $jsonMk = json_decode($resMk, true);
                                            curl_close($curl);
                                        ?>
                                        <div class="form-group col-md-12 mb-3">
                                            <label class="col-12 mb-2">Mahasiswa</label>
                                            <div class="col-sm-12">
                                            <select name="nim" id="nim" class="form-control">
                                                <?php foreach ($jsonMhs["data"] as $mahasiswa) : ?>
                                                    <option value="<?php echo $mahasiswa["nim"]; ?>"><?php echo $mahasiswa["nim"] . " - " . $mahasiswa["nama"]; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-3">
                                            <label class="col-12 mb-2">Mata Kuliah</label>
                                            <div class="col-sm-12">
                                            <select name="kode_mk" id="kode_mk" class="form-control">
                                                <?php foreach ($jsonMk["data"] as $matakuliah) : ?>
                                                    <option value="<?php echo $matakuliah["kode_mk"]; ?>"><?php echo $matakuliah["kode_mk"] . " - " . $matakuliah["nama_mk"]; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-3">
                                            <label class="col-12 mb-2">Nilai</label>
                                            <div class="col-sm-12">
                                                <input type="number" name="nilai" class="form-control form-control-normal" placeholder="Nilai" required>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-3">
                                            <div class="col-sm-12">
                                                <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editData">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><strong>Edit Data Nilai Mahasiswa</strong></h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form action="updateNilaiMhsDo.php" method="POST">
                                    
                                        <?php
                                            $curl= curl_init();
                                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                            //Pastikan sesuai dengan alamat endpoint dari REST API di UBUNTU, 
                                            curl_setopt($curl, CURLOPT_URL, 'localhost/sait_uts/mahasiswa_api.php');
                                            $resMhs = curl_exec($curl);
                                            $jsonMhs = json_decode($resMhs, true);

                                            curl_setopt($curl, CURLOPT_URL, 'localhost/sait_uts/matakuliah_api.php');
                                            $resMk = curl_exec($curl);
                                            $jsonMk = json_decode($resMk, true);
                                            curl_close($curl);
                                        ?>
                                        <div class="form-group col-md-12 mb-3">
                                            <label class="col-12 mb-2">Mahasiswa</label>
                                            <div class="col-sm-12">
                                            <select disabled name="nim" id="nim" class="form-control">
                                                <?php foreach ($jsonMhs["data"] as $mahasiswa) : ?>
                                                    <option value="<?php echo $mahasiswa["nim"]; ?>"><?php echo $mahasiswa["nim"] . " - " . $mahasiswa["nama"]; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <select hidden name="nim_hidden" id="nim_hidden" class="form-control">
                                                <?php foreach ($jsonMhs["data"] as $mahasiswa) : ?>
                                                    <option value="<?php echo $mahasiswa["nim"]; ?>"><?php echo $mahasiswa["nim"] . " - " . $mahasiswa["nama"]; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-3">
                                            <label class="col-12 mb-2">Mata Kuliah</label>
                                            <div class="col-sm-12">
                                            <select disabled name="kode_mk" id="kode_mk" class="form-control">
                                                <?php foreach ($jsonMk["data"] as $matakuliah) : ?>
                                                    <option value="<?php echo $matakuliah["kode_mk"]; ?>"><?php echo $matakuliah["kode_mk"] . " - " . $matakuliah["nama_mk"]; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <select hidden name="kode_mk_hidden" id="kode_mk_hidden" class="form-control">
                                                <?php foreach ($jsonMk["data"] as $matakuliah) : ?>
                                                    <option value="<?php echo $matakuliah["kode_mk"]; ?>"><?php echo $matakuliah["kode_mk"] . " - " . $matakuliah["nama_mk"]; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-3">
                                            <label class="col-12 mb-2">Nilai</label>
                                            <div class="col-sm-12">
                                                <input type="number" name="nilai" class="form-control form-control-normal" placeholder="Nilai" required>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-3">
                                            <div class="col-sm-12">
                                                <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteData">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><strong>Hapus Data Nilai Mahasiswa</strong></h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Yakin ingin hapus data?</p>
                                    <form action="deleteNilaiMhsDo.php" method="DELETE">
                                        <input type="hidden" name="nim" id="nim" value="">
                                        <input type="hidden" name="kode_mk" id="kode_mk" value="">
                                        <input type="submit" class="btn btn-danger" name="submit" value="Hapus">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="scroll">
                    <?php
                    $curl= curl_init();
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    //Pastikan sesuai dengan alamat endpoint dari REST API di UBUNTU, 
                    curl_setopt($curl, CURLOPT_URL, 'localhost/sait_uts/nilai_mahasiswa_api.php');
                    $res = curl_exec($curl);
                    $json = json_decode($res, true);

                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>NIM</th>";
                                        echo "<th>Nama</th>";
                                        echo "<th>Alamat</th>";
                                        echo "<th>Tanggal Lahir</th>";
                                        echo "<th>Kode MK</th>";
                                        echo "<th>Nama MK</th>";
                                        echo "<th>SKS</th>";
                                        echo "<th>Nilai</th>";
                                        echo "<th>Aksi</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                for ($i = 0; $i < count($json["data"]); $i++){
                                    echo "<tr>";
                                        echo "<td> {$json["data"][$i]["nim"]} </td>";
                                        echo "<td> {$json["data"][$i]["nama"]} </td>";
                                        echo "<td> {$json["data"][$i]["alamat"]} </td>";
                                        echo "<td> {$json["data"][$i]["tanggal_lahir"]} </td>";
                                        echo "<td> {$json["data"][$i]["kode_mk"]} </td>";
                                        echo "<td> {$json["data"][$i]["nama_mk"]} </td>";
                                        echo "<td> {$json["data"][$i]["sks"]} </td>";
                                        echo "<td> {$json["data"][$i]["nilai"]} </td>";
                                        echo "<td>";
                                            // echo '<a href="updateMahasiswaView.php?id_mhs='. $json["data"][$i]["nim"] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            // echo '<a href="deleteMahasiswaDo.php?id_mhs='. $json["data"][$i]["nim"] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                            
                                            echo '<a href="#" class="editButton mr-3" data-nim="' . $json["data"][$i]["nim"] . '" data-kode_mk="'. $json["data"][$i]["kode_mk"] . '" data-nilai="'. $json["data"][$i]["nilai"] . '"' . 'data-toggle="modal" data-target="#editData"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="#" class="deleteButton" data-nim="' . $json["data"][$i]["nim"] . '" data-kode_mk="'. $json["data"][$i]["kode_mk"] . '" data-nilai="'. $json["data"][$i]["nilai"] . '"' . ' data-toggle="modal" data-target="#deleteData"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";

                    curl_close($curl);
                    ?>
                </div>
                </div>
            </div>        
        </div>
    </div>

    <p><p><p>
    
   
</body>
</html>