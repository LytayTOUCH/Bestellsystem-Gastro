const socket = io('http://localhost:3000');

$(document).ready(function() {

	// Aktionen bei Bestellungen
	socket.on('order created', function() {});
	socket.on('order changed', function() {});
	socket.on('order closed', function() {});

	// Aktionen bei Abrechnungen
	socket.on('order payed', function() {});
});