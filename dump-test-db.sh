#!/bin/sh
docker exec -i skynixcrm--db mysqldump -uroot -p'BnUY9XeLwWs5oABdN8zmvsY_cx' --extended-insert=FALSE --complete-insert=TRUE --no-create-db  skynixcrm_db | sed "s|*'|\\\*'|g" > "modules/api/tests/_data/dump.sql"
