#!/usr/bin/bash

DOMAIN=$1

# Путь к конфигурации Nginx
NGINX_CONF="/etc/nginx/sites-available/$DOMAIN"

# Создание конфигурации Nginx для домена
echo "server {
    listen 80;
    server_name $DOMAIN;

    root /var/www/html/$DOMAIN;

    index index.html index.php;

    location / {
        try_files \$uri \$uri/ /index.php?\$args;
    }

    location ~ \.php\$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME /var/www/html/$DOMAIN\$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}" > $NGINX_CONF

# Создание символической ссылки для активации конфигурации
ln -s /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/

# Перезапуск Nginx для применения изменений
service nginx reload
