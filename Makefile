setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm install

start:
	php artisan serve

lint:
	composer phpcs

lint-fix:
	composer phpcbf

test:
	php artisan test

deploy:
	git push heroku master

log:
	tail -f storage/logs/laravel.log

migrate:
	php artisan migrate

migrate-rollback:
	php artisan migrate:rollback