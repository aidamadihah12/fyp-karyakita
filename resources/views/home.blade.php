<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Studio Karya Kita</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">

  <!-- TOP NAVIGATION -->
  <nav style="position: absolute; top: 30px; right: 40px; z-index: 10;">
    <a href="{{ route('login') }}" style="margin-right: 20px; text-decoration: none; color: white; background: rgba(0,0,0,0.6); padding: 10px 20px; border-radius: 30px; font-weight: bold;">Login</a>
    <a href="{{ route('register') }}" style="text-decoration: none; color: white; background: rgba(255,255,255,0.9); padding: 10px 20px; border-radius: 30px; font-weight: bold;">Register</a>
  </nav>

  <style>
    body {
      margin: 0;
      font-family: 'Open Sans', sans-serif;
      color: #111;
      background-color: #fff;
      scroll-behavior: smooth;
    }

    .hero {
      height: 100vh;
      background: url('images/images1.png') center/cover no-repeat; /* Background updated to use images5.png */
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .hero h1 {
      font-family: 'Playfair Display', serif;
      font-size: 4rem;
      color: white;
      background-color: rgba(0,0,0,0.4);
      padding: 1rem 2rem;
      border-radius: 5px;
    }

    .section {
      padding: 80px 20px;
      max-width: 1100px;
      margin: auto;
    }

    .section h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      margin-bottom: 1rem;
      text-align: center;
    }

    .section p {
      font-size: 1.1rem;
      text-align: center;
      max-width: 700px;
      margin: auto;
    }

    .image-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      margin-top: 60px;
    }

    .image-grid img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 8px;
      transition: transform 0.3s ease;
    }

    .image-grid img:hover {
      transform: scale(1.03);
    }

    .cta {
      background: #111;
      color: white;
      text-align: center;
      padding: 80px 20px;
    }

    .cta h3 {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      margin-bottom: 20px;
    }

    .cta a {
      background: white;
      color: black;
      padding: 15px 30px;
      text-decoration: none;
      border-radius: 40px;
      font-weight: bold;
    }

    footer {
      background: #f2f2f2;
      text-align: center;
      padding: 30px;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

  <!-- HERO -->
  <div class="hero">
    <h1>Welcome to Studio Karya Kita</h1>
  </div>

  <!-- ABOUT SECTION -->
  <section class="section">
    <h2>We Tell Stories Through Imagery</h2>
    <p>
      Studio Karya Kita blends emotion, creativity, and timeless aesthetics to deliver photography that elevates your personal or professional brand.
    </p>
  </section>

  <!-- IMAGE GRID SECTION -->
  <section class="section">
    <div class="image-grid">
      <img src="images/images1.png" alt="Work 1"> <!-- Update to correct local path -->
      <img src="images/images2.png" alt="Work 2"> <!-- Update to correct local path -->
      <img src="images/images3.png" alt="Work 3"> <!-- Update to correct local path -->
      <img src="images/images4.png" alt="Work 4"> <!-- Update to correct local path -->
      <img src="images/images5.png" alt="Work 5"> <!-- Update to correct local path -->
      <img src="images/images6.png" alt="Work 6"> <!-- Update to correct local path -->
      <img src="images/convo1.png" alt="Work 7"> <!-- Update to correct local path -->
      <img src="images/convo3.png" alt="Work 8"> <!-- Update to correct local path -->
      <img src="images/convo2.png" alt="Work 9"> <!-- Update to correct local path -->
    </div>
  </section>

  <!-- CTA SECTION -->
  <section class="cta">
    <h3>Book Your Session Today</h3>
    <a href="#contact">Contact Us</a>
  </section>

  <!-- FOOTER -->
  <footer>
    &copy; {{ date('Y') }} Studio Karya Kita | Crafted with vision and soul.
  </footer>

</body>
</html>
