<?php echo $this->Form->create('Estadisticas'); ?>
<?php echo $this->Form->input('datos', array('rows' => 20)); ?>
<?php echo $this->Form->input('clases', array('type' => 'number')); ?>
<?php echo $this->Form->end('Calcular'); ?>