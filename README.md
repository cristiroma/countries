About
=====

Data set with world countries (multilingual names, flags, coordinates) in popular formats to integrate in projects.

Features:

* MySQL and SQLite3 database dumps
* JSON format
* CSV format
* Flags in SVG, PNG (128x64 and 32x16), and CSS sprite
* Country 'center' coordinates & zoom hand-picked to optimally fit into a square Google Maps viewport
* List of official UN Regions & assignment of countries to regions
* Country codes from ISO 3166-1 / 3166-2 (ie. RO, ROU for România)

[View Demo](http://cristiroma.github.io/countries)

How to use
==========

Look into the ```data/``` directory for your preffered format. 

MySQL
----

Open a console and load the countries:
```
	$> cat data/mysql/country.sql | mysql -u username -p database
```

License
=======

The national flags do not bear any copyright, while other parts are licensed as GPL v3 or newer.