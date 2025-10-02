<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <div class="row">
        <div class="card">
            <div class="card-header justify-content-between">
                <h5>Personal information</h5>
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
                    <form action="">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" value="bomba.Ssemblian">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="bomba.99@yopmail.com">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="bomba.99@yopmail.com">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="provinsi" class="form-label required">Provinsi</label>
                                <select class="form-select" id="provinsi">
                                    <option selected>Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="kabupaten" class="form-label required">Kabupaten/Kota</label>
                                <select class="form-select" id="kabupaten">
                                    <option selected>Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="kecamatan" class="form-label required">Kecamatan</label>
                                <select class="form-select" id="kecamatan">
                                    <option selected>Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="Kelurahan" class="form-label required">Kelurahan/Desa</label>
                                <select class="form-select" id="Kelurahan">
                                    <option selected>Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="kodepos" class="form-label required">Kode pos</label>
                                <input type="kodepos" class="form-control" id="kodepos" value="bomba.99@yopmail.com">
                            </div>
                            <div class="col-md-5 mb-2">
                                <label for="tmptlahir" class="form-label required">Place or birth</label>
                                <input type="tmptlahir" class="form-control" id="tmptlahir" value="bomba.99@yopmail.com">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="date" class="form-label required">Date</label>
                                <input type="date" class="form-control" id="date" value="bomba.99@yopmail.com">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="gender" class="form-label required">Gender</label>
                                <select class="form-select" id="gender">
                                    <option selected>Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="">
                                <label for="floatingTextarea2">Address</label>
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                            </div>
                            <div class='action d-flex justify-content-start gap-2'>
                                <button class='btn btn-sm btn-warning text-white'>Submit</button>
                                <button class='btn btn-sm btn-danger'>Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


