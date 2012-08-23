all:
	@echo "Please specify one of:"
	@find -maxdepth 1 -mindepth 1 -type d | grep -Ev '.git' | sed 's|./||g'

php:
	mkdir -p php/tmp
	php php/*.php

.PHONY: clean php

clean:
	rm -f */tmp/* 
