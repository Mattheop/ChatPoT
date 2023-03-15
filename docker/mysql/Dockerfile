FROM mysql:latest
USER root

ENV LANG=C.UTF_8

COPY docker/mysql/custom.cnf /etc/mysql/conf.d/custom.cnf
COPY docker/mysql/sql/schema.sql /docker-entrypoint-initdb.d/1-schema.sql
COPY docker/mysql/sql/mock.sql /docker-entrypoint-initdb.d/2-mock.sql

RUN chmod 755 /var/lib/mysql