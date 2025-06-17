<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

  if ($conn->query($sql) === TRUE) {
    header("Location: login.php");
    exit();
  } else {
    $error = "Gagal mendaftar: " . $conn->error;
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
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

    .register-container {
      background: rgba(0, 0, 0, 0.6);
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      width: 90%;
      max-width: 350px;
      z-index: 1;
      text-align: center;
    }

    .register-container img.logo {
      width: 100px;
      margin-bottom: 1rem;
    }

    .register-container h2 {
      margin-bottom: 1rem;
    }

    .register-container input {
      width: 100%;
      padding: 10px;
      margin-bottom: 1rem;
      border: none;
      border-radius: 10px;
    }

    .register-container button {
      width: 100%;
      padding: 10px;
      background: #6a11cb;
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.3s;
    }

    .register-container button:hover {
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

<div class="register-container">
  <img src="assets/images/logo.png" alt="Logo" class="logo" />
  <h2>Register</h2>
  <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
  <form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Daftar</button>
  </form>
  <p>Sudah punya akun? <a href="index.php" style="color:#00f2ff;">Login</a></p>
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
