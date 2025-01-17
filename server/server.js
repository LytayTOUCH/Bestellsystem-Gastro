var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

http.listen(3000, function(){
	console.log('Der Server wurde gestartet');
});

io.on('connection', function(socket){
	socket.emit('connected');
	console.log('Eine Verbindung wurde aufgebaut');

	// Bestellungen
	socket.on('order created', function(data) {
		console.log('Eine Bestellung wurde generiert');
		socket.broadcast.emit('order created', data);
	});	 

	socket.on('order changed', function(data) {
		console.log('Eine Bestellung wurde bearbeitet: ' + data.id);

		// Wenn keine Produkte mehr vorhanden sind, entferne Bestellung
		if(data.produkte.length >= 1) {
			socket.broadcast.emit('order changed', null);
		} else {
			console.log('Eine Bestellung wurde aufgrund keiner Produkte geschlossen: ' + data.id);
			socket.broadcast.emit('order closed', data);
		}
	});

	socket.on('order closed', function(data) {
		// Bestellung(id)
		console.log('Eine Bestellung wurde abgeschlossen');
		socket.broadcast.emit('order closed', data);
	});

	// Abrechnungen
	socket.on('order payed', function(data) {
		// Kunde(id)
		console.log('Eine Abrechnungen wurde durchgeführt');
		socket.broadcast.emit('order payed', null);
	});

	socket.on('disconnect', function(){
		console.log('Eine Verbindung wurde getrennt');
	});

	socket.on('delete all', function() {
		socket.broadcast.emit('delete all', null);
	});
});