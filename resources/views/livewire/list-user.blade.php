<div class="row">
    <div class="col-12">
      
        <x-partials.flash-message />

        <div class="card">
            <div class="card-header">
                
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Users Data</h5>
                    <button wire:click='$dispatch("showModalNonEditStateUser")' type="button" class="btn btn-primary"
                        style="width: 200px;" type="button">Tambah User</button>
                </div>
            
            </div>
            <div class="card-body">
                <livewire:p-g-user-table/>

               

            </div>
        </div>
    </div>

    <livewire:modal-input-user/>
    <livewire:modal-input-task/>
   
</div>
