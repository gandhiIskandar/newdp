<div wire:ignore.self class="modal fade modal-animate" id="animateModal11" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                @if ($edit)
                    <h5 class="modal-title">Edit Transaksi</h5>
                @else
                    <h5 class="modal-title">Tambah Transaksi</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <x-partials.flash-message />
                <form wire:submit='proccedMemberAccount'>


                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Member</label>
                        <select class="form-select" wire:model='form.member_id' id="exampleFormControlSelect1"
                            required>

                            @foreach ($members as $member)
                                <option value="{{ $member->id }}" {{ $loop->iteration == 1 ? 'selected' : '' }}>
                                    {{ $member->username }}</option>
                            @endforeach


                        </select>
                    </div>

                    <div class="mb-3">

                        <label class="form-label" for="exampleFormControlSelect1">Bank</label>
                        <select class="form-select" wire:model='form.bank_id' id="exampleFormControlSelect1" required>
                            @foreach ($banks as $bank)
                                <option value={{ $bank->id }} {{ $loop->iteration == 1 ? 'selected' : '' }}>
                                    {{ $bank->name }}</option>
                            @endforeach

                        </select>
                    </div>




                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Nomor Rekening</label>
                        <input type="text" class="form-control" wire:model.live="form.number" id="nomor"
                            placeholder="Masukan Nomor Rekening" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Atas Nama Rekening</label>
                        <input type="text" class="form-control" wire:model.live="form.under_name" id="atasnama"
                            placeholder="Masukan Atas Nama Rekening" required />
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary shadow-2">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


@push('script')

    @script
        <script>
            $(document).ready(function() {


                $wire.on('showModalMemberAccountJS', (data) => {

                    $('#animateModal11').modal('show');


                });

                $wire.on('deleteMemberAccountConfirmJS', (data)=>{
                if(confirm('Yakin ingin hapus transaksi ' + data.memberAccount.under_name  + '?')){
                $wire.dispatch('removeMemberAccount',[data.memberAccount]);
                }
            });



                //   $wire.on('showModalMemberAccountJS', (data) => {

                //       $('#animateModal11').modal('show');


                //   });
            });
        </script>
    @endscript


@endpush
