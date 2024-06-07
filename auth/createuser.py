#!/usr/bin/python
# -*- coding: utf-8 -*-

import sqlite3 as lite
import sys
import fileinput
import hashlib
list_of_logins_file = "logins.txt"

try:
#NAME OF DATABASE IS TEST.DB
	con = lite.connect('auth.db')
	with con:
    
		cur = con.cursor()    
		cur.execute('SELECT SQLITE_VERSION()')
    
		data = cur.fetchone()
    
		print ("SQLite version: %s" % data)
		print ("[*]Database Created[*]")
		cur.executescript("CREATE TABLE IF NOT EXISTS logins (ID INTEGER PRIMARY KEY   AUTOINCREMENT,email TEXT NOT NULL, password TEXT NOT NULL);");
		con.commit()
		for line in fileinput.input([list_of_logins_file]):
			line = line.replace("\r\n","")
			line = line.replace("\n","")
			line = line.split(":")
			USER = line[0]
			PASS = line[1]

			hashed_password = hashlib.sha256(PASS.encode()).hexdigest()
			print ("[*]Inserting "+USER+" & "+hashed_password+" in to database[*]")
			cur.execute("INSERT OR IGNORE INTO logins (email,password) VALUES ('"+USER+"','"+hashed_password+"');")
			con.commit()
					
except Exception as e:
    # Roll back any change if something goes wrong
	con.rollback()
	raise e
finally:
    # Close the db connection
	con.close() 