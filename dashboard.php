<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wonder Ultramen Mahasiswa Community</title>
  <link rel="icon" href="assets/images/logo.png" type="image/png" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: #000;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      transition: opacity 0.5s ease;
    }

    .preloader-content {
      text-align: center;
      animation: fadeIn 1s ease forwards;
    }

    .preloader-logo {
      width: 100px;
      height: 100px;
      animation: rotateGlow 2s linear infinite;
    }

    .loading-text {
      margin-top: 15px;
      font-size: 1.2rem;
      color: #00f2ff;
      text-shadow: 0 0 5px #00f2ff, 0 0 10px #00f2ff, 0 0 15px #00f2ff;
      font-weight: bold;
      animation: pulseText 1.5s infinite ease-in-out;
    }

    @keyframes rotateGlow {
      0% { transform: rotate(0deg); filter: drop-shadow(0 0 5px #00f2ff); }
      100% { transform: rotate(360deg); filter: drop-shadow(0 0 20px #00f2ff); }
    }

    @keyframes pulseText {
      0%, 100% { opacity: 0.6; }
      50% { opacity: 1; }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
      color: white;
      text-align: center;
      background: linear-gradient(-45deg, #6a11cb, #2575fc, #00c9ff, #92fe9d);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
    }

    .wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    canvas {
      position: fixed;
      top: 0;
      left: 0;
      z-index: -1;
      pointer-events: none;
    }

    .logo {
      width: 100px;
      margin-bottom: 1rem;
    }

    h1, h3 {
      margin: 0.5rem 0;
    }

    .buttons {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin: 2rem auto;
      width: 100%;
      max-width: 320px;
    }

    .cta-button {
      width: 100%;
      padding: 14px;
      font-size: 1rem;
      border: none;
      border-radius: 12px;
      background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .cta-button:hover {
      opacity: 0.9;
    }

    @media (max-width: 768px) {
      .wrapper {
        padding: 1rem;
      }

      h1, h2, h3 {
        font-size: 1.5rem;
      }

      .cta-button {
        font-size: 1rem;
      }

      img {
        max-width: 100%;
        height: auto;
      }
    }

    .social-icons {
      list-style: none;
      display: flex;
      justify-content: center;
      gap: 25px;
      padding: 0;
      margin-top: 20px;
      margin-bottom: 30px;
    }

    .social-icons li a {
      font-size: 28px;
      color: white;
      text-decoration: none;
      transition: transform 0.3s ease, color 0.3s ease;
    }

    .social-icons li a:hover {
      transform: scale(1.2);
      color: #00f2ff;
    }

  </style>
</head>
<body>
<div id="preloader">
  <div class="preloader-content">
    <img src="assets/images/logo.png" alt="Loading..." class="preloader-logo" />
    <p class="loading-text">Loading...</p>
  </div>
</div>

<canvas id="starCanvas"></canvas>
<canvas id="birdCanvas"></canvas>


<audio id="bgAudio" loop>
  <source src="assets/audio/background.mp3" type="audio/mpeg">
  Browser Anda tidak mendukung audio.
</audio>

<script>
  // Putar audio setelah klik pertama
  window.addEventListener("click", function playAudioOnce() {
    const audio = document.getElementById("bgAudio");
    audio.play().catch(err => console.log("Autoplay ditolak:", err));
    window.removeEventListener("click", playAudioOnce); // hanya dijalankan sekali
  });
</script>

<div class="wrapper">
  <img src="assets/images/logo.png" alt="Logo Wonder Ultramen" class="logo" />
  <h1>Wonder Ultramen</h1>
  <h3>Mahasiswa Community</h3>
  <p style="margin-top: 10px; font-size: 1.1rem; color: #fff; font-weight: bold;">
    Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!
  </p>

  <div class="buttons">
    <a href="generic.html"><button class="cta-button">Tentang Kami</button></a>
    <a href="gallery.html"><button class="cta-button">Gallery</button></a>
    <a href="elements.html"><button class="cta-button">Pendaftaran</button></a>
    <a href="berita.html"><button class="cta-button">Berita</button></a>
    <a href="jadwal.html"><button class="cta-button">Jadwal</button></a>
    <a href="info.html"><button class="cta-button">Informasi</button></a>
    <a href="logout.php"><button class="cta-button">Logout</button></a>
  </div>
</div>

<script>
  // Bintang
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
    ctx.fillStyle = 'white';
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

  // Burung
  const birdCanvas = document.getElementById('birdCanvas');
  const birdCtx = birdCanvas.getContext('2d');
  let birds = [];

  function resizeBirdCanvas() {
    birdCanvas.width = window.innerWidth;
    birdCanvas.height = window.innerHeight;
  }

  window.addEventListener('resize', resizeBirdCanvas);
  resizeBirdCanvas();

  for (let i = 0; i < 15; i++) {
    birds.push({
      x: Math.random() * birdCanvas.width,
      y: Math.random() * birdCanvas.height / 2,
      size: 10 + Math.random() * 10,
      speedX: 1 + Math.random() * 1.5,
      direction: Math.random() > 0.5 ? 1 : -1,
      flutter: Math.random() * 0.5
    });
  }

  function drawBird(x, y, size, direction) {
    birdCtx.beginPath();
    birdCtx.moveTo(x, y);
    birdCtx.lineTo(x - size * direction, y + size / 2);
    birdCtx.lineTo(x - size * direction, y - size / 2);
    birdCtx.closePath();
    birdCtx.fillStyle = 'white';
    birdCtx.fill();
  }

  function animateBirds() {
    birdCtx.clearRect(0, 0, birdCanvas.width, birdCanvas.height);
    for (let bird of birds) {
      bird.y += Math.sin(Date.now() * 0.005 + bird.flutter) * 0.5;
      bird.x += bird.speedX * bird.direction;

      if (bird.x < -20 || bird.x > birdCanvas.width + 20) {
        bird.x = bird.direction === 1 ? -20 : birdCanvas.width + 20;
        bird.y = Math.random() * birdCanvas.height / 2;
      }

      drawBird(bird.x, bird.y, bird.size, bird.direction);
    }
    requestAnimationFrame(animateBirds);
  }

  animateBirds();
</script>

<!-- Tawk.to Chat Widget -->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/683fb00238f349190a13d94e/1isscf3d5';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>

<!-- Footer -->
<section>
  <p>&copy; 2025 | Wonder Ultramen Mahasiswa Community | Semua hak cipta dilindungi.</p>
</section>
<footer>
  <section>
    <h3>Hubungi kami di sini:</h3>
    <ul class="social-icons">
      <li><a href="https://chat.whatsapp.com/CO4FgK691yeKb19EB0DFaA" class="fab fa-whatsapp" title="WhatsApp"></a></li>
      <li><a href="https://www.youtube.com/@wonderultramen" class="fab fa-youtube" title="YouTube"></a></li>
      <li><a href="https://www.tiktok.com/@wonder_ultramen" class="fab fa-tiktok" title="Tiktok"></a></li>
      <li><a href="https://x.com/wonderultramen" class="fab fa-twitter" title="Twitter"></a></li>
      <li><a href="https://www.instagram.com/wonderultramen" class="fab fa-instagram" title="Instagram"></a></li>
      <li><a href="https://www.facebook.com/profile.php?id=61576940013781" class="fab fa-facebook" title="Facebook"></a></li>
    </ul>
  </section>
</footer>

<script>
  window.addEventListener("load", function () {
    const preloader = document.getElementById("preloader");
    preloader.style.opacity = "0";
    setTimeout(() => {
      preloader.style.display = "none";
    }, 600);
  });
</script>
</body>
</html>
