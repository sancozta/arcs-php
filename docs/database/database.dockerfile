FROM mysql:5.7
MAINTAINER sancozta
MYSQL_ROOT_PASSWORD=root
ADD ./database.sql /docker-entrypoint-initdb.d
EXPOSE 3306