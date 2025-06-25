#!/bin/bash
# src/setup_cron.sh

CRON_CMD="/usr/local/bin/php /path/to/your/project/src/cron.php"
CRON_JOB="0 0 * * * $CRON_CMD"

# Check if the cron job already exists
if ! crontab -l | grep -q "$CRON_CMD"; then
    (crontab -l 2>/dev/null; echo "$CRON_JOB") | crontab -
    echo "Cron job set up successfully."
else
    echo "Cron job already exists."
fi