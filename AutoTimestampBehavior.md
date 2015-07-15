This behavior will automatically set timestamp fields to the row creation and modification times.

```
<?php
class AutoTimestampBehavior extends CActiveRecordBehavior {

	/**
	* The field that stores the creation time
	*/
	public $created = 'created';
	/**
	* The field that stores the modification time
	*/
	public $modified = 'modified';
	
	
	public function beforeValidate($on) {
		if ($this->Owner->isNewRecord)
			$this->Owner->{$this->created} = new CDbExpression('NOW()');
		else
			$this->Owner->{$this->modified} = new CDbExpression('NOW()');
			
		return true;	
	}
}
```

## Installing to a model ##
Drop the following into your model to install it:

```
public function behaviors(){
	return array(
		'AutoTimestampBehavior' => array(
			'class' => 'application.components.AutoTimestampBehavior',
			//You can optionally set the field name options here
		)
	);
}
```