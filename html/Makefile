# Makefile
#

DIR= /var/www/html/accntg

FILES= accounts.php \
	Common.php \
	balance_sheet.php \
	DBC.php \
	debit_credit_ck.php \
	employee.php \
	index.html \
	ledger.php \
	payrate.php \
	php_test.php \
	styles.css \
	time_card.php \
	timeclock.jpg \
	transactions.php

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

