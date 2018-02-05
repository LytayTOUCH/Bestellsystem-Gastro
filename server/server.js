var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

http.listen(3000, function(){
	console.log('Der Server wurde gestartet');
});

io.on('connection', function(socket){
	console.log('Eine Verbindung wurde aufgebaut');

	// Bestellungen
	socket.on('order created', function(data) {
		console.log('Eine Bestellung wurde generiert');
		socket.broadcast.emit('order created', null);
	});	

	socket.on('order changed', function(data) {
		console.log('Eine Bestellung wurde bearbeitet');
		socket.broadcast.emit('order changed', null);
	});

	socket.on('order closed', function(data) {
		console.log('Eine Bestellung wurde abgeschlossen');
		socket.broadcast.emit('order closed', null);
	});

	// Abrechnungen
	socket.on('order payed', function(data) {
		console.log('Eine Abrechnungen wurde durchgeführt');
		socket.broadcast.emit('order payed', null);
	});

	socket.on('disconnect', function(){
		console.log('Eine Verbindung wurde getrennt');
	});
});