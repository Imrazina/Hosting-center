FROM nginx:stable-alpine

# Копируем конфиг виртуальных хостов
COPY sites/default.conf /etc/nginx/conf.d/default.conf

# Рабочая директория
WORKDIR /var/www/html

# Экспонируем порт
EXPOSE 80