#!/bin/bash

FILE=/some/where/you/want/to/store/$(date +%Y%m%d).tar.gz
DROPBOX="/Users/Name/Dropbox/Backup/"
GOOGLE_DRIVE="/Users/Name/Google Drive/Backup/"
BACKUP="what/you/want/to/backup"

  echo "off we go!"
  tar czvf $FILE --exclude='.DS_Store' $BACKUP

  if [ $? == 0 ]; then
    echo "Backup created."
    cp -rv $FILE "$DROPBOX"
    cp -rv $FILE "$GOOGLE_DRIVE"
    echo "Backup distributed."
    rm -rf $FILE
    echo "$FILE removed."
  else
    echo "Backup failed."
  fi