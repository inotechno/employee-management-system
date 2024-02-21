@extends('layouts.app.index')

@section('title')
    Profile
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Profile</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Configuration</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3">
            <div class="card">
                <h5 class="card-header bg-transparent border-bottom">Profile Picture</h5>
                <div class="card-body">
                    <div class="card-body text-center">
                        @if ($user->foto == null)
                            <img id="preview-image-before-upload" src="{{ asset('images/users/default.jpg') }}"
                                alt="preview image" style="max-height: 100px;">
                        @else
                            <img id="preview-image-before-upload" src="{{ asset('images/users/' . $user->foto) }}"
                                alt="preview image"
                                style="height: 180px; width: 180px; border-radius: 100px; margin-left:-15px;">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <h5 class="card-header bg-transparent border-bottom">Account Details</h5>
                <div class="card-body">
                    <form action="{{ route('users.update.employee', $user->id) }}" method="POST" class="needs-validation"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label>Full name</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    name="name" placeholder="Full name" value="{{ $user->name }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Username</label>
                                <input class="form-control @error('username') is-invalid @enderror" type="text"
                                    placeholder="Username" name="username" value="{{ $user->username }}" readonly>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label>Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                    name="email" placeholder="Email" value="{{ $user->email }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label>Position</label>
                                <select name="position_id" class="form-control @error('position_id') is-invalid @enderror">
                                    <option selected disabled> -Pilih Position-</option>
                                    @foreach ($position as $data)
                                        <option value="{{ $data->id }}"
                                            {{ old('position_id', $data->id) == $user->employee->position_id ? 'selected' : '' }}>
                                            {{ $data->name }} </option>
                                    @endforeach
                                </select>
                                @error('position_id')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label>BPJS Kesehatan</label>
                                <input class="form-control" type="text" placeholder="BPJS Kesehatan"
                                    name="bpjs_kesehatan" value="{{ $user->employee->bpjs_kesehatan }}">
                                @error('bpjs_kesehatan')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>BPJS Ketenagakerjaan</label>
                                <input class="form-control @error('bpjs_ketenagakerjaan') is-invalid @enderror"
                                    name="bpjs_ketenagakerjaan" type="text" placeholder="BPJS Ketenagakerjaan"
                                    value="{{ $user->employee->bpjs_ketenagakerjaan }}">
                                @error('bpjs_ketenagakerjaan')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label>Tempat Lahir</label>
                                <input class="form-control @error('tempat_lahir') is-invalid @enderror" type="text"
                                    name="tempat_lahir" placeholder="Tempat Lahir"
                                    value="{{ $user->employee->tempat_lahir }}">
                                @error('tempat_lahir')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Tanggal Lahir</label>
                                <input class="form-control @error('tanggal_lahir') is-invalid @enderror" type="date"
                                    name="tanggal_lahir" placeholder="Tanggal Lahir"
                                    value="{{ $user->employee->tanggal_lahir }}">
                                @error('tanggal_lahir')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label>Nama Rekening</label>
                                <input class="form-control" type="text" placeholder="Nama Rekening"
                                    name="nama_rekening" value="{{ $user->employee->nama_rekening }}">
                                @error('nama_rekening')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>No Rekening</label>
                                <input class="form-control @error('no_rekening') is-invalid @enderror" name="no_rekening"
                                    type="number" placeholder="No Rekening" value="{{ $user->employee->no_rekening }}">
                                @error('no_rekening')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label>Pemilik Rekening</label>
                                <input class="form-control @error('pemilik_rekening') is-invalid @enderror"
                                    name="pemilik_rekening" type="text" placeholder="Pemilik Rekening"
                                    value="{{ $user->employee->pemilik_rekening }}">
                                @error('pemilik_rekening')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Foto</label>
                                <input class="form-control @error('foto') is-invalid @enderror" type="file"
                                    name="foto" placeholder="Choose image">
                                @error('foto')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card">
                <h5 class="card-header bg-transparent border-bottom">Change Password</h5>
                <div class="card-body">
                    <form action="{{ route('users.update.password.employee', $user->id) }}" method="POST"
                        class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label>Password Lama</label>
                            <input class="form-control @error('old_password') is-invalid @enderror" type="password"
                                name="old_password" placeholder="Password Lama">
                            @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                name="password" placeholder="Password Baru">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Konfirmasi Password</label>
                            <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                type="password" name="password_confirmation" placeholder="Password Konfirmasi">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Change</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('plugin')
    <script type="text/javascript">
        $(document).ready(function(e) {


            $('#foto').change(function() {

                let reader = new FileReader();

                reader.onload = (e) => {

                    $('#preview-image-before-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);

            });

        });
    </script>
@endsection
