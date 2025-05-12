Конечно! Вот улучшенный вариант в формате простого текста, который можно просто скопировать и вставить в файл **README.md**:

---

# 🐳 Self-Hosted Docker Hosting Stack

This project is a simple, self-hosted web hosting stack using Docker Compose. It includes:

* 🌐 **Nginx** — Web server
* 🐘 **PHP (FPM)** — PHP processor
* 🐬 **MySQL** — Database
* 📁 **Pure-FTPd** — FTP server with MySQL authentication

---

## 📁 Project Structure

```
├── docker-compose.yml       # Docker Compose configuration file
├── web/                     # Website root directory
├── nginx/                   # Nginx configuration
├── php/                     # PHP Dockerfile and config
├── mysql/                   # Database initialization
├── ftp/                     # FTP server (Dockerfile, configs, startup script)
└── data/mysql/              # Persistent MySQL storage
```

---

## 🚀 Quick Start

> **Ensure that Docker and Docker Compose are installed on your machine.**

### 1. Clone the repository:

```
git clone https://github.com/yourusername/docker-hosting-platform.git
cd docker-hosting-platform
```

### 2. Build and start the stack:

```
docker-compose up --build
```

### 3. Local Development - /etc/hosts Setup

To access your local website using a custom domain like `my-site.localhost`, add the following entry to your `/etc/hosts` file:

```
127.0.0.1   my-site.local
```

> **Note**: On Unix-based systems (Linux/macOS), you will need root privileges to edit this file:

```
sudo nano /etc/hosts
```

After editing, you can access your site at [http://my-site.local](http://my-site.local) in your browser.

---

### 4. 🔐 FTP Setup

* **FTP Port**: 21
* **Passive Ports**: 30000-30009
* **Authentication**: via MySQL (Pure-FTPd database)

You can use **FileZilla** or any other FTP client to connect.

To access FTP locally, add your public IP to the `/etc/hosts` file for FTP access (e.g., `ftp.local`):

```
<Your_Public_IP>   ftp.local
```

You can find your public IP by searching "What is my IP" in a search engine. After adding this entry, FTP can be accessed via `ftp.local`.

---

### 5. Register Your Domain

Once the services are up and running, open your browser and navigate to [http://127.0.0.1](http://127.0.0.1). You will be prompted to register your domain details, including:

* Domain name
* Email
* FTP username and password (generated automatically)
* Database credentials

---

### 6. FTP Access via FileZilla

You can use **FileZilla** or any other FTP client to connect to `ftp.local` using the FTP credentials you registered. Simply input the following:

* **Server**: ftp.local
* **Username**: Your FTP username
* **Password**: Your FTP password
* **Port**: 21 (default FTP port)

---

## 🧠 What's Inside

* **Nginx** serves the website from `./web`
* **PHP-FPM** handles PHP files
* **MySQL** stores site data and FTP user information
* **Pure-FTPd** connects to MySQL for FTP user authentication

---

## ⚙️ Default MySQL Variables

| **Variable**          | **Value**         |
| --------------------- | ----------------- |
| `MYSQL_ROOT_PASSWORD` | rootpassword      |
| `MYSQL_DATABASE`      | hosting\_db       |
| `MYSQL_USER`          | hosting\_user     |
| `MYSQL_PASSWORD`      | hosting\_password |

---

## 🛠 Useful Commands

* **View logs**:

```
docker-compose logs -f
```

* **Stop all services**:

```
docker-compose down
```

---

## ⚡ Windows Setup

If you are using **Windows**, ensure that you have Docker Desktop and Docker Compose installed. You can follow these steps to set up Docker Compose on Windows:

1. Install [Docker Desktop](https://www.docker.com/products/docker-desktop) for Windows.
2. Follow the Docker Compose installation guide: [Docker Compose on Windows](https://docs.docker.com/compose/install/).

Once installed, the rest of the steps are the same as for Unix-based systems.

---
