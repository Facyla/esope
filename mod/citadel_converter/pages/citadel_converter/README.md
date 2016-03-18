Citadel PHP Converter lib
=========================

Citadel PHP converter lib aims to facilitate the use of the Citadel-JSON format by providing the basic PHP structure that allows :
* Using it as an on-the-fly CSV to Citadel-JSON converter for your mobile applications
* Embedding it into other opensource products, such as CMS or Data stores, to provides natively Citadel-JSON files
* Also use geoJSON or osmJSON data source formats
* Enable to export converted data to geoJSON, in addition to Citadel JSON
* Provide configurable data caching - this feature aims to both reduce access time to converted dataset, by retrieving and converting dataset on a regular basis, but not on every access.

This tool is designed to be used by developper or tech-friendly people wishing to enable live data sources to Citadel AGT and mobile templates.


Description
===========

The current library facilitates the conversion of static flat CSV files (and also geoJSON and osmJSON) to Citadel-JSON files that can be used directly into the Citadel mobile application templates.


Usage
=====

* Drop the library folder on a webserver
* Tweak the convert.php file to adjust the conversion settings to the structure of your CSV source file
* Visit the web page and fill the form to get the converted file, or an URL that can be used in your application
* Create various conversion template files by reusing the sample template file in samples/ folder. You should create one conversion template file per CSV structure, but a single template can be used for a whole set of files that share the smae data structure.
* Note that the template files are not necessarly PHP : once you've use the sample template, you get its output in a browser, and host it as a simple text file...



Developper notes
================

This converter includes several files, here is a description of the usedfile structure :

### Converter library
* citadel-converter-lib.php : the main converter library. Contains the functions used to convert a csv file, and map it to the desired JSON file using mapping templates. Can be included into other projects to provide converting capabilities.
* languages/ : contains the translation strings. Copy and translate into other languages. New languages should be called with a &lang=XX parameter, for a XX.php language file. Use of standard language codes is encouraged.
* vendors/ : external libraries that are used by the converter.

### Converter implementation
These files are included to provide a web and webservice interface to the converter library. They can be used as is, or as an example implementation to develop your own converter interface.
If you want to use it as a base for a new project, embedding the whole folder is advised, as this project should include further improvements. Also contributing your changes to the project is highly appreciated !
* index.php  : frontend converter interface. Mainly used to provide an URL that is usable with the convert.php backend.
* convert.php  : backend converter interface - can be used as a webservice by providing the desired information through GET or POST.
* template-generator.php  : frontend template generator that makes it easier to build the mapping parameters that are used by the convert backend.
* samples/ : sample files for the converter.



Roadmap
=======

This code is only a basis for more advanced projects, so we have a full roadmap and we will appareciate a lot your feedback and suggestions ! Please use the Issues feature to provide your inputs.

The general idea of the roadmap is to 
* fully implement the data fields from the Citadel-JSON format
* improve the mapping template editor, and extend the capabilities of config files
* add some converted data caching (so we update the file only when requested, or depending on some info, whether in the dataset or.. we'll see)
* enable to plug the library to more live data sources, and database backends


