<div?php
?>

<!DOCTYPE html>
<html>
<head>
    <title>MAPA VERDE</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
        #map {
            height: 600px;
            width: 70%;
            margin: 20px 0;
            border: 2px solid #555;
            border-radius: 8px;
        }
        .controls {
            margin: 10px 0;
            width: 70%;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 5px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .container::after{
            display: flex;
            content: "";
            display: table;
            clear: both;
        }
        aside{
            display: auto;
            float: right;
            width: 300px;
            background-color: #f0f0f0;
            padding: auto;
            margin: 0 auto;
        }
        #lista-poligonos {
            margin: 20px 0;
            padding: 10px;
            background: #fff;
            border-radius: 5px;
            max-height: 200px;
            overflow-y: auto;
        }
        .poligono-item {
            padding: 5px;
            margin: 5px 0;
            border-left: 5px solid;
        }
        #formulario {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            z-index: 1000;
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <nav>
        <img id="logotipo" src="imagenes/imageniatierra.png"><div class="logo"></a><a class="logo" href="index.php">Mapa Verde</a></div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="noticias.php">Noticias e Informacion</a></li>
                <li><a href="estadisticas.php">Estadisticas</a></li>
                <?php if (isset($_SESSION['usuario'])): ?>
                <li>
                <img src="imagenes/usuario.png" alt="Usuario" style="width: 30px; height: 30px; border-radius: 50%;">
                </li>
                <?php else: ?>
                <li><a href="login.php" class="login-btn">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque tempore tenetur maxime saepe laborum nisi dignissimos adipisci rem, architecto, iure aliquid obcaecati illum totam! Totam reiciendis sunt similique asperiores ducimus.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, voluptate cumque? Maiores beatae, debitis soluta quis saepe facilis aliquam! Eos modi expedita accusantium hic officiis sint neque perferendis distinctio itaque.
    </p>
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque tempore tenetur maxime saepe laborum nisi dignissimos adipisci rem, architecto, iure aliquid obcaecati illum totam! Totam reiciendis sunt similique asperiores ducimus.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, voluptate cumque? Maiores beatae, debitis soluta quis saepe facilis aliquam! Eos modi expedita accusantium hic officiis sint neque perferendis distinctio itaque.
    </p>
    <aside>
        <h3>Noticias Importantes</h3>
        <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque tempore tenetur maxime saepe laborum nisi dignissimos adipisci rem, architecto, iure aliquid obcaecati illum totam! Totam reiciendis sunt similique asperiores ducimus.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, voluptate cumque? Maiores beatae, debitis soluta quis saepe facilis aliquam! Eos modi expedita accusantium hic officiis sint neque perferendis distinctio itaque.
        </p>
    </aside>
    </div>
    
    <div class="controls">
        <button onclick="iniciarDibujo()">Nuevo punto Limpio</button>
        <button class="color-btn" style="background: #ff000080" onclick="seleccionarColor('#ff000080')"></button>
        <button class="color-btn" style="background: #0000ff80" onclick="seleccionarColor('#0000ff80')"></button>
        <button class="color-btn" style="background: #00ff0080" onclick="seleccionarColor('#00ff0080')"></button>
        <button class="color-btn" style="background: #fffb00" onclick="seleccionarColor('#fffb00')"></button>
        <button onclick="limpiarTodo()">Limpiar Todo</button>
    </div>
    
    <div>

    <div id="formulario">
        <h3>Punto Limpio</h3>
        <input type="text" id="nombre-poligono" placeholder="Ej: Zona de peligro" required>
        <button onclick="guardarPoligono()">Guardar</button>
        <button onclick="cancelarDibujo()">Cancelar</button>
    </div>
    <div id="container">
    </div>
    <div id="map"></div>

    <div id="lista-poligonos"></div>

    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque tempore tenetur maxime saepe laborum nisi dignissimos adipisci rem, architecto, iure aliquid obcaecati illum totam! Totam reiciendis sunt similique asperiores ducimus.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, voluptate cumque? Maiores beatae, debitis soluta quis saepe facilis aliquam! Eos modi expedita accusantium hic officiis sint neque perferendis distinctio itaque.
    </p>
    <br></br>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let mapa;
        let poligonoTemporal = null;
        let puntos = [];
        let colorActual = '#ff000080';
        let poligonos = [];

        function inicializarMapa() {
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(
                    function(position){
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        mapa = L.map('map').setView([lat, lng], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapa);
                        cargarPoligonos();
                    }
                )
            }
        }
        function iniciarDibujo() {
            puntos = [];
            if(poligonoTemporal) {
                mapa.removeLayer(poligonoTemporal);
            }
            
            mapa.on('click', agregarPunto);
            mapa.on('dblclick', finalizarDibujo);
            alert('Clic para añadir vértices - Doble clic para finalizar');
        }

        function agregarPunto(e) {
            puntos.push(e.latlng);
            
            if(!poligonoTemporal) {
                poligonoTemporal = L.polygon([], {
                    color: colorActual,
                    fillOpacity: 0.3
                }).addTo(mapa);
            }
            
            poligonoTemporal.setLatLngs([puntos]);
        }

        function finalizarDibujo() {
            if(puntos.length > 2) {
                document.getElementById('formulario').style.display = 'block';
                mapa.off('click');
                mapa.off('dblclick');
            }
        }

        function guardarPoligono() {
            const nombre = document.getElementById('nombre-poligono').value;
            if(!nombre) {
                alert('¡Debes poner un nombre!');
                return;
            }

            const nuevoPoligono = {
                id: Date.now(),
                nombre: nombre,
                color: colorActual,
                coordenadas: puntos.map(p => [p.lat, p.lng])
            };

            poligonos.push(nuevoPoligono);
            localStorage.setItem('poligonos', JSON.stringify(poligonos));
            actualizarLista();
            cancelarDibujo();
            dibujarPoligonoGuardado(nuevoPoligono);
        }

        function dibujarPoligonoGuardado(poligono) {
            L.polygon(poligono.coordenadas, {
                color: poligono.color,
                fillColor: poligono.color,
                fillOpacity: 0.3
            }).bindPopup(`<b>${poligono.nombre}</b>`).addTo(mapa);
        }

        function cargarPoligonos() {
            const guardados = localStorage.getItem('poligonos');
            if(guardados) {
                poligonos = JSON.parse(guardados);
                poligonos.forEach(dibujarPoligonoGuardado);
                actualizarLista();
            }
        }

        function actualizarLista() {
            const lista = document.getElementById('lista-poligonos');
            lista.innerHTML = '<h3>Puntos Limpios Guardados:</h3>';
            
            poligonos.forEach(poligono => {
                const item = document.createElement('div');
                item.className = 'poligono-item';
                item.style.borderColor = poligono.color;
                item.innerHTML = `
                    ${poligono.nombre}
                    <button onclick="eliminarPoligono(${poligono.id})" style="float: right">Eliminar</button>
                `;
                lista.appendChild(item);
            });
        }

        function eliminarPoligono(id) {
            poligonos = poligonos.filter(p => p.id !== id);
            localStorage.setItem('poligonos', JSON.stringify(poligonos));
            location.reload();
        }

        function seleccionarColor(color) {
            colorActual = color;
            document.querySelectorAll('.color-btn').forEach(btn => {
                btn.style.border = btn.style.backgroundColor === color ? '2px solid black' : 'none';
            });
        }

        function limpiarTodo() {
            localStorage.removeItem('poligonos');
            location.reload();
        }

        function cancelarDibujo() {
            document.getElementById('formulario').style.display = 'none';
            document.getElementById('nombre-poligono').value = '';
            if(poligonoTemporal) {
                mapa.removeLayer(poligonoTemporal);
                poligonoTemporal = null;
                puntos = [];
            }
        }

        window.onload = inicializarMapa;
  
        </script>

    <div id="chat-icon" class="chat-icon">
        <img src="imagenes/imageniatierra.png" alt="Chat IA">
    </div>

    <div id="chat-container" class="chat-container" style="display: none;">
        <div id="chat-messages"></div>
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="Escribe tu mensaje...">
            <button id="send-btn">Enviar</button>
        </div>
        <div id="loading" style="display: none;">Cargando...</div>
    </div>

    <script src="javascript/cliente.js"></script>

    <div id="comments">
        
    </div>
    <footer>
        <p>&copy; 2024 Web Responsive. Hecho por Francisco Javier Gutierrez Ildefonso.</p>
    </footer>
</body>
</html>