# PicoTooManyPages

PicoTooManyPages is a plugin for Pico CMS that allows it to run a site with thousands of pages
without slowing down by loading an automatic menu.

## Why use this

Pico is a simple flat-file CMS, and that has many advantages, but a disadvantage is that
it tries to loop over every single page you have on every page load, in order to build an
automated menu for pages.

For large sites, this menu is often unnecessary (makes no sense to have a menu with a thousand
links, if you have that many pages). At 2000 pages, on a small server ($5/month), it can take
up to 2 seconds to load a single page because of this loop.

For this reason, if you have a large site you may want to disable this looping completely.
You won't get the "pages" array built, so you won't be able to print a menu like that, but
you won't lose anything else that's nice about Pico.

## Installation

Installation is simple. Simply drop the `PicoTooManyPages.php` file and the `picotmp_dummy`
folder into the `plugins` directory of your Pico installation.

## Configuration

The plugin will not be enabled by default, so simply add the following line to your
`config/config.php` file to enable it:

```
$config[ 'PicoTooManyPages.enabled' ] = true;
```
