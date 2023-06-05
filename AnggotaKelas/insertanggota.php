<?php
// insertanggota.php
include 'connection.php';

//INSERT INTO `detail_anggota_kelas` (`nama`, `nim`, `gender`, `tempat_lahir`, `tanggal_lahir`, `agama`, `pendidikan`, `pekerjaan`, `kewarganegaraan`, `nomor_hp`, `keterangan`, `CREATED_AT`, `UPDATED_AT`) VALUES (`nama`, `nim`, `gender`, `tempat_lahir`, `tanggal_lahir`, `agama`, `pendidikan`, `pekerjaan`, `kewarganegaraan`, `nomor_hp`, `keterangan`, `CREATED_AT`, `UPDATED_AT`);

// prepare > bind > execute

$conn = getConnection();

try {
    if($_POST){
        $nama = $_POST["nama"];
        $nim = $_POST["nim"];
        $gender = $_POST["gender"];
        $tempat_lahir = $_POST["tempat_lahir"];
        $tanggal_lahir = $_POST["tanggal_lahir"];
        $agama = $_POST["agama"];
        $pendidikan = $_POST["pendidikan"];
        $pekerjaan = $_POST["pekerjaan"];
        $kewarganegaraan = $_POST["kewarganegaraan"];
        $nomor_hp = $_POST["nomor_hp"];
        
        if(isset($_FILES["keterangan"]["name"])){
            $image_name = $_FILES["keterangan"]["name"];
            $extensions = ["jpg", "png", "jpeg"];
            $extension = pathinfo($image_name, PATHINFO_EXTENSION);
            
            if (in_array($extension, $extensions)){
                $upload_path = 'upload/' . $image_name;

                if(move_uploaded_file($_FILES["keterangan"]["tmp_name"], $upload_path)){

                    $keterangan = "http://localhost/anggotakelas/" . $upload_path; 

                    $statement = $conn->prepare("INSERT INTO `detail_anggota_kelas` (`nama`, `nim`, `gender`, `tempat_lahir`, `tanggal_lahir`, `agama`, `pendidikan`, `pekerjaan`, `kewarganegaraan`, `nomor_hp`, `keterangan`) VALUES (:nama, :nim, :gender, :tempat_lahir, :tanggal_lahir, :agama, :pendidikan, :pekerjaan, :kewarganegaraan, :nomor_hp, :keterangan);");

                    $statement->bindParam(':nama', $nama);
                    $statement->bindParam(':nim',$nim);
                    $statement->bindParam(':gender',$gender);
                    $statement->bindParam(':tempat_lahir',$tempat_lahir);
                    $statement->bindParam(':tanggal_lahir',$tanggal_lahir);
                    $statement->bindParam(':agama', $agama);
                    $statement->bindParam(':pendidikan',$pendidikan);
                    $statement->bindParam(':pekerjaan',$pekerjaan);
                    $statement->bindParam(':kewarganegaraan',$kewarganegaraan);
                    $statement->bindParam(':nomor_hp',$nomor_hp);
                    $statement->bindParam(':keterangan', $keterangan);

                    $statement->execute();

                    $response["message"] = "Data Berhasil Direcord!";
                    
                } else {
                    echo "gagal memindahkan file";
                }
            } else {
                $response["message"] = "Hanya diperbolehkan menginput keterangan gambar!";
            }

        } else {
            $statement = $conn->prepare("INSERT INTO `detail_anggota_kelas` (`nama`, `nim`, `gender`, `tempat_lahir`, `tanggal_lahir`, `agama`, `pendidikan`, `pekerjaan`, `kewarganegaraan`, `nomor_hp`, `keterangan`) VALUES (:nama, :nim, :gender, :tempat_lahir, :tanggal_lahir, :agama, :pendidikan, :pekerjaan, :kewarganegaraan, :nomor_hp, :keterangan);");

            $statement->bindParam(':nama', $nama);
            $statement->bindParam(':nim',$nim);
            $statement->bindParam(':gender',$gender);
            $statement->bindParam(':tempat_lahir',$tempat_lahir);
            $statement->bindParam(':tanggal_lahir',$tanggal_lahir);
            $statement->bindParam(':agama', $agama);
            $statement->bindParam(':pendidikan',$pendidikan);
            $statement->bindParam(':pekerjaan',$pekerjaan);
            $statement->bindParam(':kewarganegaraan',$kewarganegaraan);
            $statement->bindParam(':nomor_hp',$nomor_hp);
            $statement->bindParam(':keterangan', $keterangan);
    
            $statement->execute();
            $response["message"] = "Data berhasil direcord";
        }
    }
} catch (PDOException $e){
    $response["message"] = "error $e";
}
echo json_encode($response, JSON_PRETTY_PRINT);