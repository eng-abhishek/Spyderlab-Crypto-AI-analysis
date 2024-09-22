#!/usr/local/bin/python3
from telethon import TelegramClient, errors, events, sync
import os
from getpass import getpass
import sys
import json
from dotenv import load_dotenv
from mysql_connection import get_credentials

load_dotenv()

def auth():
    
    assign_credentials()

    session_path = os.environ.get('SESSION_PATH')

    session_name = os.path.join(session_path, PHONE_NUMBER)

    client = TelegramClient(session_name, API_ID, API_HASH)
    client.connect()

    if not client.is_user_authorized():
        client.send_code_request(PHONE_NUMBER)
        try:
            client.sign_in(PHONE_NUMBER, input('Enter the code (sent on telegram): '))
            print('Authenticated Successfully')
        except errors.SessionPasswordNeededError:
            pw = getpass('Two-Step Verification enabled. Please enter your account password: ')
            client.sign_in(password=pw)
            print('Authenticated Successfully')
    else:
        print('Already Authenticated')


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


if __name__ == "__main__":
    auth()