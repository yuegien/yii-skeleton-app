# Introduction #
To put a textual edit-in-place in a view, simply call this in the desired location:
```
$this->widget('application.modules.TextEdit.components.TextEditor', array('id'=>'unique id'));
```
Where the `id` attribute a unique id representing the text block.

If you are a regular user, it simply prints out the text block.  If you are an admin, it will be an edit-in-place text block (with ajax).  Edit-in-place text blocks will have a slight yellow background with a mouse-over effect.  Simply click on the text block to edit it.  You may use Markup syntax.

Freelance clients were in mind when creating this. They tend to like to tweak text blocks on their site a lot...  This way they can do it themselves, and have fun, and love you.

Markup parsing is cached with [ParseCacheBehavior](parsecache.md)

All edits are logged to a file under the `watch` level.  You may find this file at `/protected/runtime/application.log`

Note: This module requires `ParseCacheBehavior` to be installed and be set to auto-load.