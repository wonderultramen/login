<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION["username"] = $username;
      header("Location: dashboard.php");
      exit();
    } else {
      $error = "Password salah.";
    }
  } else {
    $error = "Akun tidak ditemukan.";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(-45deg, #6a11cb, #2575fc, #00c9ff, #92fe9d);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
    }
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .login-container {
      background: rgba(0, 0, 0, 0.6);
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      width: 90%;
      max-width: 350px;
      z-index: 1;
      text-align: center;
    }
    .login-container img.logo {
      width: 100px;
      margin-bottom: 1rem;
    }
    .login-container input,
    .login-container button {
      width: 100%;
      padding: 10px;
      margin-bottom: 1rem;
      border: none;
      border-radius: 10px;
    }
    .login-container button {
      background: #6a11cb;
      color: white;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }
    .login-container button:hover {
      background: #2575fc;
    }
    canvas {
      position: fixed;
      top: 0;
      left: 0;
      z-index: 0;
      pointer-events: none;
    }
    .error {
      background: #ff4e4e;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 10px;
      color: white;
    }
  </style>
</head>
<body>
<canvas id="starCanvas"></canvas>
<div class="login-container">
  <img src="assets/images/logo.png" class="logo" alt="Logo" />
  <h2>Login</h2>
  <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
  <form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
  <p>Belum punya akun? <a href="register.php" style="color:#00f2ff;">Register</a></p>
</div>
<script>
  const canvas = document.getElementById('starCanvas');
  const ctx = canvas.getContext('2d');
  let stars = [];
  function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  window.addEventListener('resize', resizeCanvas);
  resizeCanvas();
  for (let i = 0; i < 100; i++) {
    stars.push({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      radius: Math.random() * 1.5,
      speed: Math.random() * 0.5 + 0.2
    });
  }
  function animateStars() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = 'yellow';
    for (let star of stars) {
      ctx.beginPath();
      ctx.arc(star.x, star.y, star.radius, 0, 2 * Math.PI);
      ctx.fill();
      star.y += star.speed;
      if (star.y > canvas.height) {
        star.y = 0;
        star.x = Math.random() * canvas.width;
      }
    }
    requestAnimationFrame(animateStars);
  }
  animateStars();
</script>
</body>
</html>
