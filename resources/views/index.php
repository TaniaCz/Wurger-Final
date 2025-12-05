<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WURGER - Las mejores hamburguesas</title>
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Righteous&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Barra de Navegación -->
    <nav class="navbar">
        <div class="logo">
            <i class="fas fa-hamburger"></i>
            <span>WURGER</span>
        </div>
        
        <ul class="nav-links">
            <li><a href="#inicio">Inicio</a></li>
            <li><a href="#menu">Menú</a></li>
             <li><a href="#promociones">Promos</a></li>
            <li><a href="#nosotros">Nosotros</a></li>
            <li><a href="dahsboard.html">Dashboard</a></li>
            <li><a href="login.html"><button class="btn-login">Iniciar Sesión</button></a></li>
        </ul>
        
        <div class="hamburger">
            <i class="fas fa-bars"></i>
        </div>
    </nav>

    <!-- Sección Hero -->
    <section id="inicio" class="hero animate-fade">
        <h1>Las mejores hamburguesas de la ciudad</h1>
        <p>Descubre nuestro menú premium con ingredientes frescos y sabores únicos. ¡Una experiencia gastronómica que no olvidarás!</p>
        <a href="#menu" class="hero-btn">Ver Menú</a>
    </section>
    <!-- Sección Menú -->
<section id="menu" class="animate-fade">
  <h2 class="section-title">Nuestro Menú</h2>
  <div class="menu-container">
    <div class="menu-item">
      <img src="./img/ham-1.jpg" alt="Hamburguesa Clásica con queso y vegetales frescos">
      <h3>Clásica</h3>
      <p>Carne 200g, queso cheddar, lechuga, tomate y salsa especial</p>
      <span class="price">$12.99</span>
    </div>
    <div class="menu-item">
      <img src="img/ham-2.jpg" alt="Hamburguesa con bacon crujiente">
      <h3>Bacon XL</h3>
      <p>Doble carne, bacon crocante, cebolla caramelizada y salsa BBQ</p>
      <span class="price">$15.99</span>
    </div>
    <div class="menu-item">
      <img src="img/ham-3.jpg" alt="Hamburguesa vegetariana saludable">
      <h3>Vegetariana</h3>
      <p>NotBurger de garbanzos, aguacate, rúcula y tomate seco</p>
      <span class="price">$13.99</span>
    </div>
    <div class="menu-item">
      <img src="img/ham-4.jpg" alt="Hamburguesa picante con jalapeños">
      <h3>Spicy Jalapeño</h3>
      <p>Carne Angus, jalapeños, queso pepper jack y salsa chipotle</p>
      <span class="price">$14.99</span>
    </div>
  </div>
</section>

<!-- Sección Promociones -->
<section id="promociones" class="animate-fade">
  <h2 class="section-title">Promociones Especiales</h2>
  <div class="menu-container">
    <div class="menu-item">
      <img src="img/ham-2.jpg" alt="Promoción 2x1 en hamburguesas">
      <h3>2x1 Martes</h3>
      <p>Todos los martes disfruta de 2 hamburguesas al precio de 1.</p>
      <span class="price">Solo por Hoy</span>
    </div>
    <div class="menu-item">
      <img src="img/ham-4.jpg" alt="Combo familiar con bebidas">
      <h3>Combo Familiar</h3>
      <p>4 hamburguesas, papas grandes y 4 bebidas por un precio especial.</p>
      <span class="price">$39.99</span>
    </div>
    <div class="menu-item">
      <img src="img/ham-1.jpg" alt="Menú infantil">
      <h3>Menú Infantil</h3>
      <p>Hamburguesa pequeña con papas y jugo natural para los peques.</p>
      <span class="price">$9.99</span>
    </div>
    <div class="menu-item">
      <img src="img/ham-3.jpg" alt="Descuento online">
      <h3>10% Online</h3>
      <p>Ordena en línea y recibe un 10% de descuento en tu compra.</p>
      <span class="price">Envío Gratis</span>
    </div>
  </div>
</section>


            </div>
        </div>
    </section>

    <!-- Sección Nosotros -->
    <section id="nosotros" class="animate-fade">
        <h2 class="section-title">Sobre Nosotros</h2>
        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
            <p>En WURGER llevamos más de 10 años sirviendo las hamburguesas más deliciosas de la región. Nuestra pasión por la comida de calidad y el servicio excepcional nos ha convertido en el favorito de los amantes de las hamburguesas.</p>
            <p>Todos nuestros ingredientes son seleccionados cuidadosamente y preparados al momento para garantizar la mejor experiencia gastronómica.</p>
        </div>
    </section>

    <script>
        // Menú hamburguesa para móviles
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            hamburger.innerHTML = navLinks.classList.contains('active') 
                ? '<i class="fas fa-times"></i>' 
                : '<i class="fas fa-bars"></i>';
        });

        // Cerrar menú al hacer clic en un enlace
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                hamburger.innerHTML = '<i class="fas fa-bars"></i>';
            });
        });

        // Smooth scrolling para los enlaces
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>






