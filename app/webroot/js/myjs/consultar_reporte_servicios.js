$(document).ready(function(){


   	$("#consultar").click(function(e){

   		consulta();

   	}) 

   function consulta(){
   	var g = "-";
   	var diainicio = $("#desdeDay").val();
   	var mesinicio = $("#desdeMonth").val();
   	var anioinicio = $("#desdeYear").val();
   	var inicio = anioinicio + g + mesinicio + g + diainicio;

   	var diafin = $("#hastaDay").val();
   	var mesfin = $("#hastaMonth").val();
   	var aniofin = $("#hastaYear").val();
   	var fin = aniofin + g + mesfin + g + diafin;

   	if (fin < inicio) {
   		alert("La fecha inicial debe ser menor a la fecha final")
   	}else{

   		consultar(inicio, fin);
   	}
   	

 
   
	}


	function consultar(inicio, fin){
		
		$.ajax({

		    type: 'POST',
		    url: basePath + "servicios/tabla_reporte",
		   	
		   	data: {
		   		//idTicket: ticket
		   		desde : inicio,
		   		hasta : fin
		   	},
		   	//dataType : 'json',
				//encode : true,
		    success: function(data){
		    	
		    	$('#tablaReporte').html(data);

		    },

		    error: function(){
		      alert('Error al mostrar la tabla de tablareporte:(');
		    }

	 	});

	}

});

