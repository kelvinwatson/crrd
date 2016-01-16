#!/bin/sh

mongo `meteor mongo --url crrd.meteor.com | sed 's/mongodb:\/\//-u /' | sed 's/:/ -p /' | sed 's/@/ /'`
#show collections\n
#db.businesses.find()
