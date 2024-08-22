<div class="col-12">

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Log Kegiatan</h5>

              
            </div>
          
        </div>
        <div class="card-body" wire:ignore>

            <table id="table-log" class="table table-striped table-bordered nowrap" style="width: 100%">
                <thead>

                    <tr>

                        <th>No</th>
                        @if(privilegeViewDateLog())
                        <th>Tanggal</th>
                        @endif
                        @if(privilegeViewUsernameLog())
                        <th>Username</th>
                        @endif
                        @if(privilegeViewIpLog())
                        <th>IP</th>
                        @endif
                        @if(privilegeViewActivityLog())
                        <th>Activity</th>
                        @endif
                        @if(privilegeViewTargetLog())
                        <th>Target</th>
                        @endif
                        @if(privilegeViewDeskripsiLog())
                        <th>Deskripsi</th>
                        @endif



                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            @if(privilegeViewDateLog())
                            <td> {{ $log->date }} </td>
                            @endif
                            @if(privilegeViewUsernameLog())
                            <td>{{ $log->username }}</td>
                            @endif
                            @if(privilegeViewIpLog())
                            <td>{{ $log->ip }}</td>
                            @endif
                            @if(privilegeViewActivityLog())
                            <td>{{ $log->activity }}</td>
                            @endif

                            @if(privilegeViewTargetLog())
                            @if($log->member_id !=null)
                            <td>{{ $log->member->username }}</td>
                            @elseif($log->user_id !=null)
                            <td>{{ $log->user->name }}</td>
                            @elseif($log->keterangan != null)
                            <td>{{ $log->keterangan }}</td>
                            @else
                            <td>-</td>
                            @endif
                            @endif
                            @if(privilegeViewDeskripsiLog())
                            <td>{{ $log->deskripsi }}</td>
                            @endif
                        </tr>
                    @endforeach

                </tbody>

            </table>


        </div>
    </div>
</div>


@push('script')


        <script>
            $(document).ready(function() {
                var table = $('#table-log').DataTable({
                    "responsive": true,
                    "order": [],
                    "columnDefs": [{
                        className: 'dt-center',
                        targets: '_all'
                    }],

                });

            });





        </script>
  

@endpush
