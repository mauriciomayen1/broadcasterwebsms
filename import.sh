#!/bin/bash

# show commands being executed, per debug
set -x

# define database connectivity
_db='proyectemail'
_db_user='comex'
_db_password='comex123'

# define directory containing CSV files
_csv_directory='/home/broadcaster.cm-operations.com/pub_html/dashboard/broadcasterwebsms'
# go into directory
cd $_csv_directory

# get a list of CSV files in directory
_csv_files=`ls -1 *.csv`

# loop through csv files
for _csv_file in ${_csv_files[@]}
do

  # remove file extension

  # define table name
  _table_name='motherbase'

  # get header columns from CSV file
  _header_columns=`head -1 $_csv_directory/$_csv_file | tr ',' ' ' `
  _header_columns_string=`head -1 $_csv_directory/$_csv_file`



  # import csv into mysql
  mysqlimport  --fields-terminated-by=',' --lines-terminated-by='\n' --columns=$_header_columns_string -h 172.16.27.16 -u $_db_user -p$_db_password $_db  $_csv_directory/$_csv_file

done
exit
