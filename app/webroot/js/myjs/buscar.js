$(document).ready(function(){
	$("#b").autocomplete({
		minLength: 2,
		select: function(event, ui){
			$("#s").val(ui.item.label);
		
		},

		source: function(request, response) {
			$.ajax({
				url: basePath + "servicios/buscarjson",
				data: {
					term: request.term
				},
				dataType: "json",
				success: function(data){
					response($.map(data, function(el, index){
						return{
							value: el.Servicio.nombreservicio,
							nombre: el.Servicio.nombreservicio,
							precio: el.Servicio.precio,
						};
					}));
				}
			});

		}
		

	}).data("ui-autocomplete")._renderItem = function(ul, item){
		return $("<li></li>")
		.data("item.autocomplete", item)
		.append(item.nombre)
		.append(' ==> ')
		.append(item.precio)
		.appendTo(ul)
	};


});

