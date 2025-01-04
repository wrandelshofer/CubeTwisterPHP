#!/bin/bash
cd "$(dirname "$0")"

php -S 127.0.0.1:8081 -t public_html
