@extends('app')
@section('title') Dashboard
@endsection
@section('content')
    <nav class="navbar navbar-light bg-light d-flex flex-row-reverse">
        <a class="navbar-brand" href="{{ route('logout') }}">Logout</a>
        <a class="btn btn-primary" href="{{ route('chat-room-create') }}">Create chat room</a>
    </nav>

    <section style="background-color: #CDC4F9;">
        <div class="container py-5">

            <div class="row">
                <div class="col-md-12">

                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

                                    <div class="p-3">

                                        <div data-mdb-perfect-scrollbar="true"
                                             style="position: relative; height: 400px; overflow: auto">
                                            <ul class="list-unstyled mb-0 rooms">
                                                @foreach($rooms as $room)
                                                    <li data-room-id="{{ $room->id }}" class="p-2 border-bottom {{ in_array($room->id, auth()->user()->rooms->pluck('id')->toArray()) ? '' : 'room' }}room" style="cursor: pointer">
                                                        {{ $room->name }}
                                                        @if(!in_array($room->id, auth()->user()->rooms->pluck('id')->toArray()))
                                                            <a href="chat/join/{{ $room->id }}" data-room-id="{{ $room->id }}" class="btn btn-warning join">Join</a>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-7 col-xl-8 messages" style="position: relative; height: 400px; overflow: auto;">


                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

@endsection
@section('script')
    <script type="text/javascript">
        window.onload = () => {
            Echo.channel('room-channel')
                .listen('.RoomCreated', (data) => {
                    $( ".rooms" ).append("<li data-room-id='" + data.id + "' class=\"p-2 border-bottom\">\n" + data.name +
                        "\n" +
                        " <a href='chat/join/" + data.id + "' class=\"btn btn-warning join\">Join</a>\n" +
                        "</li>" );
                })
                .listen('.SendMessage', (data) => {
                    if ({!! auth()->id() !!} === data.user_id) {
                        $(".chat-history_" + data.room_id).append("<div class=\"d-flex flex-row justify-content-end\">\n" +
                            "                <div>\n" +
                            "                    <p class=\"small p-2 me-3 mb-1 text-white rounded-3 bg-primary\">" + data.message + "</p>\n" +
                            "                    <p class=\"small me-3 mb-3 rounded-3 text-muted\">" + data.created_at + "</p>\n" +
                            "                </div>\n" +
                            "            </div>")
                    } else {
                        $(".chat-history_" + data.room_id).append("" +
                            "<div class=\"d-flex flex-row justify-content-start\">\n" +
                            "                <div>\n" +
                            "                    <p class=\"small p-2 ms-3 mb-1 rounded-3\"\n" +
                            "                       style=\"background-color: #f5f6f7;\">" + data.message + "</p>\n" +
                            "                    <p class=\"small ms-3 mb-3 rounded-3 text-muted float-end\">" + data.created_at + "</p>\n" +
                            "                </div>\n" +
                            "            </div>")
                    }


                });

            $(".room").click(function () {
                let roomId = $(this).data('room-id')
                $.ajax({
                    method: "get",
                    url: "/chat/get-messages",
                    data: {
                        roomId: roomId
                    }
                })
                    .done(function( data ) {
                        $(".text-area").remove()
                        $('.messages').html(data)
                        $(".messages").parent().append("<div class=\"d-flex text-area\">\n" +
                            "<textarea class=\"w-100\" name=\"\" id=\"message\" cols=\"30\" rows=\"10\"></textarea>\n" +
                            "<span class='btn btn-primary' type='submit' data-room-id='" + roomId + "' id=\"send\">Send</span>\n" +
                            "</div>")
                    });
            })

            $(document).on('click', '#send', function () {
                let text = $('#message').val()
                let roomId = $(this).data('room-id')
                if (text !== "") {
                    $.ajax({
                        method: "post",
                        url: "/chat/send-message",
                        data: {
                            _token: "{{ csrf_token() }}",
                            roomId: roomId,
                            text: text
                        }
                    });
                }
            })
        }
    </script>
@endsection