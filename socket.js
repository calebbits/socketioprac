var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
redis.subscribe('test-channel', function(err, count) {
});

redis.on('message', function(channel, message) {
    console.log('Message Recieved('+channel+'): ' + message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});
io.sockets.on('connection',function(socket){
	socket.on('send message',function(data){
		console.log(data);
		io.sockets.emit('new message',data);
	});
});
/*redis.on('send message',function(channel,data){
	console.log('test');
	io.emit('new message',data);
});*/

http.listen(3000, function(){
    console.log('Listening on Port 3000');
});