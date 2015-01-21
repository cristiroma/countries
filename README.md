Statement
=========

The purpose of this project is to provide a reusable, portable data set with world country information. 
I would like to provide the data set in various formats to make it easy to use from popular programming languages.

Current storage data formats for the country data (under data/ directory):

* SQL dump (MySQL)
* JSON
* CSV

Features:

* Database SQL script with country table
* Hi-quality flags (PNG file) available in two sizes:
	* max 128 px height (128 x 64)
	* max 32 px height (32 x 16)

* [Demo website](http://countries.romanescu.ro)

How to use
==========

Everything you need is under the ```data/``` dir.

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
