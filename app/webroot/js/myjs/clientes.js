$(document).ready(function(){


	$("#nombrecliente").keyup(function(e){
   			
   		if(e.keyCode == 13) {
	        guardar();
	    }

   	}) 

   	$("#guardar").click(function(e){

   		guardar();

   	})

	
	function guardar(){

            var n = $("#nombrecliente").val();
   			var url = "clientes/index";
            var cola = $("#cola").val();
   			if (n == '') 
   			{
   				//$('msj_error').html('Debe ingresar un nombre de cliente o cerrar la ventana');
   				
   				alert('Cliente debe tener un nombre');

   			} else{

               if (cola == '')
               {

                  alert('Debe seleccionar el servicio del cliente');

               }else{
                   $('msj_error').html('');
               $.ajax({
               type:"post",
               url: url,
               data: {
                  nombre: n,
                  cola_id: cola
               },

                  success: function(data){

                     
                     //$("modal-default").trigger("reset");
                     $("#modal-default").modal('hide'); //Ocultamos el modal
                     $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
                     $('.modal-backdrop').remove();//eliminamos el backdrop del modal
                        
                  },

                  error: function(){
                  alert('Error en función javascript de Clientes/index.ctp');
                }

               });
               }

   				

   			}

	}


	

});