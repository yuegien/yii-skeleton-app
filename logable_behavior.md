A simple and effective way to keep track what your users are doing within your application is to log their activities related to database modifications. You can log whenever a record was inserted, changed or deleted, and also when and by which user this was done. For a CActiveRecord Model you could LogableBehavior for this purpose.

The behavior class uses the ActiveRecordLog Model to store the log lines into the database. It will log a line each time a record is inserted or deleted. It will also log a line for each field which is changed.

In order to make an ActiveRecord Model use this behavior, you have to add the following code to the Model class:
```

public function behaviors()
{
return array(
// Classname => path to Class
'LogableBehavior'=>
'application.components.behaviors.LogableBehavior',
);
}
```