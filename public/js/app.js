$(document).ready(function() {
	const socket = io('http://localhost:3000');
	socket.on('connected', function () {
		console.log('Die Verbindung zum Dynamic-Server wurde hergestellt');
	});

	// Bestellungen
	if($("#orders").length) {
		// Aktionen bei Bestellungen
		socket.on('order created', function(data) {
			// Für Debugging-Zwecke
			console.log(data);

			// Spiele einen Sound ab
			new Audio('../sounds/confident.mp3').play()

			var template = $("#order_template").clone();
			template.removeAttr('id');
			template.attr('order_id', data.id);
			template.appendTo("#orderlist");
			
			var template = $(".order[order_id='"+data.id+"']");
			template.find('.order_tablename').text(data.table.name);
			template.find('.order_close_link').attr('href', 'bestellungen/abschliessen/'+data.id);
			template.find('.order_storno_link').attr('href', 'bestellungen/stornieren/'+data.id);

			// Berücksichtige das Template in der If-Abfrage
			if($('.remove_on_incoming_order').length == 1) {
				$('.remove_on_incoming_order').remove();
			}

			// Füge Produkte ein
			for(i=0; i < data.produkte.length; ++i) {
				template.find('.products tr:last').after('<tr><td>'+data.produkte[i].product_name+'</td>'
						+ '<td>'+data.produkte[i].product_price+' €</td>'
						+ '<td><a href="bestellungen/produkt/stornieren/'+data.produkte[i].id+'" class="text-muted">Entfernen</a>, '
						+ '<a href="bestellungen/produkt/kostenlos/'+data.produkte[i].id+'" class="text-muted">Kostenlos</a></td>'
						+ '</tr>');
			}
		});

		socket.on('order changed', function(data) {
			
		});

		socket.on('order closed', function(data) {
			$('.order[order_id="'+data.id+'"]').remove();
			console.log($('.order').length);
			if($('.order').length == 1) {
				$('#orderlist').after('<i class="remove_on_incoming_order">Keine offenen Bestellungen</a>');
			}
		});

		socket.on('delete all', function(data) {
			$('.order[order_id]').remove();
			$('#orderlist').text('Keine offenen Bestellungen');
		});
	}

	// Abrechnungen
	socket.on('order payed', function(data) {
		
	});

	socket.on('maintenance message', function(data) {
		alert(data.message);
	});
});