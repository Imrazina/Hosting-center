# 🐳 Self-Hosted Docker Hosting Stack

This project is a simple, self-hosted web hosting stack using Docker Compose. It includes:
- 🌐 Nginx — web server
- 🐘 PHP (FPM) — PHP processor
- 🐬 MySQL — database
- 📁 Pure-FTPd — FTP server with MySQL authentication

## 📁 Project Structure
├── docker-compose.yml
├── web/                  # Website root directory
├── nginx/                # Nginx configuration
├── php/                  # PHP Dockerfile and config
├── mysql/                # Database initialization
├── ftp/                  # FTP server (Dockerfile, configs, startup script)
└── data/mysql/           # Persistent MySQL storage

## 🚀 Quick Start

> Make sure you have Docker and Docker Compose installed.

1. Clone the repository:

git clone https://github.com/yourusername/docker-hosting-platform.git
cd docker-hosting-platform

2. docker-compose up --build

3.  Local Development - /etc/hosts Setup

To access your local website using a custom domain like my-site.localhost, 
add the following entry to your /etc/hosts file:
127.0.0.1   my-site.local

Note: On Unix-based systems (Linux/macOS), you will need root privileges to edit this file:
sudo nano /etc/hosts
After editing, you can access your site at http://my-site.local in your browser.

4. 🔐 FTP Setup

FTP Port: 21
Passive Ports: 30000-30009
Authentication: via MySQL (pureftpd database)
You can use FileZilla or any other FTP client to connect.

Add your local public IP address to the /etc/hosts file for FTP access (e.g., ftp.local):
<Your_Public_IP>   ftp.local
You can find your public IP by searching "What is my IP" in a search engine. 
After adding this, FTP can be accessed via ftp.local.

5. Register Your Domain
Once the services are running, open your browser and navigate to http://127.0.0.1. You will be prompted to register your domain details, including:
Domain name
Email
FTP username and password (generated automatically)
Database credentials

6. FTP Access via FileZilla
You can use an FTP client like FileZilla to connect to ftp.local using the FTP credentials provided on the page. Just input the following:
Server: ftp.local
Username: The FTP username you registered
Password: The FTP password you registered
Port: 21 (default FTP port)

🧠 What's Inside

Nginx serves the site from ./web
PHP-FPM handles PHP files
MySQL stores site data and FTP users
Pure-FTPd connects to MySQL for FTP user auth
⚙️ Default MySQL Variables

Variable	Value
MYSQL_ROOT_PASSWORD	rootpassword
MYSQL_DATABASE	hosting_db
MYSQL_USER	hosting_user
MYSQL_PASSWORD	hosting_password
🛠 Useful Commands

# View logs
docker-compose logs -f

# Stop all services
docker-compose down
