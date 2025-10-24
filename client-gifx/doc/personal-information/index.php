<?php

$query = $db->prepare('SELECT DISTINCT KDP_PROV FROM tb_kodepos ORDER BY KDP_PROV ASC');
$query->execute();
$result = $query->get_result();
$values = $result->fetch_all(MYSQLI_ASSOC);

$query = $db->prepare('SELECT * FROM tb_member WHERE MBR_ID = ?');
$query->bind_param("s", $user['MBR_ID']);
$query->execute();
$member = $query->get_result()->fetch_assoc();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <div class="row">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-primary">Personal Information</h6>
            </div>
        </div>
        <div class="col">
            <!-- upload -->
            <div class="card">
                <div class="card-body text-center">
                    <div style="position: relative; display: inline-block;">
                        <img id="preview" src="../assets/images/admin.png" 
                            alt="Profile" width="120" height="120" style="border-radius: 50%; object-fit: cover;">
                        <label for="uploadFoto" 
                            style="position: absolute; bottom: -5px; right: -5px;
                                    width: 36px; height: 36px;
                                    display: flex; justify-content: center; align-items: center;
                                    background: white; border: 2px solid blue;
                                    border-radius: 50%; cursor: pointer;">
                            <i class="bi bi-camera-fill" style="font-size: 18px; color: black;"></i>
                        </label>
                    </div>
                    <input type="file" id="uploadFoto" accept="image/*" style="display:none;">
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <form id="form">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $member['MBR_NAME']?>" disabled>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $member['MBR_EMAIL']?>" disabled>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="nomer" class="form-label">nomer telepon</label>
                                <input type="nomer" class="form-control" id="nomer" name="nomer">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="provinsi" class="form-label required">Provinsi</label>
                                <select class="form-select" id="provinsi" name="provinsi">
                                    <option selected>Select</option>
                                    <?php foreach($values as $value): ?>
                                    <option value="<?=  $value['KDP_PROV'] ?>"><?= $value['KDP_PROV'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="kabupaten" class="form-label required">Kabupaten/Kota</label>
                                <select class="form-select" id="kabupaten">
                                    <option selected>Select</option>
                                    <option value=""></option>

                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="kecamatan" class="form-label required">Kecamatan</label>
                                <select class="form-select" id="kecamatan">
                                    <option selected>Select</option>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="kelurahan" class="form-label required">Kelurahan/Desa</label>
                                <select class="form-select" id="kelurahan">
                                    <option selected>Select</option>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="kodepos" class="form-label required">Kode pos</label>
                                <input type="text" class="form-control" id="kodepos" name="kodepos" readonly>
                            </div>
                            <div class="col-md-5 mb-2">
                                <label for="tmptlahir" class="form-label required">Place or birth</label>
                                <input type="text" class="form-control" id="tmptlahir" name="tmptlahir">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="date" class="form-label required">Date</label>
                                <input type="date" class="form-control" id="date" name="date">
                                <style>
                                    #date::-webkit-calendar-picker-indicator {
                                        filter: invert(1) brightness(0);
                                        cursor: pointer;
                                    }
                                    #date::-moz-calendar-picker-indicator {
                                        filter: invert(1) brightness(0);
                                    }
                                </style>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="gender" class="form-label required">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option selected>Select</option>
                                    <option>Laki - laki</option>
                                    <option>Perempuan</option>
                                </select>
                            </div>
                            <div class="">
                                <label for="address">Address</label>
                                <textarea class="form-control" placeholder="Leave a comment here" id="address" name="address" style="height: 100px"></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>

    $('#provinsi').on('change', function() {
    let prov = $(this).val();
    $('#kabupaten').html('<option>Loading...</option>');
    console.log('Requesting:', '/ajax/post/wilayah/regency?get=kabupaten&prov=' + prov);

    $.getJSON('/ajax/post/wilayah/regency?get=kabupaten&prov=' + prov, function(data) {
        $('#kabupaten').html('<option value="">Pilih Kabupaten</option>');
        $.each(data, function(i, val){
            $('#kabupaten').append('<option value="'+val.KDP_KABKO+'">'+val.KDP_KABKO+'</option>');
        });
    });
});
    
    // --- Ketika Kabupaten berubah ---
    $('#kabupaten').on('change', function() {
        let kab = $(this).val();
        $('#kecamatan').html('<option>Loading...</option>');
        console.log('Requesting:', '/ajax/post/wilayah/district?get=kecamatan&kab=' + kab);

        $.getJSON('/ajax/post/wilayah/district?get=kecamatan&kab=' + kab, function(data) {
            $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
            $.each(data, function(i, val){
                $('#kecamatan').append('<option value="'+val.KDP_KECAMATAN+'">'+val.KDP_KECAMATAN+'</option>');
            });
        });
    });

    $('#kecamatan').on('change', function() {
        let kec = $(this).val();
        $('#kelurahan').html('<option>Loading...</option>');
        console.log('Requesting:', '/ajax/post/wilayah/villages?get=kelurahan&kec=' + kec);

        $.getJSON('/ajax/post/wilayah/villages?get=kelurahan&kec=' + kec, function(data) {
            $('#kelurahan').html('<option value="">Pilih Kelurahan</option>');
            $.each(data, function(i, val){
                $('#kelurahan').append('<option value="'+val.KDP_KELURAHAN+'">'+val.KDP_KELURAHAN+'</option>');
            });
        });

        // 🔹 Ambil kode pos otomatis dari backend
        $.getJSON('/ajax/post/profil/getKodepos?kec=' + kec, function(res) {
            if (res && res.KDP_POS) {
                $('#kodepos').val(res.KDP_POS);
            } else {
                $('#kodepos').val('');
            }
        });
    });
    $(document).ready(function(){
        $('#form').on('submit', function(e){
            e.preventDefault();

            let button = $(this).find('button[type="submit"]');
            button.addClass('loading')

            const data = {
                name : $('#name').val().trim(),
                email : $('#email').val().trim(),
                nomer : $('#nomer').val().trim(),
                provinsi : $('#provinsi').val().trim(),
                kabupaten : $('#kabupaten').val().trim(),
                kecamatan : $('#kecamatan').val().trim(),
                kelurahan : $('#kelurahan').val().trim(),
                kodepos : $('#kodepos').val().trim(),
                tmptlahir : $('#tmptlahir').val().trim(),
                date : $('#date').val().trim(),
                gender : $('#gender').val().trim(),
                address : $('#address').val().trim()
            };

            // let formData = new FormData(this);

            $.ajax({
                url: '/ajax/post/profil/create',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                    data: JSON.stringify(data),   
                    success: function(response) {
                        // menghapus efek loading setelah muncul alert sukses pd saat menambahkan nilai
                        button.removeClass('loading')
                        Swal.fire(response.alert)
                        $('#form')[0].reset();
                    },
                });
        })
    })
</script>


