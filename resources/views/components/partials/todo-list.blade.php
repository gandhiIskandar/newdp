@props(['tasks'])

<div class="col-sm-4 d-flex">
    <div class="card flex-fill ">
        <div class="card-header">
            <h5>To Do List</h5>
        </div>
        @if ($tasks->count() != 0)
            <form wire:submit="updateTask" class="h-100">
                <div class="card-body widget-last-task d-flex flex-column  h-100">
                    <div class="new-task">
                        @foreach ($tasks as $task)
                            <div class="to-do-list mb-3">
                                <div class="d-inline-block">
                                    @if (!$task->is_completed)
                                        <div class="check-task form-check">

                                            <input type="checkbox" class="form-check-input" id="customCheck1"
                                                value="{{ $task->id }}" wire:model='finishedTask' />

                                            <label class="form-check-label"
                                                for="customCheck1">{{ $task->name }}</label>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center">
                                            <i class="material-icons-two-tone me-1 bg-success"
                                                style="font-size:1.5rem;">check</i>
                                            <label>{{ $task->name }}</label>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        @endforeach

                    </div>
                    <div class="d-grid gap-2 mt-auto">
                        <button class="btn btn-primary mt-auto" type="submit"
                            onclick="return confirm('Apakah tugas ini sudah selesai?')">Konfirmasi</button>
                    </div>
                </div>
            </form>

            @else

            <div class="h-100 w-100 d-flex justify-content-center align-items-center">
              <p class="fst-italic">-- Belum ada Tugas --</p>
            </div>
            @endif
    </div>
</div>

