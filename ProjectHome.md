Requires Yii 1.1.x (but only tested on 1.1.6).

If anyone else with experience would like access to work on this skeleton application, just let me know.  It still uses the Yii 1.0 template and menu component.  Things like this need to be upgraded.  This project is still a good reference for its new & user system, among other things.

[Demo](http://yii.cubedwater.com/)

Features:
  * User management
    1. Login/logout
    1. Registration
    1. Email verification
    1. Administrative functions
    1. User list (using ajax pagination)
    1. User recovery
    1. yiic shell commands specialized for skeleton app
  * User groups
    1. Group authorization
  * Posts
    1. Can be modified to be a new system or leave it as a multi-user blog
  * Extensions/Modules/etc
    1. [Email module](email_module.md)
    1. [Time Helper](time_helper.md)
    1. [Logable Behavior](logable_behavior.md)
    1. [ParseCacheBehavior](parsecache.md)
    1. [AutoTimestampBehavior](AutoTimestampBehavior.md)
    1. [TextEdit module](TextEdit.md)
  * Extended access control (or rather simplified)
  * Contact page
  * Logging and clean urls configured

Checklist for installing:

  * Edit paths in index.php as necessary
  * Set up database in the main.php config file
  * Run sql in the protected/config/tables.sql
  * Optionally load mysql test data in protected/config/
  * Login as admin with usrname=admin, password=admin

Yii Forum Thread: http://www.yiiframework.com/forum/index.php?/topic/778-yii-skeleton-app