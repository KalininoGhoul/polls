project=polls

build:
	docker build --target development --tag polls-php -f ./docker/php/Dockerfile . && \
	docker build --tag polls-nginx -f ./docker/nginx/Dockerfile .

up:
	docker compose -p $(project) up -d

down:
	docker compose -p $(project) down

cli:
	docker compose -p $(project) exec app bash

logs:
	docker compose -p $(project) logs