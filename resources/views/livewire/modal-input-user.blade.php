<!-- Modal -->
<div wire:ignore.self class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ $edit ? 'Edit Data User' : 'Tambah User' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">

                <form wire:submit='proceedUser'>

                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Nama</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" wire:model='form.name'
                            required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Email</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" wire:model='form.email'
                            required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Role</label>
                        <select class="form-select" wire:model='form.role_id' id="exampleFormControlSelect1" required>
                            <option value="">Pilih Role</option>

                            @foreach ($roles as $role)
                                <option value={{ $role->id }}>{{ $role->name }}</option>
                            @endforeach



                        </select>
                    </div>

                    @if (!$edit)
                        <div class="mb-3">
                            <label class="form-label" for="exampleInputEmail1">Password</label>
                            <input type="password" class="form-control" id="exampleInputEmail1"
                                wire:model='form.password' required />
                        </div>
                    @endif




                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Account Level:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 1) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary" id="customCheckinl31"
                                        value={{ $privilege->id }} wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Service Level:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 2)->where('name', '!=', 'null') as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary" id="customCheckinl31"
                                        value={{ $privilege->id }} wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Lihat Transaksi:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 6) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary" id="customCheckinl31"
                                        value={{ $privilege->id }} wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Member Level:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 3) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary" id="customCheckinl31"
                                        value={{ $privilege->id }} wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Lihat Member:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 8) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary" id="customCheckinl31"
                                        value={{ $privilege->id }} wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Log Level:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 11) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Lihat Log:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 7) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Kas Level:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 4) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Lihat Kas:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 9) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Pengeluaran Level:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 5) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Lihat Pengeluaran:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 10) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Rekening Member Level:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 13) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Rekening Admin Level:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 12) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Lihat Rekening Admin:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 14) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">TT Atas Level:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 15) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Lihat TT Atas:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 17) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Pinjam Atas Level:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 16) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>


                    <div class="mb-3 row align-items-center">
                        <label class="col-lg-3 col-form-label">Lihat Pinjam Atas:</label>
                        <div class="col-lg-9">

                            @foreach ($privileges->where('privilege_type_id', 18) as $privilege)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        id="customCheckinl31" value={{ $privilege->id }}
                                        wire:model='form.privileges' />
                                    <label class="form-check-label" for="customCheckinl31"
                                        style=" pointer-events: none; cursor: default;">{{ $privilege->name }}</label>
                                </div>
                            @endforeach


                        </div>
                    </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')

    @script
        <script>
            $(document).ready(function() {

                $wire.on('showModalUserJS', (data) => {

                    $('#modalUser').modal('show');


                });





                $wire.on('closeModal', (data) => {

                    $('#modalUser').modal('hide');

                    setTimeout(function() {
                        alert(data.message);
                    }, 1000);


                });


                $wire.on('removeConfirmUserJS', (data) => {
                    if (confirm('Yakin ingin hapus user ini ?')) {
                        $wire.dispatch('removeUser', [data.user_id]);
                    }

                });

            });
        </script>
    @endscript


@endpush
