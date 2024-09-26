<?php
include "koneksi.php";

if(function_exists($_GET['function'])){
    $_GET['function']();
}

// Menampilkan Data

function tampilData(){
    global $koneksi;

    $sql = mysqli_query($koneksi, "SELECT * FROM users");
    while($data = mysqli_fetch_object(($sql))){
        $user[] = $data;
    }

    $respon = array(
        'status' => 200,
        'pesan' => 'Berhasil Menampilkan Data',
        'users' => $user
    );

    header('Content-type: application/json');
    print json_encode($respon);
}

// Menambah Data

function tambahData(){
    global $koneksi;

    $isi = array(
        'nama' => '',
        'alamat' => '',
        'no_telp' => ''
    );

    $cek = count(array_intersect_key($_POST, $isi));

    if($cek == count($isi)){
        
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];

        $hasil = mysqli_query($koneksi, "INSERT INTO users VALUES('', '$nama', '$alamat', '$no_telp')");

        if($hasil){
            return pesan(1, "Berhasil Menambahkan Data $nama");
        }else{
            return pesan(0, "Gagal Menambahkan Data $nama");
        }
    }else{
        return pesan(0, "Gagal Menambah Data, parameter salah");
    }
}

function pesan($status, $pesan){
    $respon = array(
        'status' => $status,
        'pesan' => $pesan
    );

    header('Content-type: application/json');
    print json_encode($respon);
}

// Edit data

function editData(){
    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $isi = array(
        'nama' => '',
        'alamat' => '',
        'no_telp' => ''
    );

    $cek = count(array_intersect_key($_POST, $isi));

    if($cek == count($isi)){

        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];

        $sql = mysqli_query($koneksi, "UPDATE users SET id='$id', nama='$nama', alamat='$alamat', no_telp='$no_telp' WHERE id='$id'");

        if($sql){
            return pesan(1, "Berhasil Mengedit Data $nama");
        }else{
            return pesan(0, "Gagal Mengedit Data $nama");
        }
    }else{
        return pesan(0, "Gagal Mengedit Data, Parameter Salah");
    }
}

// Hapus Data

function hapusData(){
    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $sql = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

    if($sql){
        return pesan(1, "Berhasil Menghapus Data");
    }else{
        return pesan(0, "Gagal Menghapus Data");
    }
}

// Menampilkan Detail Data

function detailData(){
    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $sql = mysqli_query($koneksi, "SELECT *FROM users WHERE id='$id'");
    $data = mysqli_fetch_object($sql);

    $respon = array(
        'status' => 200,
        'pesan' => 'Berhasil Menampilkan Data',
        'user' => $data
    );

    header('Content-type: application/json');
    print json_encode($respon);
}


?>