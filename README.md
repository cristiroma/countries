# About

[View the list of countries](http://cristiroma.github.io/countries)

Data set with world countries (multilingual names, flags, coordinates) in popular formats to integrate in projects.

Features:

* MySQL and SQLite3 database dumps
* JSON format
* CSV format
* Flags in SVG, PNG (128x64 and 32x16), and CSS sprite
* Country 'center' coordinates & zoom hand-picked to optimally fit into a square Google Maps viewport
* List of official UN Regions & assignment of countries to regions
* Country codes from ISO 3166-1 / 3166-2 (ie. RO, ROU for România)


# How to use

Look into the ```data/``` directory for various formats.
MySQL: `$> cat data/mysql/country.sql | mysql -u username -p database`


# Similar projects

- https://github.com/hjnilsson/country-flags
- https://github.com/mledoze/countries
- https://github.com/umpirsky/country-list


# License

The national flags images cannot be copyrighted, while other parts are licensed as GPL v3 or newer.