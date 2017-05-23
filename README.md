# Image Exif Reader
PHP exif wrapper that ensures image is valid and not a URL. Allows for fetching of single fields of exif data. PSR-4 compliant for easy autoloading.

## Prerequisites
### Usage
`PHP 7.0^`
### Development
`phpunit 6.1^`


## Installation
Use composer to install this library.

Either use CLI:
 
`php composer.phar require "freeman/image-exif-reader"`

or add it to your composer file:

`"freeman/image-exif-reader": "*"`


## Usage 
Create a new instance of the ImageExifReader class provided in `src` folder

`$reader = new \Freeman\ImageExifReader\ImageExifReader();`

To get an array of exif, use `getExifData`.

`$reader->getExifData($myImagePath);`

If you only want the data from a specific key of the exif array, use `getExifDataByKey`. For instance, if you wish to retrieve only the filename: 

`$reader->getExifDataByKey($myImage, 'FileName')`

In both scenarios the call will return null if the image format is wrong, or the requested exif data does not exist.

In case the file does not exist an exception is thrown

### Running tests
Image Exif Reader comes with phpunit tests and a phpunit.xml file. To run phpunit tests, simply invoke phpunit in the root folder of this project.

If you have installed phpunit through composer simply run:
 
`<yourPath>/vendor/bin/phpunit <yourPath>/vendor/Freeman/ImageExifReader`.

## Version History
1.0.0: Initial release on GitHub and Packagist
