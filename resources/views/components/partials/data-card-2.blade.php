@props(['data', 'currency' => false, 'icon', 'color'])

<div class="col-sm-4">
    <div class="card {{ $color }} text-white widget-visitor-card">
        <div class="card-body text-center">
            @if ($currency)
                <h2 class="text-white">@currency($data)</h2>
            @else
                <h2 class="text-white">{{ $data }}</h2>
            @endif    
                <h6 class="text-white">{{ $slot }}</h6>
                <i class="material-icons-two-tone d-block f-46 text-white">{{ $icon }}</i>
        </div>
    </div>
</div>
