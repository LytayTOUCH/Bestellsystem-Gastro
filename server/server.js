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
		// Bestellung(id)
		// Table(Name)
		// Produkte(Name, Preise, Id)
		console.log('Eine Bestellung wurde bearbeitet');
		socket.broadcast.emit('order changed', null);
	});

	socket.on('order closed', function(data) {
		// Bestellung(id)
		console.log('Eine Bestellung wurde abgeschlossen');
		socket.broadcast.emit('order closed', data);
	});

	// -------- Sonstiges
	// Wartungsarbeiten
	socket.on('maintenance message', function(data) {
		console.log('Eine Wartungsnachricht wurde an alle Clients gesendet');
		socket.broadcast.emit('maintenance message', data);
	})

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