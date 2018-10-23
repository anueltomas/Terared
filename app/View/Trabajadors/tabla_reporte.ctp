
<?php //debug($usuarios);

	if ($usuarios == null) {

		?>

		<center><h1>No existen datos para esta fecha</h1></center>

<?php	

	}else{

 ?>

<center><h1 class="box-title">Reporte por Transcriptor</h1></center>

<table class="table tabla-condensed table-striped">
					<thead>
						<tr>	
								<th>N°</th>
								<th>Transcriptor</th>
								<th>Monto generado</th>
								<th>Tickets generados</th>
								
						</tr>
					</thead>
					<tbody>
					<?php $numero = 0 ?>
						<?php foreach ($usuarios as $usuario): ?>
							<tr>
							<?php $numero = $numero + 1; ?>
								<td ><?php echo $numero; ?>&nbsp;</td>
								<td><?php echo h($usuario['usuarios']['nombreusuario']); ?>&nbsp;</td>
								<td><?php echo h($usuario['0']['totalmonto']); ?>&nbsp;</td>
								<td><?php echo h($usuario['0']['totalticket']); ?>&nbsp;</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

<?php } ?>