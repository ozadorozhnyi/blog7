## Laravel 7 Blog Sample

Simple blog created by using Laravel 7 framework.

Suppots two share services: addthis & ya-share2.

1.  git clone https://github.com/ozadorozhnyi/blog7.git myblog
2.  cd myblog
3.  composer install
4.  cp .env.example .env
5.  setup your own database settings in the .env file
6.  php artisan key:generate
7.  mkdir -p ./storage/app/images/articles
8.  sudo chmod -R 777 storage/
9.  php artisan storage:link
10. php artisan migrate:fresh --seed
11. node -v && npm -v (to ensure that Node.js and NPM are installed on your machine)
12. npm install (install Laravel Mix)
13. npm run dev (running all Mix tasks)
14. php -S localhost:8000 -t public
14. enjoy!