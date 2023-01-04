<?php
    require "function.php";
    
    if(isset($_POST['kirim'])){
        tambah_data($_POST);
    }

    if(isset($_POST['update'])){
        edit_data($_POST);
    }

    if(isset($_POST['id_delete'])){
        $id = $_POST['id_delete'];
        delete_data($id);
    }

    $query = "SELECT * FROM buku";    
    $hasil = mysqli_query($koneksi, $query);
    $books = array();

    while ($baris = mysqli_fetch_assoc($hasil)){
        array_push($books, $baris);
    }


    // var_dump($_POST['kirim']); die();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
        if(isset($_GET['insert_success'])){
            echo"
                <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Buku berhasil ditambahkan'
                })
                .then((a) => {
                    if(a.isConfirmed){
                        window.location.href = 'index.php';
                    }
                });
                </script>
            ";
        }
        if(isset($_GET['update_success'])){
            echo"
                <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Buku berhasil diupdate'
                })
                .then((a) => {
                    if(a.isConfirmed){
                        window.location.href = 'index.php';
                    }
                });
                </script>
            ";
        }
        if(isset($_GET['delete_success'])){
            echo"
                <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Buku berhasil dihapus'
                })
                .then((a) => {
                    if(a.isConfirmed){
                        window.location.href = 'index.php';
                    }
                });
                </script>
            ";
        }
    ?>
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-12 col-md-10 col-sm-12 flex-wrap">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="align-self-center">Data Buku</h6>
                            <button class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#tambahData_modal">Tambah Data</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="booktable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Buku</th>
                                    <th>Deskripsi</th>
                                    <th>Penulis</th>
                                    <th>Tahun Terbit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($books as $i => $book):
                                ?>
                                <tr>
                                    <td><?=$i + 1 ?></td>
                                    <td><?= $book['judul']?></td>
                                    <td><?= $book['deskripsi']?></td>
                                    <td><?= $book['penulis']?></td>
                                    <td><?= $book['tahun_terbit']?></td>
                                    <!-- <td> 
                                        <?php 
                                        // echo "
                                        // <button class='btn btn-sm btn-primary'>Edit</button>
                                        // <button class='btn btn-sm btn-danger'>Hapus</button>
                                        // ";
                                        ?>
                                    </td> -->
                                    <td>
                                        <div class="d-flex gap-3">
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#updateData_modal"
                                                onclick='updateForm(JSON.stringify(<?= json_encode($book);?>))'>Edit</button>

                                            <button onclick="delete_data(<?= $book ['id']?>)"
                                                class="btn btn-sm btn-danger">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="form_delete" action="" method="post">
        <input type="hidden" name="id_delete">
    </form>
    <!-- Modal -->
    <!-- Modal Input -->
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button> -->

    <!-- Modal -->
    <!-- Modal Input -->
    <div class="modal fade" id="tambahData_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Buku Baru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_insert" method="POST">
                        <input type="hidden" name="kirim">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Buku</label>
                            <input type="text" name="judul" class="form-control" id="judul"
                                placeholder="Masukkan judul buku">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="penulis" class="form-label">Penulis</label>
                                    <input type="text" name="penulis" class="form-control" id="penulis"
                                        placeholder="Masukkan nama penulis buku">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="tahun" class="form-label">Tahun Terbit</label>
                                    <input type="text" name="tahun_terbit" class="form-control" id="tahun"
                                        placeholder="Masukkan tahun terbit buku">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Buku</label>
                            <input type="text" name="deskripsi" class="form-control" id="deskripsi"
                                placeholder="Masukkan deskripsi buku">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button id="submit_form" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update -->
    <div class="modal fade" id="updateData_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_update" method="POST">
                        <input type="hidden" name="update">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Buku</label>
                            <input type="text" name="judul" class="form-control" id="judul"
                                placeholder="Masukkan judul buku">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="penulis" class="form-label">Penulis</label>
                                    <input type="text" name="penulis" class="form-control" id="penulis"
                                        placeholder="Masukkan nama penulis buku">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="tahun" class="form-label">Tahun Terbit</label>
                                    <input type="text" name="tahun_terbit" class="form-control" id="tahun_terbit"
                                        placeholder="Masukkan tahun terbit buku">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Buku</label>
                            <input type="text" name="deskripsi" class="form-control" id="deskripsi"
                                placeholder="Masukkan deskripsi buku">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button id="submit_form_update" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <script>
        const form = $('#form_insert');
        $('#submit_form').click(() => {
            form.submit();
        })

        //  const formUpdate = $('#form_update');
        $('#submit_form_update').click(function() {
            $('#form_update').submit();
        })

        function updateForm(data) {

            const book = JSON.parse(data);
            const form = '#form_update';
            $(form + ' #id').val(book.id);
            $(form + ' #judul').val(book.judul);
            $(form + ' #penulis').val(book.penulis);
            $(form + ' #deskripsi').val(book.deskripsi);
            $(form + ' #tahun_terbit').val(book.tahun_terbit);
        }

        function delete_data(id) {
            // alert(id);
            $('#form_delete input').val(id);
            Swal.fire({
                title: 'Yakin Hapus?',
                text: "Data akan dihapus secara permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_delete').submit();
                }
            })
        }
    </script>
    <script>
        $(document).ready(() => {
            $('#booktable').DataTable()
        })
    </script>

</body>

</html>