## Prerequisites

* PHP 8.0+
* [Composer](https://getcomposer.org/download/)
* [WordPress 6.4+](https://wordpress.org/download/releases/)

## Installation
* Clone this repository into your WordPress plugins directory.
* ```cd path/to/your/wp-content/plugins/literati-example```
Navigate to the plugin directory
* ``` npm install```
* ```  npm run build  ```

## Deliverable details

1.  Created a new Promotion post type that includes 4 fields under promotion details section:
    * Header (Heading title to be displayed on the carousel item card)
    * Text (Description text to be displayed on the carousel item card)
    * Button (Button text to be displayed on the carousel item button)
    * Image (Custom input file uploader that upload and save post image)

2.  Implemented a Carousel Gutenberg block
    * The carousel has slides similiar to the desired functionality displaying Promotion posts as carousel card items
    * The carousel has auto transition between the attached promotions on the default defined 3 seconds timer
    * The block has a field in the edit section to define the transition timer between slides

## Repo structure

```
/design-files   This contains any image
/literati-example  This is the main plugin directory
  - /blocks   This contains block specific code
  - /includes This contains plugin function
  - /tests    This contains any tests
  - composer.json  Composer dependencies for the plugin
  - literati-example.php   The singleton for the plugin
  - package.json   This contains npm dependencies, including wp-scripts for building the blocks
composer.json  These are composer dependencies used outside of the plugin, such as phpunit
Makefile   Commands
phpcs.xml   Test configuration
phpunit.xml   Test Configuration
```

  * Used some Wordpress components such as TextControl, Button in index.js file
  * Used Bootstrap for the design and carousel implementation
  * Used Wordpress element state management

## Steps to replicate desired functionality
  * Create some custom promotion posts in the promotions section 
  * Edit any page and use the "Carousel Block" block in the widgets section of page builder
  * Visit the page on live site to have the carousel functionality for the custom promotion posts

## Available Commands
All make commands are available from the root directory

```make install```
This will install the composer and npm dependencies

```make test```
This will run phpunit

```make build```
This will run any build tasks required for deploy

```make release```
This will build and package a zip file for the plugin that can be uploaded to a WordPress instance