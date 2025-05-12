FROM mysql:8.0

ENV MYSQL_ROOT_PASSWORD=rootpassword
ENV MYSQL_DATABASE=hosting_db
ENV MYSQL_USER=hosting_user
ENV MYSQL_PASSWORD=hosting_password

COPY init.sql /docker-entrypoint-initdb.d/