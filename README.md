

### 1. clone the Package & install the packages

```
git clone https://github.com/TakiDDine/3now.git
```
```
composer install
```

### 1. setup env file
   
   Run this commands from the Terminal:

	cp .env.save .env
	php artisan key:generate


### 2. Next make sure to create a new database and add your database credentials to your .env file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```
### 3. Set permissions and change "project-folder" to your folder

    sudo chmod -R 777 /var/www/project-folder/storage
    sudo chmod -R 777 /var/www/project-folder/public
    sudo chmod -R 777 /var/www/project-folder/bootstrap/cache

### 4. Set up passport settings
    sudo chown www-data:www-data storage/oauth-*.key
    php artisan passport:install
    php artisan config:clear
    php artisan key:generate
    php artisan config:clear

set the files perimissions to 660
    oauth-private.key
    oauth-public.key

### 5. setup the database & add admin & some dummy data

Run this commands from the Terminal:

	 php artisan migrate
	 php artisan make:admin
	 php artisan make:data
     
### 6. you can login as manager from /admin/login
 
	user : admin@3now.com
	pass : 1234