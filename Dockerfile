FROM php:8.0-apache

COPY app/topicmodeler/requirements.txt requirements.txt 
RUN apt-get update
RUN apt install -y python3
RUN apt install -y python3-pip
RUN pip3 install -r requirements.txt
ARG MYUID
ARG GID
#RUN groupdel -f ${GID} 
#RUN groupmod -g ${GID} www-data 
RUN usermod -u ${MYUID}  www-data
RUN pip3 install bertopic
RUN apt-get update
RUN apt install -y openjdk-17-jdk openjdk-17-jre
RUN mkdir -p /var/www/.config/
RUN chown -R www-data /var/www/.config/








