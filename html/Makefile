# Makefile
#

DIR= /var/www/html/accntg

FILES= Common.php \
	employee.php \
	index.html \
	styles.css \
	welcome.jpg

PRIVATE_FILES= DBC.php

INST= /usr/bin/install

all: $(FILES)

install: uid_chk all
	@for file in ${FILES}; do \
		${INST} -p $$file ${DIR} -o root -g www-data -m 664; \
	done
	@for file in ${PRIVATE_FILES}; do \
		${INST} -p $$file ${DIR}/ -o root -g www-data -m 660; \
	done

uid_chk:
	@if [ `id -u` != 0 ]; then echo You must become root first; exit 1; fi

