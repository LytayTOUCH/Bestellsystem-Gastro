const socket = io('http://localhost:3000');

$(document).ready(function() {
	
	if($("#orders").length) {
		// Aktionen bei Bestellungen
		socket.on('order created', function(data) {
			// Spiele einen Sound ab und blinken
			new Audio('../sounds/confident.mp3').play()
		});

		socket.on('order changed', function(data) {
			
		});

		socket.on('order closed', function(data) {
			
		});
	}

	// Aktionen bei Abrechnungen
	socket.on('order payed', function(data) {
		
	});
});