single-post-template
====================

Single Post Template adds the ability for your theme to include "Post Templates" in much the same way you can add "Page Templates", allowing you to choose (via a simple dropdown) which post template you want to use, on a per-post basis.

# Description

The Single Post Template plugin adds the ability for your theme to include "Post Templates" in much the same way you can add "Page Templates", allowing you to choose (via a simple dropdown) which post template you want to use, on a per-post basis.

All you need to do, after installing and activating the plugin, is create one or more "Post Templates" in your theme's folder, and when creating or editing a post, choose the post template that you would like to use. If no post template is selected, the default template will be used.

# Installation

**Installation**

1. Upload the entire `single-post-template` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create Post Templates in your theme's folder, as described in Usage

**Usage**

After you have installed the plugin, you'll need to create some Post Templates to use. In order to create a Post Template, either duplicate your default single post template, or create a new template file. Insert the following code at the very top of the file:

```
<?php
/*
Single Post Template: [Descriptive Template Name]
Description: This part is optional, but helpful for describing the Post Template
*/
?>
```

*Screenshot #1 shows what this might look like in your code editor*

![Single Post Template Header](screenshot-1.png "Single Post Template Header")

Once you have created a new Post Template, either edit or create a new post, and directly underneath the post content box, you should see a new box labeled "Single Post Template". Choose the Post Template you want to use and publish or update the post.

*Screenshot #2 shows what this might look like in your post edit screen*

![Single Post Editor](screenshot-2.png "Single Post Editor")

## Frequently Asked Questions

**How do I create new Post Templates?**

Please see the Installation -> Usage section for details on how to create new Post Templates.

**How do I use the Post Templates I created?**

Please see the Installation -> Usage section for details on how to use Post Templates.

**Can I include this plugin in my theme for distribution?**

Yes. Source credits for the plugin should remain intact, per GPL requirements.

**How do I include this plugin in my theme for distribution?**

If you don't know how to do this, you will need to contact me for instructions. I do charge a consulting fee for this service.

**I have a question that wasn't covered in the FAQ. Can I contact you?**

Please [email me](http://www.nathanrice.net/contact/ "email Nathan Rice") or [@nathanrice](http://twitter.com/nathanrice) me on Twitter.

Because I try to offer personal email support, I do ask that you compensate me for the time I spend helping you. This can run anywhere from $10 for simple support, up to $125 for more complex issues or use cases.

Bug reports are, of course, appreciated and cost you nothing. I will try to make sure bugs are fixed ASAP.

## Changelog

### 1.0
* Initial Release

### 1.1
* Changed some function and variable names for consistency
* Ensured WordPress 2.8+ compatibility
* Fixed a bug that presents when you include the plugin in your WordPress theme's folder

### 1.2
* Minor update

### 1.3
* Copied methodology of WordPress [get_page_templates()](http://xref.yoast.com/trunk/_functions/get_page_templates.html) function
* Added 2.9 compatibility
* Ensured 2.8 backward compatibility

### 1.4
* Updated coding standards
* Better conflict detection
* Better namespacing via a wrapping class
* WordPress compatibility
