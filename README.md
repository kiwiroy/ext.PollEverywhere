ext.PollEverywhere
==================

Of [Poll Everywhere](http://www.polleverywhere.com) and [their codebases](https://github.com/polleverywhere) fame.

No affliation, just an extension for mediawiki integration using the MW resource loader and Poll Everywhere javascript.

Usage
=====

Sign up to Poll Everywhere and create a poll. Navigate to the share and publish on a 
website page and locate the ID for the poll. Copy this ID and use in your mediawiki article thus.

```xml
<pollev>Poll_exampleID</pollev>
```

Additional settings for the display can be added to the tag thus:

```xml
<pollev width="800" height="400" type="chart">Poll_exampleID</pollev>
```

Supported settings are *width*, *height* and *type*, where *width* and *height* accept integers and
*type* accepts either 'mcp', 'ftp' or 'chart'.

Installation
============

As per standard mediawiki extensions

* checkout / copy code to extensions/PollEverywhere folder
* insert the require line to LocalSettings.php

```php
require_once( "$IP/extensions/PollEverywhere/PollEverywhere.php"  );
```
* possibly edit PollEverywhere.javascript.php to set the $wgHTTPProxy and $wgHTTPTimeout variables

Technicals
==========

All achieved by sideloading, with no caching done. Too slow? Fork and improve.

Use the website to create polls, no API integration

No waranty expressed or implied. Don't like it, don't use it, no need to cry about it.
