Angular.js-project
==========

**A PHP library that provides an incredibly easy way to access Twitter data as JSON, pretty printed JSON, or RSS feeds by URL or standard command line syntax.  The Tweetledee files include caching to avoid exceeding the Twitter API v1.1 rate limits (see [caveats in the documentation](http://chrissimpkins.github.io/tweetledee/caching.html)!).**

## Documentation
- Developer Docs: [https://github.com/setni/Angular.js-project/wiki](https://github.com/setni/Angular.js-project/wiki)

## Current Release
- <b>0.1.2</b> : Fix XSS and CSRF issue.

## Changes
- <b>0.1.2</b> : Added CSRF and XSS securisation in <code>ControllerFactory.php</code> for CSRF AND <code>Mysql.php</code> for XSS.
- <b>0.1.1</b> : Added JSON only support in <code>app.php</code>.

## Requirement for using
**You will need the following**:
 - PHP version 5.5 or higher
 - Apache2 or run native php server
 - Mysql5 And a DataBase
 - A <a href="https://github.com/setni/Angular.js-project/wiki">WIKI</a> document The Standard service you could use in this API


### 3-Step Installation instructions:

1. Clone this repo in your workspace

2. Create an User dir in the root and add a .htaccess file

3. Open bin/config.php and modified the constants with you setting.

Make sure that apache/mysql or php server (php -S localhost:[PORT]) is running. And enjoy

## What You Get
### Twitter RSS Feeds
##### Favorites RSS Feed [<code>favoritesrss.php</code>] + [<code>favoritesrss_nocache.php</code>]
##### Home Timeline RSS Feed [<code>homerss.php</code>] + [<code>homerss_nocache.php</code>]
##### User Lists RSS Feed [<code>listsrss.php</code>] + [<code>listrss_nocache.php</code>]
##### User Timeline RSS Feed [<code>userrss.php</code>] + [<code>userrss_nocache.php</code>]
##### Search RSS Feed [<code>searchrss.php</code>] + [<code>searchrss_nocache.php</code>]

### Twitter JSON
##### Favorites JSON [<code>favoritesjson.php</code>] + [<code>favoritesjson_nocache.php</code>]
##### Home Timeline JSON [<code>homejson.php</code>] + [<code>homejson_nocache.php</code>]
##### User Lists JSON [<code>listsjson.php</code>] + [<code>listsjson_nocache.php</code>]
##### User Timeline JSON [<code>userjson.php</code>] + [<code>userjson_nocache.php</code>]
##### Search JSON [<code>searchjson.php</code>] + + [<code>searchjson_nocache.php</code>]

### Pretty Printed JSON
##### Favorites Pretty Printed JSON [<code>favoritesjson_pp.php</code>] + [<code>favoritesjson_pp_nocache.php</code>]
##### Home Timeline Pretty Printed JSON [<code>homejson_pp.php</code>] + [<code>homejson_pp_nocache.php</code>]
##### User Lists Pretty Printed JSON [<code>listsjson_pp.php</code>] + [<code>listsjson_pp_nocache.php</code>]
##### User Timeline Pretty Printed JSON [<code>userjson_pp.php</code>] + [<code>userjson_pp_nocache.php</code>]
##### Search Pretty Printed JSON [<code>searchjson_pp.php</code>] + [<code>searchjson_pp_nocache.php</code>]

## Usage
<a href="https://github.com/setni/Angular.js-project/wiki">Wiki link for documentation</a>

## Complaiance
- <b>PSR-0</b> (Autoloading Standard) : Full.


## Bugs
If you find a bug, please post it as a new issue on the GitHub repository with <a https://github.com/setni/Angular.js-project/issues">this information in your report</a>.

## Contribute
If you would like to contribute to the project, have at it.  <a href="https://help.github.com/articles/fork-a-repo">Fork the Tweetledee project</a>, include your changes, and <a href="https://help.github.com/articles/using-pull-requests">submit a pull request</a> back to the main repository.

## License
MIT License - see the LICENSE.txt file in the source distribution

✪ Thomas
