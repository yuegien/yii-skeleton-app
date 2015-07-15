# Usage #

You can configure the module as follows:
```
'modules'=>array(
	'email' => array(
		'delivery'=>'php', //set to 'debug' for debugging
		//'from'=>'name <name@example.com>' //optional, can also be set per email
	),
	...
),
...
```

You need to put the debug widget somewhere in the view or layout, if you wish to use debug mode (already done in skeleton application)
```
$this->widget('email.components.Debug');
```
Example code:
```
Yii::app()->getModule('email');
$email = new Email;
$email->to = 'admin@example.com';
$email->subject = 'Hello';
$email->message = 'Hello brother';
$email->send();
```

Instead of defining the message with `$email->message`, you could instead define a view (and layout if you wish) to use as the email content.  This is much more flexible and maintains MVC better.

The email module also catches failed emails and stores them in the `failedemail` table.  The FailedEmailController (within the email module) contains functions on viewing and re-sending failed emails.