<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hosting Center - Register Domain</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Register Your Domain</h1>
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required placeholder="your@email.com">
        </div>
        <div class="form-group">
            <label for="domain">Desired Domain Name</label>
            <input type="text" id="domain" name="domain" required placeholder="example">
            <small style="display: block; margin-top: 5px; color: #718096;">Your domain will be: example.localhost</small>
        </div>
        <button type="submit">Register Domain</button>
    </form>
</div>
</body>
</html>