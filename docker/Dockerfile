FROM ubuntu:16.04
LABEL version="1.1"

MAINTAINER Alexey Manikin <alexey@beget.ru>

# Install.
RUN \
  sed -i 's/# \(.*multiverse$\)/\1/g' /etc/apt/sources.list && \
  apt-get update && \
  apt-get -y upgrade && \
  apt-get install -y build-essential && \
  apt-get install -y software-properties-common && \
  apt-get install -y byobu curl git vim php7.0 sudo && \
  rm -rf /var/lib/apt/lists/*

# Prepare environment
ENV DEBIAN_FRONTEND noninteractive

# This is roughly equivalent to add-apt-repository ppa:chazomaticus/minit.
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys E007F6BD
RUN echo "deb http://ppa.launchpad.net/chazomaticus/minit/ubuntu quantal main" > /etc/apt/sources.list.d/minit.list
RUN apt-get update && apt-get upgrade -y && apt-get install -y minit # etc.

RUN mkdir -p /home/report && \
    chmod 777 /home/report && \
    mkdir -p /home/beget && \
    chmod 777 /home/beget && \
    cd /home/beget && \
    git config --global http.sslVerify false && \
    git clone -b beget -- https://github.com/AlexeyManikin/aibolit.git && \
    chmod 755 /home/beget/aibolit -R && \
    mkdir /home/beget/site

ADD init.sh /etc/minit/startup
RUN chmod 755 /etc/minit/startup
CMD ["/sbin/minit"]
