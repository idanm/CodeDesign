#!/bin/bash

TO=/some/where/you/want/to/store/$(date +%Y%m%d%H%M)_backup.tar.gz
BACKUP="what/you/want/to/backup"

  echo "off we go!"
  tar czvf $TO --exclude='.DS_Store' $BACKUP

  if [ $? == 0 ]; then
    echo "Backup was created."
  else
    echo "Backup failed."
  fi