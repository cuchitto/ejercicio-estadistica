<div class="row">
	<div class="col-md-6">

		<h2>Para datos no agrupados</h2>

		<h3>Cosas varias</h3>
		<table class="table table-condensed table-hover table-bordered table-striped">
			<tr>
				<td>promedio</td>
				<td><?php echo $resultado['sin_agrupar']['promedio']?></td>
			</tr>
			<tr>
				<td>mediana</td>
				<td><?php echo $resultado['sin_agrupar']['mediana']?></td>
			</tr>
			<tr>
				<td>moda</td>
				<td><?php echo $resultado['sin_agrupar']['moda']?></td>
			</tr>
			<tr>
				<td>rango</td>
				<td><?php echo $resultado['sin_agrupar']['rango']?></td>
			</tr>
			<tr>
				<td>varianza_poblacional</td>
				<td><?php echo $resultado['sin_agrupar']['varianza_poblacional']?></td>
			</tr>
			<tr>
				<td>varianza_muestral</td>
				<td><?php echo $resultado['sin_agrupar']['varianza_muestral']?></td>
			</tr>
			<tr>
				<td>desviacion_poblacional</td>
				<td><?php echo $resultado['sin_agrupar']['desviacion_poblacional']?></td>
			</tr>
			<tr>
				<td>desviacion_muestral</td>
				<td><?php echo $resultado['sin_agrupar']['desviacion_muestral']?></td>
			</tr>
			<tr>
				<td>cv_poblacional</td>
				<td><?php echo $resultado['sin_agrupar']['cv_poblacional']?></td>
			</tr>
			<tr>
				<td>cv_muestral</td>
				<td><?php echo $resultado['sin_agrupar']['cv_muestral']?></td>
			</tr>
		</table>

		<h3>Cuartiles</h3>
		<table class="table table-condensed table-hover table-bordered table-striped">
			<?php foreach($resultado['sin_agrupar']['cuartiles'] as $cuartil) : ?>
				<tr>
					<td><?php echo $cuartil['cuartil']?></td>
					<td><?php echo $cuartil['valor']?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<h3>Deciles</h3>
		<table class="table table-condensed table-hover table-bordered table-striped">
			<?php foreach($resultado['sin_agrupar']['deciles'] as $decil) : ?>
				<tr>
					<td><?php echo $decil['decil']?></td>
					<td><?php echo $decil['valor']?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<h3>Percentiles</h3>
		<table class="table table-condensed table-hover table-bordered table-striped">
			<?php foreach($resultado['sin_agrupar']['percentiles'] as $percentil) : ?>
				<tr>
					<td><?php echo $percentil['percentil']?></td>
					<td><?php echo $percentil['valor']?></td>
				</tr>
			<?php endforeach; ?>
		</table>

	</div>

	<div class="col-md-6">
		<h2>Para datos agrupados</h2>

		<h3>Cosas varias</h3>
		<table class="table table-condensed table-hover table-bordered table-striped">
			<tr>
				<td>cantidad clases</td>
				<td><?php echo $resultado['agrupados']['clase']?></td>
			</tr>
			<tr>
				<td>amplitud</td>
				<td><?php echo $resultado['agrupados']['amplitud']?></td>
			</tr>
			<tr>
				<td>promedio</td>
				<td><?php echo $resultado['agrupados']['promedio']?></td>
			</tr>
			<tr>
				<td>mediana</td>
				<td><?php echo $resultado['agrupados']['mediana']?></td>
			</tr>
			<tr>
				<td>moda</td>
				<td><?php echo $resultado['agrupados']['moda']?></td>
			</tr>
			<tr>
				<td>rango</td>
				<td><?php echo $resultado['agrupados']['rango']?></td>
			</tr>
			<tr>
				<td>varianza_poblacional</td>
				<td><?php echo $resultado['agrupados']['varianza_poblacional']?></td>
			</tr>
			<tr>
				<td>varianza_muestral</td>
				<td><?php echo $resultado['agrupados']['varianza_muestral']?></td>
			</tr>
			<tr>
				<td>desviacion_poblacional</td>
				<td><?php echo $resultado['agrupados']['desviacion_poblacional']?></td>
			</tr>
			<tr>
				<td>desviacion_muestral</td>
				<td><?php echo $resultado['agrupados']['desviacion_muestral']?></td>
			</tr>
			<tr>
				<td>cv_poblacional</td>
				<td><?php echo $resultado['agrupados']['cv_poblacional']?></td>
			</tr>
			<tr>
				<td>cv_muestral</td>
				<td><?php echo $resultado['agrupados']['cv_muestral']?></td>
			</tr>
		</table>


		<h3>Tabla que no se como llamarla</h3>
		<table class="table table-condensed table-hover table-bordered table-striped">
			<tr>
				<th>Clase</th>
				<th>L inf</th>
				<th>L sup</th>
				<th>yi</th>
				<th>fi</th>
				<th>hi</th>
				<th>Fi</th>
				<th>Hi</th>
				<th>yi * fi</th>
				<th>fi(yi-xprom)^2</th>
			</tr>
			<?php foreach ($resultado['agrupados']['tabla'] as $clase) : ?>
				<tr>
					<td>#<?php echo $clase['nro_clase']?></td>
					<td><?php echo $clase['limite_inferior']?></td>
					<td><?php echo $clase['limite_superior']?></td>
					<td><?php echo $clase['yi']?></td>
					<td><?php echo $clase['fi']?></td>
					<td><?php echo $clase['hi']?></td>
					<td><?php echo $clase['ffi']?></td>
					<td><?php echo $clase['hhi']?></td>
					<td><?php echo $clase['yifi']?></td>
					<td><?php echo $clase['ultima']?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<h3>Cuartiles</h3>
		<table class="table table-condensed table-hover table-bordered table-striped">
			<?php foreach($resultado['agrupados']['cuartiles'] as $cuartil) : ?>
				<tr>
					<td><?php echo $cuartil['cuartil']?></td>
					<td><?php echo $cuartil['valor']?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<h3>Deciles</h3>
		<table class="table table-condensed table-hover table-bordered table-striped">
			<?php foreach($resultado['agrupados']['deciles'] as $decil) : ?>
				<tr>
					<td><?php echo $decil['decil']?></td>
					<td><?php echo $decil['valor']?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<h3>Percentiles</h3>
		<table class="table table-condensed table-hover table-bordered table-striped">
			<?php foreach($resultado['agrupados']['percentiles'] as $percentil) : ?>
				<tr>
					<td><?php echo $percentil['percentil']?></td>
					<td><?php echo $percentil['valor']?></td>
				</tr>
			<?php endforeach; ?>
		</table>

	</div>
</div>