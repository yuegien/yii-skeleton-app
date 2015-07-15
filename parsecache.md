## Introduction ##

The Yii skeleton application contains `ParseCacheBehavior` which has the ability to handle parsing and caching of attributes (e.g. a blog article being parsed with markdown) without much effort from the programmer.  All you have to do is define the attributes to be parsed & cached, the callback to do the parsing, and the attribute name to store the cached data in.  By default it will use an internal function to parse the data that uses `CMarkdown::safeTransform`.  Safe parsing data with markdown can have a **lot** of overhead and thus this behavior is very useful for caching it.  The default attribute to store the cached data in is the same name as the source attribute but with the configurable suffix "Parsed".  So for instance, if the raw content for a article is stored in `content`, the parsed content would be stored in `contentParsed` by default.

## Installing ##

To install, first set up the behavior in your model:
```
public function behaviors(){
	return array(
		'ParseCacheBehavior' => array(
			'class' => 'application.components.ParseCacheBehavior',
			'attributes' => array('list', 'of', 'attributes'), //the attributes you would like to cache
			//'parserMethod' => 'methodName', //optional.  The method that parses the data
			//more options optional
		)
	);
}
```
Set 'attributes' to the attributes you would like to parse&cache

That is all that is needed for set-up.

## Defining parse method ##

By default it will parse the cached fields with `CMarkdownParser` and `CHtmlPurifier`.  Often this is enough.  If you want it to do something else, create a method in your model with the signature
```
public function <methodName>($attribute) {
	return <parsed $attribute>;
}	
```
and set the 'parserMethod' option in `behaviors()` to the name of the method.  `$attribute` is the name of the attribute that is being parsed, not the actual data.  This is so you can parse it differently depending on the attribute.  To get the data, you can use (as you might expect) `$this->{$attribute}`.  The method must return the parsed data.

## Accessing cached data ##

To access the parsed and cached data (for instance in your view), use `$model->getParsed('attribute')`. Example:
```
echo $post->getParsed('content');
```
The reason you may want to use this method instead of getting the data directly via `$post->contentParsed` is that `getParsed()` will parse and cache the data first if it has not already been (but it should be, unless you already had data in the database before installing this behavior).

## When and where to parse the data ##

When you validate an AR, it automatically does the parsing of the attributes that you have configured to do so. If you would rather not have the attributes parsed until `beforeSave`, set `cacheBeforeValidate` to `false` in the behavior.  You can also parse the attributes anywhere you wish by calling `$model->parseAttributes()` manually in the desired location (it is smart enough not to parsed it twice in a row).