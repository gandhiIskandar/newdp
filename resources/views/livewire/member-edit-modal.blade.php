<div wire:ignore.self class="modal fade modal-animate" id="modalEditMember" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <x-partials.flash-message />
                <form wire:submit='procceedMember'>

                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" wire:model.live="username" id="exampleInputEmail1"
                            required />
                        @if ($username_exist == 1)
                            <small id="emailHelp" class="form-text text-muted">Username tersedia</small>
                        @elseif($username_exist == 2)
                            <small id="emailHelp" class="form-text text-muted">Username belum tersedia </small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Atas Nama Rekening</label>
                        <input type="text" class="form-control" wire:model="under_name"
                            id="exampleInputEmail1" required />
                        
                    </div>

                    <label class="form-label" for="norek">Rekening Member</label>
                    <div class="input-group mb-3">
                        <select class="form-select" wire:model.live='bank_id' id="accounted"
                            style="max-width: 120px !important;" required>

                            @foreach ($banks as $bank)
                                <option value={{ $bank->id }} {{ $loop->iteration == 1 ? 'selected' : '' }}>
                                    {{ $bank->name }}</option>
                            @endforeach


                        </select>

                        <input type="text" id="norek" wire:model='account_number' class="form-control"
                            aria-label="Amount (to the nearest dollar)" required />
                    </div>






            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary shadow-2" {{ $username_exist == 1 ? "disabled" : "" }}>Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

@push('script')

    @script
        <script>
               $(document).ready(function(){



                $wire.on('showEditModalJS', (data) => {
                    $('#modalEditMember').modal('show');
                });


                $wire.on('confirmRemoveMemberJS', (data) => {
                 if(confirm('Yakin ingin hapus member' + data.member.username  + '?')){
                   $wire.dispatch('removeMember', [data.member.id]);
                 }
              
               })



               }); 


              



        </script>
    @endscript


@endpush
