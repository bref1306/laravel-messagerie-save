<div class="col-md-3">
    @foreach ($users as $user)
    <div class="list-group">
        <a class="list-group-item d-flex justify-content-between align-items-center" href="{{route('conversations.show',$user->id)}}">
            {{ $user->name }} 
        
                @if (isset($unread[$user->id]))
                    <span class="badge badge-pill badge-primary">
                        ({{ $unread[$user->id]}})
                    </span>
                @endif
        </a>
    </div>
@endforeach

</div>