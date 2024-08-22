<select class="form-select" wire:model='website_id' wire:change='setWebsite'
    style="max-height: 30px; padding: 2px 100px 5px 10px !important">
    @foreach ($websites as $website)
        <option value="{{ $website->id }}" {{ session('website_id') == $website->id ? 'selected' : '' }}>
            {{ $website->name }}</option>
    @endforeach
</select>

{{-- @script
    <script>

        $wire.on('refreshJS', ()=>{
            location.reload(true);
        });
    </script>
@endscript --}}
