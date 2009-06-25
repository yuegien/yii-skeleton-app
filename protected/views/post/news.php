<h2>News Archive</h2>

<?php
if (Yii::app()->user->hasAuth(Group::ADMIN)){
	$items = array();
	$items[] = array('New Post',array('create'));
	$items[] = array('Admin',array('admin'));
	$this->widget('Menu',array('items'=>$items));
}
foreach($posts as $n=>$post) { ?>
<div class="post">
	<h3><?php echo Html::link($post->title,array('show','id'=>$post->id)); ?></h3>
	<p class="summary">
		By <?php echo Html::link(Html::encode($post->user->username), array('user/show', 'id'=>$post->user->id)); ?> 
		on <?php echo Time::nice($post->created); ?>
	</p>
	<?php echo $post->getMarkdown('content'); ?>
</div>
<?php } ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>