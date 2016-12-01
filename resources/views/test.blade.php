@extends('layouts.master')

@section('content')
    <p id="power">0</p>
    <div id="chatbox">

    </div>
    <div>
        <form id="send">
            <span>
                <input type="text" name="message" id="message">
                <button type="submit" id="send">Send</button>
            </span>
        </form>
    </div>
@stop

@section('footer')
    <script src="{{ asset('js/socket.io.js') }}"></script>
    <script>
        //var socket = io('http://localhost:3000');
        var socket = io('http://127.0.0.1:3000');
        
        $("#send").submit(function(){
            $(this).defaultPrevented();
            socket.emit("send",$("#message").val()); 
            $("#message").val("");
        });

        socket.on("send", function(message){
            // increase the power everytime we load test route
            $("#chatbox").append(message);
        });
        
        socket.on("test-channel:App\\Events\\Chat", function(message){
            // increase the power everytime we load test route
            $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
        });
    </script>
@stop