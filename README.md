## SETUP

Requirements
> vue-cli
```bash
https://cli.vuejs.org/guide/installation.html
```
> composer
```bash
just search composer in google bruh
```

put the project in xampp/htdocs 
make sure xampp mysql is turned on  
open the project in vs code


### SERVER
open a new terminal 
> use bash or git bash
```bash
cd server
composer update
cp .env.example .env
php artisan key:generate
```
at server folder go to .env file 
replace the line 22 to 27 to this
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recipe-hub
DB_USERNAME=root
DB_PASSWORD=
```
and at line 65 add this
```bash
APP_SECRET_KEY='secret_key'
```
save it and run this
```bash
php artisan migrate
```

### CLIENT
in a new terminal
> use bash or git bash
```bash
cd client
npm install
```
IF the project name is recipe-hub-master
then go to client folder
go to .env file
change the url to 
> http://localhost/recipe-hub-master/server/public/images
#  
and in client/src folder
go to axios.js
change the baseUrl to
> http://localhost/recipe-hub-master/server/public/images
#  
if the project name is recipe-hub, then there is no need to change the urls :3
#  
then run
```bash
npm run serve
```
