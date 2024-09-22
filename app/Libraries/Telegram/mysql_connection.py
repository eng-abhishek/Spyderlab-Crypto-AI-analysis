#!/usr/local/bin/python3
import mysql.connector
import os
from dotenv import load_dotenv
import json

load_dotenv()

def get_credentials():
	mydb = mysql.connector.connect(
	  host=os.environ.get('MYSQL_HOST'),
	  user=os.environ.get('MYSQL_USER'),
	  password=os.environ.get('MYSQL_PASSWORD'),
	  database=os.environ.get('MYSQL_DATABASE')
	)

	mycursor = mydb.cursor()

	mycursor.execute("SELECT credentials FROM api_services WHERE slug='telegram'")

	myresult = mycursor.fetchone()

	return myresult