# -*- coding: utf-8 -*-

import os, string, simplejson as json
import MySQLdb as mysql
import csv, codecs, cStringIO

from fabric.api import *
from fabric.utils import puts
from fabric import colors
from fabric.contrib.files import sed, uncomment
import fabric.network
import fabric.state


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


@_setup
def dump_mysql():
	"""
	Dump MySQL database into SQL dump file
	"""
	print 'Writing SQL dump to %s' % env.mysql_dump
	local('mysqldump -u %s --password=%s -r %s %s' % (env.db_user, env.db_pass, env.mysql_dump, env.db_database));


@_setup
def dump_json():
	"""
	Dump MySQL database into JSON format
	"""
	i = 0
	arr = list()
	for row in Country().getList():
		ob = CountryRow(code2l = row[1], code3l = row[2], name = row[3], 
			flag_32 = row[4], flag_128 = row[5], official_name = row[6])
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
		writer = UnicodeWriter(out)
		print 'Writing CSV dump to %s' % env.csv_dump
		i = 0
		for row in Country().getList():
			try :
				l = list()
				for cell in row:
					cell = u'%s' % (cell)
					l.append(cell)
				writer.writerow(l)
				i += 1
			except Exception as e:
				print row
				raise e
		print i

@_setup
def check_flags():
	"""
	Check that all country have correct flags
	"""
	for row in Country().getListObjects():
		if not hasattr(row, 'flag_32') or row.flag_32 is None or not os.path.exists(row.flag_32):
			print 'Invalid 32x16 flag for %s' % row.name
		if not hasattr(row, 'flag_128') or row.flag_128 is None or not os.path.exists(row.flag_128):
			print 'Invalid 128x64 flag for %s' % row.name


def _slugify(value):
	import re, unicodedata;
	value = unicodedata.normalize('NFKD', value).encode('ascii', 'ignore').decode('ascii')
	value = re.sub('[^\w\s-]', '', value).strip().lower()
	return re.sub('[-\s]+', '-', value)



class Database:
	db = None

	def __init__(self):
		if Database.db is None:
			Database.db = mysql.connect(env.db_host,
				env.db_user,
				env.db_pass,
				env.db_database,
				charset = "utf8",
				use_unicode = True
			)


class CountryRow:

	def __init__(self, **kwds):
		self.__dict__.update(kwds)

	def encode(self, o):
		print o

class Country(Database):

	def getList(self):
		cur = Database.db.cursor()
		cur.execute('SELECT a.id, a.code2l, a.code3l, a.name, a.flag_32, a.flag_128, b.official_name FROM country a LEFT JOIN country_names b ON a.id = b.id_country')
		result = cur.fetchall()
		cur.close()
		return result

	def getListObjects(self):
		ret = list()
		cur = Database.db.cursor()
		cur.execute('SELECT a.id, a.code2l, a.code3l, a.name, a.flag_32, a.flag_128, b.official_name FROM country a LEFT JOIN country_names b ON a.id = b.id_country')
		result = cur.fetchall()
		for row in result:
			ob = CountryRow(code2l = row[1], code3l = row[2], name = row[3], 
				flag_32 = row[4], flag_128 = row[5], official_name = row[6])
			ret.append(ob)
		return ret

		

class UnicodeWriter:
	"""
	A CSV writer which will write rows to CSV file "f",
	which is encoded in the given encoding.
	"""

	def __init__(self, f, dialect=csv.excel, encoding="utf-8", **kwds):
		# Redirect output to a queue
		self.queue = cStringIO.StringIO()
		self.writer = csv.writer(self.queue, dialect=dialect, **kwds)
		self.stream = f
		self.encoder = codecs.getincrementalencoder(encoding)()

	def writerow(self, row):
		self.writer.writerow([s.encode("utf-8") for s in row])
		# Fetch UTF-8 output from the queue ...
		data = self.queue.getvalue()
		data = data.decode("utf-8")
		# ... and reencode it into the target encoding
		data = self.encoder.encode(data)
		# write to the target stream
		self.stream.write(data)
		# empty queue
		self.queue.truncate(0)

	def writerows(self, rows):
		for row in rows:
			self.writerow(row)
