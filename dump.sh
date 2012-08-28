#!/bin/sh

mysqldump -u root --password=root -r mysql/countries.sql countries
