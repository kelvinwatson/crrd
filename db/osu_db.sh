#!/usr/bin/expect -f

spawn ssh watsokel@access.engr.oregonstate.edu
expect "watsokel@access.engr.oregonstate.edu's password"
send "Klinician2010e\r"
expect "Terminal type?"
send "\r"
expect ""

spawn ssh shell.onid.oregonstate.edu
expect "watsokel@shell.onid.oregonstate.edu's password"
send "Klinician2010e\r"
expect "watsokel@shell:~$"
spawn mysql -u watsokel-db -h oniddb.cws.oregonstate.edu -p
expect "password"
send "CujQY1ONd5WrdiZL"
expect "mysql>"
send "use watsokel-db"
interact
