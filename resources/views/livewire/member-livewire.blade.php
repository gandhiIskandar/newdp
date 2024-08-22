<div class="row">

    @if(privilegeViewMemberAccount())
    <div class="col-md-12 mb-3">
        <select wire:model.live='jenisTabel' class="form-select rounded-3 form-select-sm w-auto">
            <option selected value=2>Data Member</option>
            
            <option  value=1>Rekening Member</option>
        </select>
    </div>
    @endif
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    @if($jenisTabel == 2)
                    <h5>Members Data</h5>
                    <button wire:click='$dispatch("showCreateModalMember")' type="button"
                    class="btn btn-primary" style="width: 200px;" type="button">Tambah Member</button>
                    @else
                        @if(privilegeAddMemberAccount())
                    <h5>Rekening Member</h5> 
                    <button wire:click='$dispatch("showModalMemberAccountNonEdit")' type="button"
                    class="btn btn-primary" style="width: 250px;" type="button">Tambah Rekening Member</button>
                    @endif
                    @endif


                    {{-- <button wire:click='$dispatch("showModalNonEditStateUser")' type="button" class="btn btn-primary"
                        style="width: 200px;" type="button">Tambah User</button> --}}
                </div>

            </div>
            <div class="card-body">
                @if($jenisTabel == 2)
                <livewire:p-g-member-table />
                @else
                <livewire:memberaccount.p-g-member-account-table/>
                @endif
                
            </div>
        </div>
         <livewire:member-edit-modal />  
       <livewire:member-account.modal-input /> 
    </div>
