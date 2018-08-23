$(document).ready(function(){

	
	var idTicket  = $("#ticket").val();

	$('.remove').click(function(){
		
		ajaxserv($(this).attr("id"), 0, idTicket);
		//refreshTabla();

		return false;

	});//FIN DE LA FUNCTION CLICK

	function ajaxserv(id, cantidad)
	{
		if (cantidad === 0) 
		{
			$('#row-' + id).fadeOut(1000, function(){$('#row-' + id).remove();});
		}

		$.ajax({
			type: 'POST',
			url: basePath + 'detalleTickets/delete',
			data: {
				idServicio: id,
				idTicket: idTicket
			},
			dataType: 'json',
			success: function(data){
				$('#msg').html('<div class="alert alert-success flash-msg">Servicio Eliminado. </div>');
				$('.flash-msg').delay(2000).fadeOut("slow");

				
				setTimeout(function() {
					$('.total').val(data.mostrar_total_servicios).animate({backgroundColor: "#ff8"}, 100).animate({backgroundColor: '#fff'}, 1000);
				}, 200);

				location.reload();

			},

			error: function(){
				alert('1 Problema al eliminar servicio de tickets');
			},
		});
	};

	function refreshTabla(){
	    $.ajax({

		    type: 'post',
		    url: '../detalle_ticket',
		    data:{

		    },

		    success: function(data){

		    $('#detalleTicket').load('../detalle_ticket');

		  	},
		   
		    error: function(){
		      alert('Error al mostrar la tabla de detalle_ticket');
		    },

	  	});

  };

  

});//FIN DEL SCRIPT