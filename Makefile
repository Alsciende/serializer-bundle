COMPOSER_FLAGS :=
CONSOLE_BIN    ?= bin/console
SYMFONY_ENV    ?= dev
COMPOSER_BIN   ?= composer
FIND_BIN       ?= find
PHP_BIN        ?= php

ifeq ($(SYMFONY_ENV),prod)
	COMPOSER_FLAGS := --optimize-autoloader --classmap-authoritative --no-dev --no-interaction
endif

.DEFAULT_GOAL := help
.PHONY: phpstan test phpunit vendor

help:
	@echo
	@echo 'Main available targets are:'
	@echo '  test    : Install vendors, configure project and run various tests'
	@echo
	@echo 'Secondary targets are:'
	@echo '  help      : This help message'
	@echo '  vendor    : Install vendors and configure project'
	@echo
	@echo 'See Makefile for a complete list.'
	@echo

vendor: composer.lock
	@echo
	-$(COMPOSER_BIN) install $(COMPOSER_FLAGS)

phpstan: export SYMFONY_ENV = test
phpstan: vendor
	@echo
	$(PHP_BIN) vendor/bin/phpstan analyse src --configuration phpstan.neon --level 7

test: export SYMFONY_ENV = test
test: phpstan phpunit

phpunit: export SYMFONY_ENV = test
phpunit: vendor
	@echo
	vendor/bin/phpunit
