True story. As I walked inside sports complex, 37 women rushed to me and pulled their pants off tryna flash me their Coochie. I replied sternly “Haram”. All 37 women were so shook all their clothes came off in a swift attack caused my aura. My friend who watches Jujutsu Kaisen did not accept this tomfoolery and unsheathed his domain "Domain Expansion: Malevolent Kitchen" and cut them into pieces causing a crimson rainfall reminiscent of your mother's period once a month(mura ug sukuna ba). Dare I say, it was a bloody good day.


## setup

Requirements
> vue-cli
> composer

put the project in xampp/htdocs 
open the folder in vs code

open a new terminal 
> use bash or git bash
### server

```bash
cd server
composer update
cp .env.example .env
php artisan key:generate
```
at .env file 
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


in a new terminal
> use bash or git bash
### client
```bash
cd client
npm install
```
IF the project name is recipe-hub-master
then go to client folder
go to .env file
change the url to 
> http://localhost/recipe-hub-master/server/public/images
<br>
and in src folder
go to axios.js
change the baseUrl to
> http://localhost/recipe-hub-master/server/public/images
<br>
then run
```bash
npm run serve
```
