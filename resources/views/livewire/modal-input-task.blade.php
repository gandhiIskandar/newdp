<div wire:ignore.self class="modal fade modal-animate" id="modalTask" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tugas User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <x-partials.flash-message />

                {{-- formnya lagi sengklek, wire:submitnya ga ada efek sekali, apa kali maunya wire:submit ini!! --}}
                <div class="mb-3">
                    <label class="form-label" for="exampleInputEmail1">Nama</label>
                    <input type="text" class="form-control" wire:model="name" id="exampleInputEmail1" disabled />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="exampleInputEmail1">Role</label>
                    <input type="text" class="form-control" wire:model="role" id="exampleInputEmail2" disabled />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="exampleInputEmail1">Task Baru</label>
                    <input type="text" class="form-control" wire:model="newTask" id="exampleInputEmail3" />
                </div>


                @if ($tasks != null)
                    <div class="new-task">
                        @foreach ($tasks as $task)
                            <div class="to-do-list mb-3">
                                <div class="d-inline-block w-100">
                                    @if (!$task->is_completed)
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <div class="d-flex align-items-center">
                                                <i class="ti ti-circle text-warning me-2" style="font-size:1.5rem;"></i>
                                                
                                                <label>{{ $task->name }}</label>
                                            </div>
                                            <button type="button" wire:click="deleteTask({{ $task->id }})"
                                                wire:confirm="Yakin ingin hapus task ini?"
                                                class="btn btn-icon btn-danger avtar-xs mb-0 remove-task"
                                                wire:loading.attr="disabled">X</button>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <div class="d-flex align-items-center">
                                                <i class="ti ti-circle-check text-success me-2"
                                                    style="font-size:1.5rem;"></i>
                                               
                                                <label>{{ $task->name }}</label>
                                            </div>
                                            <button type="button" wire:click="deleteTask({{ $task->id }})"  wire:confirm="Yakin ingin hapus task ini?"
                                                class="btn btn-icon btn-danger avtar-xs mb-0 remove-task"
                                                wire:loading.attr="disabled">X</button>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        @endforeach



                    </div>
                @endif




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary shadow-2 insert-task">Tambah Task</button>
            </div>

        </div>
    </div>
</div>

@push('script')


    @script
    
        <script>
         


            $(document).ready(function() {

                $wire.on('showModalTaskJS', (data) => {

                    $('#modalTask').modal('show');
                    buttonListener();


                });




                $(document).on("click", ".insert-task", function() {



                    $wire.dispatch('insertTask');


                });








            });


            function removeTask(task_id) {
                if (confirm('Yakin ingin hapus task ini ?')) {
                    $wire.dispatch('deleteTask', [task_id]);
                }

            }
        </script>
    @endscript


@endpush
