ROOT_DIR       := $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))
SHELL          := $(shell which bash)
PROJECT_NAME    = brand-listing
ARGS            = $(filter-out $@,$(MAKECMDGOALS))
USER_ID 		:= 		  $(shell id -u)
GROUP_ID 		:=  $(shell id -g)

.SILENT: ;               # no need for @
.ONESHELL: ;             # recipes execute in same shell
.NOTPARALLEL: ;          # wait for this target to finish
.EXPORT_ALL_VARIABLES: ; # send all vars to shell
default: help-default;   # default target
Makefile: ;              # skip prerequisite discovery

help-default help: .title
	@echo "                          ====================================================================="
	@echo "                          Help & Check Menu"
	@echo "                          ====================================================================="
	@echo "                   up: Create and start application in detached mode (in the background)"
	@echo "                   pull: Pull latest dependencies"
	@echo "                   stop: Stop application"
	@echo "                   dev: Setup developer build"
	@echo "                   root:  Login to the 'app' container as 'root' user"
	@echo "                   start: Start application"
	@echo "                   test: Run all application tests"
	@echo "                   build: Build or rebuild services"
	@echo "                   reset: Reset all containers, delete all data, rebuild services and restart"
	@echo "                   php-cli: Run PHP interactively (CLI)"
	@echo ""

build:
	docker-compose --project-name $(PROJECT_NAME) build --build-arg USER_ID=$(USER_ID) --build-arg GROUP_ID=$(GROUP_ID)

start-app: composer seed

deploy-acceptance:
	echo "Deploying to acceptance"

deploy-staging:
	echo "Deploying to staging"	

deploy-production:
	echo "Deploying to production"
	
pull:
	docker pull mysql:5.7

up:
	docker-compose --project-name $(PROJECT_NAME) up -d	

dev: build up

build-dev:
	docker-compose --project-name $(PROJECT_NAME) -f docker-compose-test.yml down
	docker-compose --project-name $(PROJECT_NAME) -f docker-compose-test.yml build --no-cache
	docker-compose --project-name $(PROJECT_NAME) -f docker-compose-test.yml up -d

stop:
	docker-compose --project-name $(PROJECT_NAME) stop

status:
	docker-compose --project-name $(PROJECT_NAME) ps

reset: stop clean build up

root:
	docker exec -it -u root $$(docker-compose --project-name $(PROJECT_NAME) ps -q app) /bin/bash

root-nginx:
	docker exec -it -u root $$(docker-compose --project-name $(PROJECT_NAME) ps -q nginx) sh

test-dev: build-dev
	docker exec -it -u root $$(docker-compose --project-name $(PROJECT_NAME) -f docker-compose-test.yml ps -q app) /bin/bash -c 'php artisan test'

test1: build
	docker exec -u root $$(docker-compose --project-name $(PROJECT_NAME) ps -q app) sh -c 'php artisan test'

composer: down dev
	docker exec -u root $$(docker-compose --project-name $(PROJECT_NAME) ps -q app) composer install

seed:
	docker exec -u root $$(docker-compose --project-name $(PROJECT_NAME) ps -q app) sh -c 'php artisan migrate --seed --force'

test: 
	php artisan config:clear
	php artisan migrate --env=testing --force
	php artisan test --env=testing

clean: stop
	docker-compose --project-name $(PROJECT_NAME) down --remove-orphans

down:
	docker-compose --project-name $(PROJECT_NAME) down --remove-orphans

logs:
	docker logs -f $$(docker-compose --project-name $(PROJECT_NAME) ps -q app)

ping-app: 
	docker-compose exec nginx ping app

ping-nginx: 
	docker-compose exec app ping nginx
restart-nginx: 
	docker-compose restart nginx
cleanall: 
	docker system prune
restart: down dev
%:
	@: