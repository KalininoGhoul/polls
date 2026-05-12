project=polls

build:
	docker build -t polls-php -f ./docker/php/Dockerfile . && \
	docker build -t polls-php-dev -f ./docker/php/dev.Dockerfile . && \
	docker build -t polls-nginx -f ./docker/nginx/Dockerfile .

up:
	docker compose -p $(project) up -d

down:
	docker compose -p $(project) down

cli:
	docker compose -p $(project) exec app bash

logs:
	docker compose -p $(project) logs