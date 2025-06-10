<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register Akun</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Registrasi Akun Baru!</h1>
                                    </div>
                                    <form class="user" action="/register" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control form-control-user"
                                                id="inputName" placeholder="Enter Full Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="inputEmail" name="email" aria-describedby="emailHelp"
                                                placeholder="Email.">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password.">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="university" class="form-control form-control-user"
                                                id="inputUniversity" placeholder="Asal Sekolah / Universitas ">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="field_of_study" class="form-control form-control-user"
                                                id="inputFieldOfStudy" placeholder=" Jurusan ">
                                        </div>
                                        <!-- Bidang -->
                                        <div class="form-group">
                                            <select name="bidang" class="form-control form-control-user" id="inputBidang" placeholder="Pilih Bidang">
                                                <option value="" disabled selected>Pilih Bidang</option>
                                                <option value="Pengembangan Komunikasi Publik">Pengembangan Komunikasi Publik</option>
                                                <option value="Sistem Pemerintahan Berbasis Elektronik">Sistem Pemerintahan Berbasis Elektronik</option>
                                                <option value="Pengelolaan Informasi Dan Saluran Komunikasi Publik">Pengelolaan Informasi Dan Saluran Komunikasi Publik</option>
                                                <option value="Pengelolaan Infrastruktur">Pengelolaan Infrastruktur</option>
                                                <option value="Statistik">Statistik</option>
                                                <option value="Sekretariat">Sekretariat</option>
                                            </select>
                                        </div>
                                        <!-- Profile Picture -->
                                        <div class="form-group">
                                            <label for="inputProfilePicture" class="btn btn-outline-primary btn-block">
                                                <i class="fas fa-upload"></i> Upload Foto Profil
                                            </label>
                                            <input type="file" name="profile_picture" class="form-control-file" id="inputProfilePicture" style="display: none;">
                                        </div>
                                        <!-- Surat Validasi -->
                                        <div class="form-group">
                                            <label for="inputSuratValidasi" class="btn btn-outline-primary btn-block">
                                                <i class="fas fa-upload"></i> Upload Surat Validasi
                                            </label>
                                            <input type="file" name="surat_validasi" class="form-control-file" id="inputSuratValidasi" style="display: none;">
                                            <small class="form-text text-muted">Upload surat pengantar dari kampus atau surat keterangan magang</small>
                                        </div>
                                        <!-- Hidden fields for status and role -->
                                        <input type="hidden" name="status" value="submitted">
                                        <input type="hidden" name="role" value="user">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Daftar
                                        </button>
                                        <hr>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="/">Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    {{-- Debug Error --}}
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
    @if ($errors->any())
        <script>
            Swal.fire({
                title: "Terjadi kesalahan",
                text: "@foreach ($errors->all() as $error ) {{ $error }} {{ $loop ->last ? '.' : ',' }} @endforeach",
                icon: "error"
            });
        </script>
    @endif

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
