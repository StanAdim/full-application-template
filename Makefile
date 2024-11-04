
#-------------------------------------------------
#Starting container - Dev
#-------------------------------------------------

setup.dev:
	@make build.dev
	@make up.dev
	@make composer-update

build.dev:
	docker-compose -f ./backend-app/docker-compose.dev.yml build
stop.dev:
	docker compose -f ./backend-app/docker-compose.dev.yml stop
up.dev:
	docker compose -f ./backend-app/docker-compose.dev.yml up -d

# Container mgt - Dev
composer-update.dev:
	docker exec  tzstartups-dev-api bash -c "composer update"
data.dev:
	docker exec  tzstartups-dev-api bash -c "php artisan migrate:fresh --seed"
bash.dev:
	docker exec -it  tzstartups-dev-api bash
db-bash.dev:
	docker exec -it postgres-db bash 
start.dev:
	docker compose restart
boost.dev:
	docker exec  tzstartups-dev-api bash -c "php artisan optimize"
	docker exec  tzstartups-dev-api bash -c "composer dump-autoload"
	docker exec  tzstartups-dev-api bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache"
	docker exec  tzstartups-dev-api bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
rmi.dev:
	docker image rm -f tzstartups-dev-api-tzstartups-dev-api
logs.dev:
	docker logs -f tzstartups-dev-api


#-------------------------------------------------
#Starting container - Production
#-------------------------------------------------

setup.prod:
	@make build.prod
	@make up.prod
	@make composer-update

build.prod:
	docker-compose -f ./backend-app/docker-compose.prod.yml build
stop.prod:
	docker compose -f ./backend-app/docker-compose.prod.yml stop
up.prod:
	docker compose -f ./backend-app/docker-compose.prod.yml up -d

# Container mgt - Prod

composer-update.prod:
	docker exec  tzstartups-dev-api bash -c "composer update"
data.prod:
	docker exec  tzstartups-dev-api bash -c "php artisan migrate:fresh --seed"
bash.prod:
	docker exec -it  tzstartups-dev-api bash
db-bash.prod:
	docker exec -it postgres-db bash 
start.prod:
	docker compose restart
boost.prod:
	docker exec  tzstartups-dev-api bash -c "php artisan optimize"
	docker exec  tzstartups-dev-api bash -c "composer dump-autoload"
	docker exec  tzstartups-dev-api bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache"
	docker exec  tzstartups-dev-api bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
rmi.prod:
	docker image rm -f tzstartups-dev-api-tzstartups-dev-api
logs.prod:
	docker logs -f tzstartups-dev-api



