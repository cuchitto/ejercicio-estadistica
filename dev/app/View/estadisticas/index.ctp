


<?php echo $this->Form->create('Estadisticas'); ?>


<div class="row">
	<div class="col-md-6">
		<h2>Numeros</h2>
		<br/>coloca un numero en cada linea.
		<?php echo $this->Form->input('datos', array('rows' => 10, 'label' => '', 'value' => "667\n451\n233\n235\n239\n440\n442\n448\n451\n230\n451\n459\n462\n550\n551\n558\n569\n660\n661\n662\n666")); ?>
	</div>
	<div class="col-md-6">
		<h2>Cantidad de clases</h2>
			<br/>coloca un numero, si quieres que calcule automáticamente la clase, deja en blanco este campo.
		<?php echo $this->Form->input('clases', array('type' => 'number', 'label' => '')); ?>
	</div>
</div>




<br><br>

<?php echo $this->Form->end(array('label' => 'Calcular', 'div' => false, 'class' => 'btn btn-primary')); ?>