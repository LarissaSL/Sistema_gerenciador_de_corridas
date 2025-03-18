<div>
    {{-- Se a notificação é fechavel --}}
    @if($dismissible)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    {{-- Notificação fechavel --}}
    @else
        <div class="alert alert-danger" role="alert">
            <p>{{ $message }}</p>
        </div>
    @endif
</div>