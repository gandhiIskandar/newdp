<div wire:ignore.self class="modal fade modal-animate" id="modalWhitelist" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Whitelist IP Adress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <x-partials.flash-message />

                <div class="mb-3">
                    <label class="form-label" for="exampleInputEmail1">IP Address</label>
                    <input type="text" class="form-control" wire:model="ip_address" id="exampleInputEmail1" />
                </div>



                 @if ($whitelists != null)
                    <div class="new-task">
                        @foreach ($whitelists as $whitelist)
                            <div class="to-do-list mb-3">
                                <div class="d-inline-block w-100">

                                    <div class="d-flex align-items-center justify-content-between w-100">

                                        <label>{{ $whitelist->ip_address }}</label>

                                        <button type="button" wire:click="deleteWhitelist({{ $whitelist->id }})"
                                            wire:confirm="Yakin ingin hapus IP Address ini?"
                                            class="btn btn-icon btn-danger avtar-xs mb-0 remove-task"
                                            wire:loading.attr="disabled">X</button>
                                    </div>
                                    
                                </div>

                            </div>
                        @endforeach



                    </div>
                @endif 

            </div>











            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary shadow-2" wire:click='insertWhitelist()'>Tambah IP
                    Address</button>
            </div>
        </div>
    </div>

</div>
