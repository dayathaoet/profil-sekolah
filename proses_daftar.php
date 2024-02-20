<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    $check_existing_user = "SELECT * FROM `akun` WHERE username = ?";
    
    $stmt = $koneksi->prepare($check_existing_user);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $input_akun = "INSERT INTO `akun` (`username`, `password`, `level`) VALUES (?, ?, '3')";
        $input_murid = "INSERT INTO `murid` (`nisn`, `nama_murid`, `kota`, `jenkel`, `agama`, `jurusan`, `kelas`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt_akun = $koneksi->prepare($input_akun);
        $stmt_akun->bind_param('ss', $username, $password);
        $stmt_akun->execute();
        
        $stmt_murid = $koneksi->prepare($input_murid);
        $stmt_murid->bind_param('sssssss', $_POST['Nisn'], $_POST['Nama_Murid'], $_POST['Kota'], $_POST['Jenis_Kelamin'], $_POST['Agama'], $_POST['Jurusan'], $_POST['Kelas']);
        $stmt_murid->execute();
        
        echo "<script>
                window.alert('Berhasil Registrasi')
                window.location.href='index.php';
              </script>";
    } else {
        echo "<script>
                window.alert('Registrasi Gagal. Username sudah Terdaftar')
                window.location.href='index.php';
              </script>";
    }
    
    $stmt->close();
    $stmt_akun->close();
    $stmt_murid->close();
}

$koneksi->close();
?>
