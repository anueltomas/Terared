<br>
<center>
	<h3>Inversiones Terared</h3>

	<h4>Lista de Servicios</h4>
	Fecha: <?php echo date('d/m/Y'); ?>
</center>


<br>
<br>

<div style="text-align:center;">

			<table border="2" style="margin: 0 auto;">
				<thead>
					<tr>
					<th>N°</th>
					<th>Nombre Servicio</th>
					<th>Precio</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($servicios as $servicio): ?>
					<tr>
						<td><?php echo h($servicio['Servicio']['id']); ?>&nbsp;</td>
						<td><?php echo h($servicio['Servicio']['nombreservicio']); ?>&nbsp;</td>
						<td><?php echo number_format($servicio['Servicio']['precio'], 2,",","."); ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

</div>
			

