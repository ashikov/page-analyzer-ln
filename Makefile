sail-build:
	./vendor/bin/sail build

sail-build-no-cache:
	./vendor/bin/sail build --no-cache

sail-start:
	./vendor/bin/sail up

sail-start-detached:
	./vendor/bin/sail up -d

sail-test:
	./vendor/bin/sail test

sail-stop:
	./vendor/bin/sail stop

sail-setup:
	composer install
	./vendor/bin/sail build
	./vendor/bin/sail up -d
	cp -n .env.example .env || true
	./vendor/bin/sail artisan key:gen --ansi
	./vendor/bin/sail artisan migrate
	./vendor/bin/sail artisan db:seed
	npm install
	npm run dev
	./vendor/bin/sail stop

setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:gen --ansi
	php artisan migrate
	php artisan db:seed
	npm ci
	npm run dev

start:
	heroku local -f Procfile.dev

lint:
	composer exec -v phpcs

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

serve:
	php artisan serve

watch:
	npm run watch
