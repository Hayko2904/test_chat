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
                                                    <li data-room-id="{{ $room->id }}" class="p-2 border-bottom" style="cursor: pointer">
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

                                <div class="col-md-6 col-lg-7 col-xl-8" style="position: relative; height: 400px; overflow: auto;">


                                </div>
                                <div class="d-flex">
                                    <textarea class="w-100" name="" id="" cols="30" rows="10"></textarea>
                                    <button>Send</button>
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
                });
        }
    </script>
@endsection