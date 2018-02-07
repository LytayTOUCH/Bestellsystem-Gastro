const socket = io('http://localhost:3000');
socket.on('connected', function () {
	console.log('Die Verbindung zum Dynamic-Server wurde hergestellt');
});

$(document).ready(function() {
	// Bestellungen
	if($("#orders").length) {
		// Aktionen bei Bestellungen
		socket.on('order created', function(data) {
			// Für Debugging-Zwecke
			console.log(data);

			// Spiele einen Sound ab
			new Audio('../sounds/confident.mp3').play()

			/*
			// Füge diese zu der Liste hinzu
			var template = $("#order_template");
			var content = template.clone();

			if($('.remove_on_incoming_order').length) {
				$('.remove_on_incoming_order').remove();
			}

			content.removeAttr('id', null);
			content.attr('order_id', data.id);
			content.appendTo("#orderlist");

			var order = $('order[order_id="'+data.id+'"]');
			console.log(order);
			order.find('.order_tablename').text(data.table.name);
			//content.find('.order_close_link').attr('href', 'bestellungen/abschliessen/'+data.id);
			//content.find('.order_storno_link').attr('href', 'bestellungen/stornieren/'+data.id);
			// http://bestellsystem.local/bestellungen/produkt/stornieren/1
			// http://bestellsystem.local/bestellungen/produkt/kostenlos/1*/
		});

		socket.on('order changed', function(data) {
			
		});

		socket.on('order closed', function(data) {
			$('.order[order_id="'+data.id+'"]').remove();
			console.log($('.order').length);
			if($('.order').length == 1) {
				$('#orderlist').text('Keine offenen Bestellungen');
			}
		});
	}

	// Abrechnungen
	socket.on('order payed', function(data) {
		
	});

	socket.on('maintenance message', function(data) {
		alert(data.message);
	});
});

	// Wartungsarbeiten
	function sendMaintenanceMessage(text) {
		socket.emit('maintenance message', {message: text})
	}