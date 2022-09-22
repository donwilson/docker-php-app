#!/bin/sh
set -e

## Execute your custom scripts
#php -f /var/www/html/exec.php

#End with running the original command
exec /usr/sbin/apache2ctl -D FOREGROUND