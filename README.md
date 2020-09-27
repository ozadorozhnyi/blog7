## Laravel 7 Blog Sample

Simple blog created by using Laravel 7 framework.
Suppots two share services: addthis & ya-share2.

1.  clone repo
2.  cd repo directory
3.  chmod -R 777 storage/
4.  php artisan storage:link
5.  cp .env.example .env
6.  setup your own settings in the .env file
7.  php artisan migrate:fresh --seed
8.  node -v && npm -v (ensure that Node.js and NPM are installed on your machine)
9.  npm install (install Laravel Mix)
10. npm run dev (running all Mix tasks)
11. enjoy!