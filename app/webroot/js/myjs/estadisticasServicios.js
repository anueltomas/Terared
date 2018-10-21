$(document).ready(function(){

   llenarGrafico();

   function llenarGrafico(){
   $.ajax({
      type: "POST",
      url: basePath + "estadisticas/servicios",
      data:"{}",
      dataType: "json",
      success : function(Result){
         
         //Result = Result.d;

         var data = [];

         for (var i in Result) {
            var datos = new Array(Result[i].nombre, Result[i].cantidad);
            data.push(datos);
         }
        //alert(data);
         DibujarGrafico(data);

      },
      error: function (Result) {
         alert("Error");
      }
   });
}

function DibujarGrafico(series){

   // Build the chart
   $('#graficoServicios').highcharts({
       chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
       },
       title: {
           text: 'Porcentaje servicios prestados'
       },
       tooltip: {
           pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
       },
       plotOptions: {
           pie: {
               allowPointSelect: true,
               cursor: 'pointer',
               dataLabels: {
                   enabled: false
               },
               showInLegend: true
           }
       },
       series: [{
           name: 'TERARED',
           colorByPoint: true,
           data: series
       }]



	

});

}

});


