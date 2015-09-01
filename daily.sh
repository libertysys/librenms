#!/usr/bin/env bash

set -eu

cd "$(dirname "$0")"

up=$(php daily.php -f update >&2; echo $?)
if [ "$up" -eq 1 ]; then
    echo 'Checking GitHub..'
    git submodule --quiet init
    git pull --quiet --recurse-submodules || {
        git pull --quiet
        git submodule --quiet update
    }
    php includes/sql-schema/update.php
fi

php daily.php -f syslog
php daily.php -f eventlog
php daily.php -f authlog
php daily.php -f perf_times
php daily.php -f callback
php daily.php -f device_perf
