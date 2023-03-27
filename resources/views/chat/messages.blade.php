<div class="pt-3 pe-3 chat-history_{{ $room->id }}" data-mdb-perfect-scrollbar="true">
    @foreach($room->messages as $message)
        @if($message->user_id === auth()->id())
            <div class="d-flex flex-row justify-content-start">
                <div>
                    <p class="small p-2 ms-3 mb-1 rounded-3"
                       style="background-color: #f5f6f7;">{{ $message->message }}</p>
                    <p class="small ms-3 mb-3 rounded-3 text-muted float-end">{{ $message->created_at }}</p>
                </div>
            </div>
        @else
            <div class="d-flex flex-row justify-content-end">
                <div>
                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">{{ $message->message }}</p>
                    <p class="small me-3 mb-3 rounded-3 text-muted">{{ $message->created_at }}</p>
                </div>
            </div>
        @endif
    @endforeach
</div>