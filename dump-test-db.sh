#!/bin/sh
docker exec -i skynixcrm--db mysqldump -uroot -p'mysql_root_password' --extended-insert=FALSE --complete-insert=TRUE --no-create-db  database_name | sed "s|*'|\\\*'|g" > "modules/api/tests/_data/dump.sql"
