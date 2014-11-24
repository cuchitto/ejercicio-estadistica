<?php debug($resultado); ?>


<h2>Para datos no agrupados</h2>

<h3>Cosas varias</h3>
<table>
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
<table>
	<?php foreach($resultado['sin_agrupar']['cuartiles'] as $cuartil) : ?>
		<tr>
			<td><?php echo $cuartil['cuartil']?></td>
			<td><?php echo $cuartil['valor']?></td>
		</tr>
	<?php endforeach; ?>
</table>

<h3>Deciles</h3>
<table>
	<?php foreach($resultado['sin_agrupar']['deciles'] as $decil) : ?>
		<tr>
			<td><?php echo $decil['decil']?></td>
			<td><?php echo $decil['valor']?></td>
		</tr>
	<?php endforeach; ?>
</table>

<h3>Percentiles</h3>
<table>
	<?php foreach($resultado['sin_agrupar']['percentiles'] as $percentil) : ?>
		<tr>
			<td><?php echo $percentil['percentil']?></td>
			<td><?php echo $percentil['valor']?></td>
		</tr>
	<?php endforeach; ?>
</table>