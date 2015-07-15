# Methods #

```
/**
* Returns a nicely formatted date string for given Datetime string.
*
* @param string $dateString Datetime string
* @param int $format Format of returned date
* @return string Formatted date string
*/
public static function nice($dateString = null, $format = 'F d, o')



/**
* Returns a formatted descriptive date string for given datetime string.
*
* If the given date is today, the returned string could be "Today, 6:54 pm".
* If the given date was yesterday, the returned string could be "Yesterday, 6:54 pm".
* If $dateString's year is the current year, the returned string does not
* include mention of the year.
*
* @param string $dateString Datetime string or Unix timestamp
* @return string Described, relative date string
*/
public static function niceShort($dateString = null)


/**
* Returns either a relative date or a formatted date depending
* on the difference between the current time and given datetime.
* $datetime should be in a <i>strtotime</i>-parsable format, like MySQL's datetime datatype.
*
* Options:
*  'format' => a fall back format if the relative time is longer than the duration specified by end
*  'end' =>  The end of relative time telling
*
* Relative dates look something like this:
*	3 weeks, 4 days ago
*	15 seconds ago
* Formatted dates look like this:
*	on 02/18/2004
*
* The returned string includes 'ago' or 'on' and assumes you'll properly add a word
* like 'Posted ' before the function output.
*
* @param string $dateString Datetime string
* @param array $options Default format if timestamp is used in $dateString
* @return string Relative time string.
*/
function timeAgoInWords($dateTime, $options = array())



/**
* Returns true if given date is today.
*
* @param string $date Unix timestamp
* @return boolean True if date is today
*/
public static function isToday($date)



/**
* Returns true if given date was yesterday
*
* @param string $date Unix timestamp
* @return boolean True if date was yesterday
*/
public static function wasYesterday($date)



/**
* Returns true if given date is in this year
*
* @param string $date Unix timestamp
* @return boolean True if date is in this year
*/
public static function isThisYear($date)



/**
* Returns true if given date is in this week
*
* @param string $date Unix timestamp
* @return boolean True if date is in this week
*/
public static function isThisWeek($date)



/**
* Returns true if given date is in this month
*
* @param string $date Unix timestamp
* @return boolean True if date is in this month
*/
public static function isThisMonth($date)
```