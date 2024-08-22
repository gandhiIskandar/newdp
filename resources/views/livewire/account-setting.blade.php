<div class="row">

    <div class="col-lg-6">

        <div class="card">
            <div class="card-header">
                <h5>Edit Data Profile</h5>
            </div>
            <div class="card-body">
                <x-partials.flash-message />
                <form wire:submit='updateDataUser'>
                    <div class="row mb-3 justify-content-center">
                        <div class=" col-6 text-center">
                            <div class="position-relative d-inline-block">
                            
                                <img src="{{ $photo ? $photo->temporaryUrl() : asset('storage/'.$user->profile_image) }}"
                                    alt="user-image" class="user-avtar rounded-circle" style="width: 100px; height:100px; object-fit:cover; ">

                                

                                <button
                                    type="button"class="btn btn-icon btn-primary avtar-s mb-0 position-absolute top-0 end-0"
                                    onclick="openFileInput()"><i class="ph-duotone ph-pencil" style="font-size:15px;"
                                      ></i></button>

                            </div>
                            <input type="file" accept="image/png, image/jpeg" hidden wire:model='photo' id="fileInput">

                            <row wire:loading.class.remove='d-none' wire:target='photo' class="d-none mt-3">

                                <p >Uploading...</p>
                            </row>

                            
                       @error('photo') 
                                <p class="link-danger">{{ $message }}</p>
                             @enderror


                        </div>

                    </div>
                    <h5 class="mb-3">A. Personal Info:</h5>
                    <div class="mb-3 row">
                        <label class="col-lg-4 col-form-label text-lg-end">Name:</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" wire:model='name' placeholder="Enter full name"
                                {{ in_array(2, session('privileges')) ? '' : 'disabled' }} />
                            {{-- <small class="form-text text-muted">Please enter your full name</small> --}}
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-lg-4 col-form-label text-lg-end">Email:</label>
                        <div class="col-lg-6">
                            <input type="email" class="form-control" wire:model='email' placeholder="Enter email"
                                {{ in_array(2, session('privileges')) ? '' : 'disabled' }} />
                            {{-- <small class="form-text text-muted">Please enter your Email</small> --}}
                        </div>
                    </div>
                    <hr class="my-4" />
                    <h5 class="mb-3">B. Role Info:</h5>
                    <div class="mb-3 row">
                        <label class="col-lg-4 col-form-label text-lg-end">Role:</label>
                        <div class="col-lg-6">
                            <input type="email" class="form-control" wire:model='role' disabled />
                            {{-- <small class="form-text text-muted">Please enter your Final Degree</small> --}}
                        </div>
                    </div>


                    <div class="row justify-content-center mt-3">


                        <div class="col-6 text-center {{ privilegeChangePassword() ? '' : 'd-none' }}">
                            <button data-pc-animate="fade-in-scale" type="button" class="btn btn-info"
                                data-bs-toggle="modal" data-bs-target="#changePassword" style="width: 200px;"
                                type="button">Ganti Password</button>

                        </div>

                        <div class="col-6 text-center">
                            <button data-pc-animate="fade-in-scale" type="submit" class="btn btn-primary"
                                style="width: 200px;" type="button"
                                {{ privilegeEditUserData() ? '' : 'd-none' }}>Update Data</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



</div>


<script>

document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.getElementById('fileInput');

        fileInput.addEventListener('change', function() {
            var file = this.files[0]; // Ambil file yang dipilih
            var maxSize = 1024 * 1024; // Ukuran maksimum dalam bytes (1MB)

            if (file.size > maxSize) {
                alert('File tidak boleh melebihi 1 MB');
                this.value = null; // Reset nilai input file
            }
        });
    });
    function openFileInput() {
        $('#fileInput').click();
    }
</script>
