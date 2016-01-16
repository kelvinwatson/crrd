#!/bin/sh

mongo `meteor mongo --url corvallis_reuse_repair_directory.meteor.com | sed 's/mongodb:\/\//-u /' | sed 's/:/ -p /' | sed 's/@/ /'`
#show collections\n
#db.businesses.find()
