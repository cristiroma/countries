#!/usr/bin/python
# -*- coding: utf-8 -*-

import os, string, simplejson as json

from fabric.api import *
from fabric.utils import puts
from fabric import colors
from fabric.contrib.files import sed, uncomment
import fabric.network
import fabric.state

class CountryRow:
    def __init__(self, **kwds):
        self.__dict__.update(kwds)
        
    def encode(self, o):
		print o
		

def _setup(task):
	config = {}
	with open('config.json') as config_file:
		config = json.load(config_file)
	env.config = config
	
	setattr(env, 'db_host', config['database']['host'])
	setattr(env, 'db_port', config['database']['port'])
	setattr(env, 'db_user', config['database']['user'])
	setattr(env, 'db_pass', config['database']['pass'])
	setattr(env, 'db_database', config['database']['db'])
	setattr(env, 'mysql_dump', config['mysql_dump'])
	setattr(env, 'json_dump', config['json_dump'])
	setattr(env, 'csv_dump', config['csv_dump'])
	
	env['host_string'] = config['host']

	def task_with_setup(*args, **kwargs):
		task(*args, **kwargs)

	return task_with_setup
	
	
def get_rows():
	import MySQLdb as mysql

	db = mysql.connect(env.db_host, env.db_user, env.db_pass, env.db_database, charset = "utf8", use_unicode = True)
	cur = db.cursor()
	cur.execute('SELECT code2l,code3l,name,long_name,flag_32,flag_128 FROM countries')
	result = cur.fetchall()

	cur.close()
	db.close()

	return result	

@_setup
def dump_mysql():
	print 'Writing SQL dump to %s' % env.mysql_dump
	local('mysqldump -u %s --password=%s -r %s %s' % (env.db_user, env.db_pass, env.mysql_dump, env.db_database ));


@_setup
def dump_json():
	i = 0
	arr = list()
	for row in get_rows():
		ob = CountryRow(code2l = row[0], code3l = row[1], name = row[2], 
			long_name = row[3], flag_32 = row[4], flag_128 = row[5])
		arr.append(ob.__dict__)
		i += 1
	with open(env.json_dump, 'w') as out:
		print 'Writing JSON dump to %s' % env.json_dump
		out.write(json.dumps(arr, sort_keys=True, indent=4))
	print 'Wrote %s records' % i

@_setup
def dump_csv():
	import csv, codecs
	
	arr = list()
	with open(env.csv_dump, 'w') as out:
		out.write(u'\ufeff'.encode('utf8')) # BOM
		i = 0
		writer = csv.writer(out, delimiter = ',', quotechar = '"', quoting=csv.QUOTE_MINIMAL)
		print 'Writing CSV dump to %s' % env.csv_dump
		for row in get_rows():
			l = list()
			for cell in row:
				l.append(cell.encode('utf-8'))
			writer.writerow(l)
			i += 1
