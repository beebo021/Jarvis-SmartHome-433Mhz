#!/bin/bash
cd /var/www/jarvis/www/api/v1/;
screen -DmS jarvis1 php Daemons/daemonCmdsQueue.php&
screen -DmS jarvis2 php Daemons/daemonRulesTimely.php&
screen -DmS jarvis3 python Daemons/daemonReceiveRF433.py&
