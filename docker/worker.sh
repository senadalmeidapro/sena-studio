#!/bin/sh

set -e

exec php artisan queue:work \
    --sleep="${QUEUE_SLEEP:-3}" \
    --tries="${QUEUE_TRIES:-3}" \
    --timeout="${QUEUE_TIMEOUT:-90}" \
    --max-time="${QUEUE_MAX_TIME:-3600}" \
    --no-interaction
