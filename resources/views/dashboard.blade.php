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
                                                    <li class="p-2 border-bottom" style="cursor: pointer">
                                                        {{ $room->name }}
                                                        @if(!in_array($room->id, auth()->user()->rooms->pluck('id')->toArray()))
                                                            <button class="btn btn-warning">Join</button>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-7 col-xl-8">

                                    <div class="pt-3 pe-3" data-mdb-perfect-scrollbar="true"
                                         style="position: relative; height: 400px; overflow: auto;">

                                        <div class="d-flex flex-row justify-content-start">
                                            <div>
                                                <p class="small p-2 ms-3 mb-1 rounded-3"
                                                   style="background-color: #f5f6f7;">text.</p>
                                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug
                                                    13</p>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row justify-content-end">
                                            <div>
                                                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">text.</p>
                                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                            </div>
                                        </div>

                                    </div>
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
                    $( ".rooms" ).append("<li class=\"p-2 border-bottom\">\n" + data.name +
                        "\n" +
                        " <button class=\"btn btn-warning\">Join</button>\n" +
                        "</li>" );
                });
        }
    </script>
@endsection