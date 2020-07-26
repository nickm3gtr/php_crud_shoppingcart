
Laravel setup
1. php artisan migrate:fresh
2. php artisan passport:install
3. copy "Shopping Cart Password Grant Client" secret from "oauth_clients" db table to /client/.env VUE_APP_CLIENTSECRET

Vue js frontend setup
1. cd client\
2. npm install
3. configure rest api URL in .env VUE_APP_DEVSERVERPROXY

4.npm run serve