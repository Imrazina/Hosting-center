<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

// Подключение к базе данных
$host = 'mysql';
$db   = 'hosting_db';
$user = 'hosting_user';
$pass = 'hosting_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получаем данные из формы
    $email = $_POST['email'];
    $domain_name = $_POST['domain'];
    $domain = $domain_name . '.localhost';
    $domain_dir = "/var/www/html/$domain";

    // Генерируем FTP и DB данные
    $ftp_username = 'user_' . bin2hex(random_bytes(4));
    $ftp_password_plain = bin2hex(random_bytes(8)); // Оригинальный пароль
    $ftp_password_md5 = md5($ftp_password_plain);   // MD5-хеш для PureFTPd
    $db_username = 'db_' . bin2hex(random_bytes(4));
    $db_password = bin2hex(random_bytes(8));
    $db_name = 'db_' . bin2hex(random_bytes(4));

    // Создаём базу данных и пользователя
    $db_conn = new PDO("mysql:host=$host", 'root', 'rootpassword');
    $db_conn->exec("CREATE DATABASE `$db_name`");
    $db_conn->exec("CREATE USER '$db_username'@'%' IDENTIFIED BY '$db_password'");
    $db_conn->exec("GRANT ALL PRIVILEGES ON `$db_name`.* TO '$db_username'@'%'");
    $db_conn->exec("FLUSH PRIVILEGES");

    // Добавляем FTP-пользователя (с MD5-хешем)
    $ftp_pdo = new PDO("mysql:host=$host;dbname=pureftpd", 'pureftpd', 'ftp_password');
    $stmt = $ftp_pdo->prepare("INSERT INTO ftp_users (username, password, uid, gid, dir) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$ftp_username, $ftp_password_md5, 1000, 1000, $domain_dir]);

    // Сохраняем данные в основную базу (с MD5-хешем)
    $stmt = $pdo->prepare("INSERT INTO domains (email, domain, ftp_username, ftp_password, db_username, db_password, db_name) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$email, $domain_name, $ftp_username, $ftp_password_md5, $db_username, $db_password, $db_name]);

    // Создаём папку домена
    if (!file_exists($domain_dir)) {
        mkdir($domain_dir, 0755, true);

        // Устанавливаем владельца и права через exec()
        exec("chown -R 1000:1000 $domain_dir"); // FTP пользователь (UID 1000)
        exec("chmod -R 755 $domain_dir");       // rwxr-xr-x для папки
    }


    // HTML-страница с данными (отображаем MD5-хеш как пароль)
    $html_content = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>$domain — Your Hosting</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: radial-gradient(circle at top left, #e0e7ff, #c7d2fe, #f0f4f8);
      color: #1f2937;
      overflow-x: hidden;
    }

    .container {
      max-width: 700px;
      margin: 80px auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
      padding: 50px 40px;
      position: relative;
      overflow: hidden;
    }

    .container::before {
      content: '';
      position: absolute;
      top: -100px;
      right: -100px;
      width: 200px;
      height: 200px;
      background: linear-gradient(45deg, #6366f1, #3b82f6);
      border-radius: 50%;
      opacity: 0.2;
      z-index: 0;
      filter: blur(60px);
    }

    h1 {
      text-align: center;
      font-size: 2.4em;
      color: #3b82f6;
      margin-bottom: 40px;
      position: relative;
      z-index: 1;
    }

    .cred-box {
      background: #f9fafb;
      padding: 28px;
      border-radius: 14px;
      margin-bottom: 30px;
      box-shadow: inset 0 0 0 1px #e5e7eb;
      position: relative;
      z-index: 1;
      transition: all 0.3s ease;
    }

    .cred-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 30px rgba(59, 130, 246, 0.15);
    }

    .cred-box h2 {
      margin-top: 0;
      font-size: 1.3em;
      margin-bottom: 20px;
      color: #1e40af;
      border-left: 4px solid #3b82f6;
      padding-left: 12px;
    }

    .cred-box p {
      margin: 10px 0;
      line-height: 1.6;
      display: flex;
      align-items: center;
    }

    .cred-box strong {
      display: inline-block;
      width: 150px;
      color: #6b7280;
    }

    code {
      background-color: #e0f2fe;
      padding: 3px 8px;
      border-radius: 6px;
      font-family: Consolas, monospace;
      font-size: 0.95em;
      color: #0c4a6e;
    }

    hr {
      border: none;
      border-top: 1px solid #e5e7eb;
      margin: 40px 0;
    }

    @media (max-width: 700px) {
      .container {
        margin: 40px 20px;
        padding: 30px 20px;
      }

      .cred-box strong {
        width: 120px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>✨ Welcome to $domain!  </h1>

    <div class="cred-box">
      <h2>FTP Access</h2>
      <p><strong>Server:</strong> ftp.local</p>
      <p><strong>Username:</strong> $ftp_username</p>
      <p><strong>Password:</strong> <code>$ftp_password_md5</code></p>
      <p><strong>Port:</strong> 21</p>
    </div>

    <div class="cred-box">
      <h2>Database</h2>
      <p><strong>Host:</strong> mysql</p>
      <p><strong>Database Name:</strong> $db_name</p>
      <p><strong>Username:</strong> $db_username</p>
      <p><strong>Password:</strong> <code>$db_password</code></p>
    </div>

    <hr>

    <p style="text-align: center; color: #94a3b8; font-size: 0.9em;">
      Auto-generated hosting panel • Powered by magic 🪄
    </p>
  </div>
</body>
</html>
HTML;

    file_put_contents("$domain_dir/index.html", $html_content);
    exec("chown 1000:1000 $domain_dir/index.html"); // Владелец - ftpuser
    exec("chmod 644 $domain_dir/index.html");

    // Перенаправляем на страницу домена
    header("Location: http://$domain");
    exit;

} catch (Exception $e) {
    die("Ошибка: " . $e->getMessage());
}