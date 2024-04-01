================================================
## # api dump "https://github.com/beyondcode/laravel-dump-server"
================================================

- `php artisan dump-server`

================================================
## # echo
================================================

- `laravel-echo-server start`

================================================
## # queue
================================================

- `php artisan queue:work`

================================================
## # schedule "osx only, linux use cron"
================================================

- `while true; do php artisan schedule:run; sleep 60; done`

================================================
## # b4 deploying
================================================

- `php artisan self-diagnosis`
- `php artisan code:analyse`
- `php artisan ex:clear`
- `php artisan security-check:now`
- https://laravel.com/docs/5.8/deployment
- remove `public/docs`
- update social services callback url
- db backup package "https://github.com/spatie/laravel-backup"

================================================
## # after deploying
================================================

- `php artisan self-diagnosis`

================================================
## # caching
================================================

- opcache "https://github.com/appstract/laravel-opcache"
- redis "https://redis.io/topics/lru-cache"

================================================
## # security
================================================

- update cors config @ `config/cors`
- enable csp @`.env`

================================================
## # misc
================================================

- to create a package "https://github.com/Jeroen-G/laravel-packager"
- for media upload
    + "https://docs.spatie.be/laravel-medialibrary/v7/requirements"
    + "https://docs.spatie.be/laravel-medialibrary/v7/installation-setup"

================================================
## # For automation
================================================

- in oneToOne relation dont use `associate()` because now we are firing the model update event not the create event which some of the automation is based on "using model observer".

================================================
## # Api
================================================
- doc generation https://github.com/mpociot/laravel-apidoc-generator
- data retrival https://github.com/spatie/laravel-fractal
- data storage "under each entity `store()`"
