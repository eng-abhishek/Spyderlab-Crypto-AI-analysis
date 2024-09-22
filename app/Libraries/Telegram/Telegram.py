#!/usr/local/bin/python3
from telethon import TelegramClient, errors, events, sync
from telethon.tl.types import InputPhoneContact
from telethon import functions, types
from dotenv import load_dotenv
import argparse
import os
from getpass import getpass
import sys
import json
from mysql_connection import get_credentials

load_dotenv()

# API_ID = 26298155
# API_HASH = 'd6f3c45519150e820582148e0453826b'
# PHONE_NUMBER = '+917008119176'

def get_name(phone_number):
    try:
        contact = InputPhoneContact(client_id=0, phone=phone_number, first_name="", last_name="")
        contacts = client(functions.contacts.ImportContactsRequest([contact]))
        username = contacts.to_dict()['users'][0]['username']
        if not username:
            del_usr = client(functions.contacts.DeleteContactsRequest(id=[username]))
            return ""
        else:
            del_usr = client(functions.contacts.DeleteContactsRequest(id=[username]))
            return username
    except IndexError as e:
        return ""
    except TypeError as e:
        return ""
    except:
        return ""

def assign_credentials():
    global API_ID, API_HASH, PHONE_NUMBER

    API_ID = 26298155
    API_HASH = 'd6f3c45519150e820582148e0453826b'
    PHONE_NUMBER = '+917008119176'

    credentials = get_credentials()
    if credentials is not None:
        if credentials[0] is not None:
            credentials = json.loads(credentials[0])

            API_ID = credentials['api_id']
            API_HASH = credentials['api_hash']
            PHONE_NUMBER = credentials['phone_number']

if __name__ == '__main__':
    
    assign_credentials()

    result = {}

    session_path = os.environ.get('SESSION_PATH')
    session_name = os.path.join(session_path, PHONE_NUMBER)

    client = TelegramClient(session_name, API_ID, API_HASH)
    client.connect()
    if not client.is_user_authorized():
        result = {"username" : "", "status_code" : "401"};
    else:
        username = get_name(sys.argv[1])
        result = {"username" : username, "status_code" : "200"};

    print(json.dumps(result))
    