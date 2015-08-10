<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<div class="widget-box">
   <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
      <h5>Search Form</h5>
   </div>
     <div class="widget-content nopadding">

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'htmlOptions'=>array('class'=>'form-horizontal'),
	'method'=>'get',
)); ?>\n"; ?>
<div class="control-group" style="padding:10px;">
<?php foreach($this->tableSchema->columns as $column): ?>
<?php
	$field=$this->generateInputField($this->modelClass,$column);
	if(strpos($field,'password')!==false)
		continue;
?>
	<span class="condition">
		<?php echo "<?php echo \$form->label(\$model,'{$column->name}'); ?>\n"; ?>
		<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
	</span>

<?php endforeach; ?>
	<span class="condition">
		<?php echo "<?php echo CHtml::submitButton('Search'); ?>\n"; ?>
	</span>
</div>
<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
</div>
</div><!-- search-form -->