About
=====

Comprehensive data set with world countries in popular formats to easily use in different programming languages.

Features:

* Comprehensive list of world countries
* Common formats: SQL (MySQL), JSON, CSV
* Hi-quality flags (PNG file) available in two sizes: 128 x 64, and 32 x 16.
* ISO codes 3166-1 / 3166-2 (ie. RO, ROU for Romania)
* Country 'center' coordinates & zoom hand-picked to optimally fit into a square Google map viewport
* List of official UN Regions & assignment of countries to regions


[View Demo](http://cristiroma.github.io/countries)

TODO list:

* Code examples

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

Database with world country list, their flags and name in various languages
Copyright (C) 2011  Cristian Romanescu

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
