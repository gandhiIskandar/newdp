<div wire:ignore.self class="modal fade modal-animate" id="modalKas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <x-partials.flash-message />
                <form wire:submit='proceedCashBook'>

                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Keterangan</label>
                        <input type="text" class="form-control" wire:model="form.detail" id="exampleInputEmail1"
                            placeholder="Masukan Keterangan Kas" required />
                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Jenis Kas</label>
                        <select class="form-select" wire:model='form.type_id' id="exampleFormControlSelect1" required>
                            <option value="">Pilih Jenis Kas</option>
                            <option value=3>Pengeluaran</option>
                            <option value=4>Pemasukan</option>

                        </select>
                    </div>
                    <label class="form-label" for="amount">Jumlah</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">BATH</span>
                        <input type="text" id="amount" wire:model='form.amount' class="form-control input-currency"
                            aria-label="Amount (to the nearest dollar)" required />

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

                $wire.on('showModalCashBookJS', (data) => {

                    $('#modalKas').modal('show');


                });
                
                $wire.on('removeConfirmCashBookJS', (data)=>{
                if(confirm('Yakin ingin hapus data kas ini ?')){
                $wire.dispatch('removeCashBook',[data.cashbook_id]);
                }

            });

        });
        </script>
    @endscript


@endpush
