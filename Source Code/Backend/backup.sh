#!/usr/bin/env bash
mysqldump --opt  -u  -p -h localhost | gzip > /var/www/backups/databases/$(date +%d-%m-%Y).sql.gzd
