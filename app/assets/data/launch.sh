#!/bin/bash
export NUMBA_CACHE_DIR=/tmp
export TRANSFORMERS_CACHE=/tmp
export MPLCONFIGDIR=/tmp
/usr/bin/python3.9 /var/www/html/topicmodeler/src/topicmodeling/topicmodeling.py --open_ai_key $1 --do_logger True --preproc --config $2 2>&1
/usr/bin/python3.9 /var/www/html/topicmodeler/src/topicmodeling/topicmodeling.py --open_ai_key $1 --do_logger True --train --config $2 2>&1

