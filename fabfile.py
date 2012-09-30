#!/usr/bin/python
# -*- coding: utf-8 -*-

import os, string, simplejson as json
import MySQLdb as mysql

from fabric.api import *
from fabric.utils import puts
from fabric import colors
from fabric.contrib.files import sed, uncomment
import fabric.network
import fabric.state

class _CountryRow:
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

def _get_conn():
	db = mysql.connect(env.db_host, env.db_user, env.db_pass, env.db_database, charset = "utf8", use_unicode = True)
	return db

def _get_cursor():
	db = _get_conn()
	return db.cursor()

def _get_rows():
	cur = _get_cursor()
	cur.execute('SELECT code2l,code3l,name,official_name,flag_32,flag_128 FROM countries')
	result = cur.fetchall()
	cur.close()
	return result

@_setup
def dump_mysql():
	"""
	Dump MySQL database into SQL dump file
	"""
	print 'Writing SQL dump to %s' % env.mysql_dump
	local('mysqldump -u %s --password=%s -r %s %s' % (env.db_user, env.db_pass, env.mysql_dump, env.db_database ));


@_setup
def dump_json():
	"""
	Dump MySQL database into JSON format
	"""
	i = 0
	arr = list()
	for row in _get_rows():
		ob = _CountryRow(code2l = row[0], code3l = row[1], name = row[2], 
			official_name = row[3], flag_32 = row[4], flag_128 = row[5])
		arr.append(ob.__dict__)
		i += 1
	with open(env.json_dump, 'w') as out:
		print 'Writing JSON dump to %s' % env.json_dump
		out.write(json.dumps(arr, sort_keys=True, indent=4))
	print 'Wrote %s records' % i

@_setup
def dump_csv():
	"""
	Dump MySQL database into CSV format
	"""
	import csv, codecs
	
	arr = list()
	with open(env.csv_dump, 'w') as out:
		out.write(u'\ufeff'.encode('utf8')) # BOM
		i = 0
		writer = csv.writer(out, delimiter = ',', quotechar = '"', quoting=csv.QUOTE_MINIMAL)
		print 'Writing CSV dump to %s' % env.csv_dump
		for row in _get_rows():
			l = list()
			for cell in row:
				l.append(cell.encode('utf-8'))
			writer.writerow(l)
			i += 1

@_setup
def check_flags():
	"""
	Check that all countries have correct flags
	"""
	db = _get_conn()
	cur = db.cursor()
	cur.execute('SELECT code2l,code3l,name,official_name,flag_32,flag_128,id FROM countries')
	result = cur.fetchall()
	for row in result:
		rid = row[6]
		small = row[4]
		large = row[5]
		if not os.path.exists(small):
			print 'Invalid SMALL flag for %s' % row[3]
		if not os.path.exists(large):
			print 'Invalid LARGE flag for %s' % row[3]
	cur.close()
	db.close()


@_setup
def rename_flags():
	"""
	DO NOT USE (internal use). Used to rename the files according to country. 
	"""
	import shutil
	db = _get_conn()
	cur = db.cursor()
	cur.execute('SELECT code2l,code3l,name,official_name,flag_32,flag_128,id FROM countries')
	result = cur.fetchall()
	cur1 = db.cursor()
	for row in result:
		rid = row[6]
		f_128 = row[5]
		f_32 = row[4]
		new_f_128 = 'flags/%s%s' % (_slugify(row[3]), '-128.png')
		new_f_32 = 'flags/%s%s' % (_slugify(row[3]), '-32.png')
		try:
			shutil.copy(f_32, new_f_32)
			shutil.copy(f_128, new_f_128)
			cur1.execute('UPDATE countries SET flag_32=\'%s\', flag_128=\'%s\' WHERE id=%s' % (new_f_128, new_f_32, rid))
		except:
			print "FAILED %s" % (row[3])
	db.commit()



def _slugify(value):
	import re, unicodedata;
	value = unicodedata.normalize('NFKD', value).encode('ascii', 'ignore').decode('ascii')
	value = re.sub('[^\w\s-]', '', value).strip().lower()
	return re.sub('[-\s]+', '-', value)
