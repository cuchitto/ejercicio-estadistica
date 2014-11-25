<?php echo $this->Form->create('Estadisticas'); ?>
<?php echo $this->Form->input('datos', array('rows' => 10, 'label' => 'Numeros: coloca un numero en cada linea.')); ?>
<?php echo $this->Form->input('clases', array('type' => 'number', 'label' => 'Clases: coloca un numero, si quieres que lo calcule solo, deja esto en blanco')); ?>

<?php echo $this->Form->end('Calcular'); ?>