FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
    apt-get install -y pure-ftpd-mysql mysql-client netcat openssl && \
    groupadd -g 1000 ftpgroup && \
    useradd -u 1000 -g ftpgroup -d /var/www/html ftpuser && \
    mkdir -p /var/run/pure-ftpd /var/log/pure-ftpd /var/www/html && \
    chown -R ftpuser:ftpgroup /var/www/html /var/log/pure-ftpd && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Debug step to ensure group and user are created
RUN id ftpuser && grep ftpgroup /etc/group

COPY conf/* /etc/pure-ftpd/conf/
COPY pureftpd-mysql.conf /etc/pure-ftpd/
COPY start-ftp.sh /usr/local/bin/start-ftp.sh

RUN chmod +x /usr/local/bin/start-ftp.sh && \
    chmod 755 /var/www/html

EXPOSE 21 30000-30009

CMD ["/usr/local/bin/start-ftp.sh"]
