
include ../project/.env.example
-include ../project/.env

key := $(shell openssl rand -base64 32)

build:
	cp ../project/.env.example ../project/.env
	cp ../project/.env .env
	sed -i 's|APP_KEY[^ ]*|APP_KEY=base64:$(key)|' ../project/.env
	docker-compose up -d --build
ifeq ("dev", "$(APP_ENV)")
	docker-compose exec app_lottery composer install
else
	docker-compose exec app_lottery composer install --no-dev
endif
	docker-compose exec app_lottery php artisan migrate
	docker-compose exec app_lottery chmod -R o+w ./storage

up:
	cp ../project/.env .env
	docker-compose up -d
ifeq ("dev", "$(APP_ENV)")
	docker-compose exec app_lottery composer install
else
	docker-compose exec app_lottery composer install --no-dev
endif
	docker-compose exec app_lottery php artisan migrate

down:
	docker-compose down

seed:
	docker-compose exec app_lottery php artisan db:seed

