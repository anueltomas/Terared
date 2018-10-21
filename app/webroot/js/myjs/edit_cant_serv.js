$(document).ready(function(){

	var idTicket  = $("#ticket").val();

	$('.edit_cant').on('keyup change', function(event){
		var servicio = $(this).attr("data-servicio");
		var cantidad = Math.round($(this).val());
		cambio_cantidad($(this).attr("data-id"), cantidad, servicio);

	});

	function cambio_cantidad(iddetalle, cantidad, servicio){
		$.ajax({
			type: "POST",
			url: basePath + 'detalleTickets/edit_cantidad',
			data: {
				idServicio	: servicio,
				cantidad 	: cantidad,
				idDetalle 	: iddetalle,
				idTicket	: idTicket
			},
			dataType: "json",
			success: function(data){

				

					setTimeout(function() {
						//$('#precio').html('Bs.' + data.mostrar_datos.precio);
						$('#monto').html(data.enviar_por_json.monto).animate({backgroundColor: "#ff8"}, 100).animate({backgroundColor: '#fff'}, 1000);
					}, 200);
				

				
				setTimeout(function() {
					$('#total').html(data.enviar_por_json.total).animate({backgroundColor: "#ff8"}, 100).animate({backgroundColor: '#fff'}, 1000);
				}, 200);

				location.reload();
				

			}
		});
		

	}

});