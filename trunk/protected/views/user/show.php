<?php
$script = <<<EOD

function deleteUser(){
	return confirm('Are you sure you want to delete this user?');
}

$(".deleteUser").click(deleteUser);
EOD;

Yii::app()->clientScript->registerScript('userShow', $script, CClientScript::POS_READY);
?>
<div class="actionBar">
[<?php echo CHtml::link('User List',array('list')); ?>]
<?php if (Yii::app()->user->hasAuth(Group::ADMIN)){ ?>
[<?php echo CHtml::link('Update User',array('update','id'=>$user->id)); ?>]
[<?php echo CHtml::link('Delete User',array('delete','id'=>$user->id), array('class' => 'deleteUser')); ?>]
<?php } ?>
</div>

<?php
$username = CHtml::encode($user->username); //cache the encoding
?>
<h2><?php echo $username ?>'s Profile</h2>
<p>
	Joined on <b><?php echo date('F d, o', strtotime($user->created)); ?></b>
	<?php if ($user->email_visible) {?>
		<br />Email: <b><?php echo $user->email ?></b>
	<?php } ?>
</p>
<?php if (!empty($user->about)) { ?>
	<h3>About <?php echo $username; ?></h3>
	<p><?php
	//We instead cache the generated code into the user column
	$this->beginWidget('system.web.widgets.CMarkdown', array('purifyOutput'=>true));
	echo $user->about;
	$this->endWidget();
	?></p>
<?php } ?>