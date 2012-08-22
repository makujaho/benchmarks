all:
	@echo "Please specify one of:"
	@find -maxdepth 1 -mindepth 1 -type d | grep -Ev '.git' | sed 's|./||g'

php:
	php php/*.php

clean:
	rm -f */tmp/* 
