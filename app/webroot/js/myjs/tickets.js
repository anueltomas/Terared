$(document).ready(function(){

	var ticket  = $("#ticket").val();



	//refreshTabla(ticket);

	$('.numeric').on('keyup change', function(event){
		var cantidad = $("#cantidad").val();
		var servicio = $("#servicio").val();
		if (cantidad <= 0) {
			cantidad = 1;
			//alert("La cantidad debe ser mayor a 1.");
		}
		cambio_cantidad(cantidad, servicio);
	});



	$('.servicio').on('change', function(event){
		var cantidad = $("#cantidad").val();
		var servicio = $("#servicio").val();
		cambio_servicio(cantidad, servicio);
	});


	$('#guardar').on('click', function(event){

			guardar(mycallback);


	});

	$("#cantidad").keyup(function(e){
   			
   		if(e.keyCode == 13) {
	        guardar(mycallback);
	    }

   	}) 

	

	function refreshTabla(ticket)
	{


		$.ajax({

		    type: 'post',
		    url: basePath + "tickets/detalle_ticket",
		   	
		   	data: {
		   		idTicket: ticket
		   	},

		    success: function(data){

		      $('#detalleTicket').load('detalle_ticket');

		    },

		    error: function(){
		      alert('Error al mostrar la tabla de detalle_ticket:(');
		    }

	 	});

	}



	function guardar(callback){

		var cantidad = $("#cantidad").val();
		var servicio = $("#servicio").val();
		var ticket 	= $("#ticket").val();
		var resultado;

		resultado = validar_campos(cantidad, servicio);

		if (resultado == true) {

			$.ajax({
			type: "POST",
			url: basePath + "tickets/verificarservicio",
			data: {
				idServicio: servicio,
				idTicket: ticket
			},
			success: callback,
			error: function(){
				alert('Error en function guardar de script ticktrans.js');
			}

			});

		}//FIN IF resultado  == true


	}//FIN FUNCTION GUARDAR

	function mycallback(data){

		var result = data;

					if (result == 0) {

						alert('Servicio ya añadido.');
					}

					else
					{
						guardar_datos();

						$("#modal-default").modal('hide'); //Ocultamos el modal
						$('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
  						$('.modal-backdrop').remove();//eliminamos el backdrop del modal
  						//refreshTabla();
  						location.reload();
  						//$("#tablaDetalleTicket").load("#tablaDetalleTicket");

  						setTimeout(function() {
							$('.total').animate({backgroundColor: "#ff8"}, 100).animate({backgroundColor: '#fff'}, 1000);
						}, 200);

  						$('#msg').html('<div class="alert alert-success flash-msg">Servicio Añadido. </div>');
						$('.flash-msg').delay(2000).fadeOut("slow");
					}



	}//FIN FUNCTION MYCALLBACK



	function validar_campos(cantidad, servicio){

		if (cantidad <= 0 )
		{

			alert("Cantidad debe ser mayor a Cero");
			return false;

		}else if (servicio == '') {

			alert("Debe seleccionar un servicio");
			return false;

		}else {

			return true;

		}

	}

	function guardar_datos(event){

		var datos = {

			'cantidad'			: $("#cantidad").val(),
			'servicio_id'		: $("#servicio").val(),
			'ticket_id'			: $("#ticket").val(),
			'monto'				: $("#monto").val(),
			'precio'			: $("#precio").val(),


		};

		$.ajax({

			type : 'POST',
			url: basePath + 'detalleTickets/add_ajax',
			data: datos,
			dataType : 'json',
				encode : true,

			success: function(data){

				

	   		}

		})

			//.done(function(data) {
				//console.log(data);
			//});


	}



	function cambio_servicio(cantidad, servicio){

		$.ajax({
			type: "POST",
			url: basePath + "tickets/precioservicio",
			data: {
				idServicio: servicio,
				cantidad: cantidad
			},

			dataType: "json",
			success: function(data){

					if (cantidad != '') {
						$('.precio').val(data.mostrar_datos.precio);
						$('.monto').val(data.mostrar_datos.monto);
						$('.Monto').val(data.mostrar_datos.monto);
						$("#cantidad").val('1');
					}else{
						$('.precio').val(data.mostrar_datos.precio);
						$('.monto').val(data.mostrar_datos.monto);
						$('.Monto').val(data.mostrar_datos.monto);
						$("#cantidad").val('1');
					}
	},
			error: function(data){
		      alert('Error en función cambio_servicio de ticktrans.js');
		    }

		});

	}



	function cambio_cantidad(cantidad, servicio){
		$.ajax({
			type: "POST",
			url: basePath + "tickets/calculomonto",
			data: {
				idServicio: servicio,
				cantidad: cantidad
			},
			dataType: "json",
			success: function(data){

				if (cantidad != '') {
					//$('#precio').html('Bs.' + data.mostrar_datos.precio);
					$('.monto').val(data.mostrar_datos.monto);
					$('.Monto').val(data.mostrar_datos.monto);
				}else{
					//$('#precio').html('Bs.' + data.mostrar_datos.precio);
					$('.monto').val(data.mostrar_datos.monto);
					$('.Monto').val(data.mostrar_datos.monto);
					$("#cantidad").val('1');
				}


			}
		});


	}



});
