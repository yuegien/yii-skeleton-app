<?php
JavaScript::deleteItem();

$this->operations[] = array('Archive',array('list'));
$this->operations[] = array('New Post',array('create'));
if (($post->user_id == Yii::app()->user->id) || Yii::app()->user->hasAuth(Group::ADMIN)) {
	$this->operations[] = array('Edit Post',array('update','id'=>$post->id));
	$this->operations[] = array('Delete Post',array('delete','id'=>$post->id), 'htmlOptions'=>array('class' => 'deleteItem'));
}
if (Yii::app()->user->hasAuth(Group::ADMIN))
	$this->operations[] = array('Admin',array('admin'));

?>

<div class="post">
<h2><?php echo Html::encode($post->title); ?></h2>
<p class="summary">By <?php echo Html::link(Html::encode($post->user->username), array('user/show', 'id'=>$post->user->id)); ?>  on 
<?php echo Time::nice($post->created);
if ($post->modified) {
	echo '<br />Modified on ';
	echo Time::nice($post->modified);
}
?>
</p>

<?php echo $post->getMarkdown('content'); ?>

</div>
<h2>Comments</h2>
<?php $this->renderPartial('/comment/_list',array(
	'comments'=>$post->comments,
	'post'=>$post,
)); ?>
<h3>Leave a Comment</h3>
<?php $this->renderPartial('/comment/_form',array(
	'comment'=>$comment,
)); ?>