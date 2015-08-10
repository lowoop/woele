<?php
/* @var $this CourierController */
/* @var $model Courier */
/* @var $form CActiveForm */
?>

<div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Series</h5>
        </div>
        <div class="widget-content nopadding">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'courier-form',
	'htmlOptions'=>array('class'=>'form-horizontal'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'name',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

    <div class="control-group">
        <?php echo $form->labelEx($model,'image',array('class'=>'control-label')); ?>
        <div class="controls">
            <div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
            <div id="container">
                <a id="pickfiles" href="javascript:;">[Select files]</a>
                <a id="uploadfiles" href="javascript:;">[Upload files]</a>
            </div>
            <div id="showimg">
                <?php if($model->image!=""){?>
                    <img src="/img/upload/<?php echo $model->image;?>">
                <?php }?>
            </div>
            <?php echo $form->hiddenField($model,'image'); ?>
            <?php echo $form->error($model,'image'); ?>
        </div>
    </div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'mobile',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'mobile',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'mobile'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'moto',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'moto',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'moto'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
		<div class="controls">
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'email'); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
</div>
<script type="text/javascript" src="/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript">
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'pickfiles', // you can pass in id...
        container: document.getElementById('container'), // ... or DOM Element itself
        url : '<?php echo Yii::app()->createUrl("/upload");?>',
        flash_swf_url : '/js/plupload/Moxie.swf',
        silverlight_xap_url : '/js/plupload/Moxie.xap',

        filters : {
            max_file_size : '2mb',
            mime_types: [
                {title : "Image files", extensions : "jpg,gif,png,jpeg"},
                {title : "Zip files", extensions : "zip"}
            ]
        },

        init: {
            PostInit: function() {
                document.getElementById('filelist').innerHTML = '';

                document.getElementById('uploadfiles').onclick = function() {
                    uploader.start();
                    return false;
                };
            },

            FilesAdded: function(up, files) {
                plupload.each(files, function(file) {
                    document.getElementById('filelist').innerHTML = '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                });
            },

            UploadProgress: function(up, file) {
                document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
            },
            FileUploaded: function(uploader,file,responseObject) {
                //document.createElement();

                var msg = responseObject.response;
                var obj = eval('(' + msg + ')');
// 			console.log(obj);
                if(obj.status=="success")
                {
                    $("#showimg").html("<img src='/img/upload/"+obj.url+"'>");
                    $("#Courier_image").val(obj.url);
                }
            },
            Error: function(up, err) {
                document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
            }
        }
    });
    uploader.init();
</script>