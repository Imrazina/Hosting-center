#!/usr/bin/env bash
set -e

echo "⏳ Waiting for MySQL to be available..."
until mysqladmin ping -h"mysql" -u"pureftpd" -p"ftp_password" --silent; do
    sleep 2
done

echo "✅ MySQL is up. Ensuring ftp_users table exists..."
mysql -h mysql -u pureftpd -pftp_password pureftpd <<EOF
CREATE TABLE IF NOT EXISTS ftp_users (
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    uid INT NOT NULL DEFAULT 1000,
    gid INT NOT NULL DEFAULT 1000,
    dir VARCHAR(255) NOT NULL,
    status TINYINT(1) DEFAULT 1,
    PRIMARY KEY (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
EOF

echo "🧼 Preparing directories and permissions..."
mkdir -p /var/log/pure-ftpd /var/www/html
chown -R 1000:1000 /var/log/pure-ftpd /var/www/html

echo "🚀 Starting Pure-FTPd..."
exec /usr/sbin/pure-ftpd-mysql \
    -l mysql:/etc/pure-ftpd/pureftpd-mysql.conf \
    -j -A -E \
    -p 30000:30009 \
    -P ${PUBLIC_IP} \
    -u 1000 \
    -O clf:/var/log/pure-ftpd/transfer.log
