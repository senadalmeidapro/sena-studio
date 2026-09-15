#!/bin/sh

set -e

exec php artisan schedule:work --no-interaction
