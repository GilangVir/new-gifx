<div class="row">
    <div class="card">
        <div class="card-header justify-content-between">
            Daftar Bank
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div>Tambah Bank</div>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="mb-3">
                        <label for="nama_bank" class="form-control-label">Nama Bank</label>
                        <select class="form-select" id="nama_bank">
                            <option selected>Select</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nasabah" class="form-control-label">Nama Pemilik Rekening</label>
                        <input type="text" class="form-control" id="nasabah" name="nasabah" placeholder="Nama pemilik rekening">
                    </div>
                    <div class="mb-3">
                        <label for="nomer" class="form-control-label">No. Rekening</label>
                        <input type="text" class="form-control" id="nomer" name="nomer" placeholder="Nomer rekening">
                    </div>
                    <div class="mb-3">
                        <label for="buku_tabungan" class="form-label">Cover Buku Tabungan <span class="text-danger">*</span></label>
                        <div class="border border-2 rounded d-flex flex-column align-items-center justify-content-center p-5" 
                            style="cursor: pointer; min-height: 180px; text-align:center;" 
                            onclick="document.getElementById('buku_tabungan').click()">
                            <i class="bi bi-cloud-arrow-up fs-1 mb-2"></i>
                            <p class="text-muted">Drag and drop a file here or click</p>
                        </div>
                        <input type="file" class="form-control d-none" id="buku_tabungan" name="buku_tabungan">
                    </div>
                    <!-- Tombol Submit -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-warning px-4" style="color:white;">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- tabel -->
    <div class="col">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped" id="">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal Dibuat</th>
                            <th scope="col">Rekening</th>
                            <th scope="col">Status</th>
                            <th scope="col">#</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div