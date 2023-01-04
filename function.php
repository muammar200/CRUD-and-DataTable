<?php
    $koneksi = mysqli_connect('localhost', 'root', '', 'perpustakaan');

    function tambah_data($data){
        $judul = $data['judul'];
        $penulis = $data['penulis'];
        $tahun = $data['tahun_terbit'];
        $deskripsi = $data['deskripsi'];

        global $koneksi;

        $query = "INSERT INTO buku (judul, penulis, tahun_terbit, deskripsi) VALUES ('$judul', '$penulis', '$tahun', '$deskripsi')";

        mysqli_query($koneksi, $query);
        
        if(mysqli_affected_rows($koneksi)){
            header("location:index.php?insert_success");
        }
    }

    function edit_data($data){
        // var_dump($data);
        $id = $data['id'];
        $judul = $data['judul'];
        $penulis = $data['penulis'];
        $tahun = $data['tahun_terbit'];
        $deskripsi = $data['deskripsi'];

        global $koneksi;

        $query = "UPDATE buku SET judul = '$judul', penulis = '$penulis', tahun_terbit = '$tahun', deskripsi = '$deskripsi' WHERE id = '$id'";

        mysqli_query($koneksi, $query);
        
        if(mysqli_affected_rows($koneksi)){
            header("location:index.php?update_success");
        }
    } 

    function delete_data($id){
        // $id = $id['id'];

        $query = "DELETE FROM buku WHERE id = '$id'";

        global $koneksi;
        mysqli_query($koneksi, $query);

        if(mysqli_affected_rows($koneksi) > 0){
            header("location:index.php?delete_success");
        }
    }

?>