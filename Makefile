# Configuration
CONSOLE = php bin/console
ENV = test

.PHONY: tests

tests: 
	$(CONSOLE) d:d:d --force --if-exists --env=test
	$(CONSOLE) d:d:c --env=test
	$(CONSOLE) d:m:m --no-interaction --env=test
	$(CONSOLE) d:f:l --no-interaction --env=test
	php bin/phpunit --testdox tests/Unit/
	php bin/phpunit --testdox tests/Functional/

.PHONY: prod

prod:
	$(CONSOLE) cache:clear
	$(CONSOLE) d:f:l --no-interaction
	symfony server:start

# commande dans le terminal : maje prod

install:
	composer install


.PHONY: start dev

start: 
	php bin/console cache:clear
	symfony serve:start 
	
