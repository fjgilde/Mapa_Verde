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
                cargarPoligonosDB(); // Corregido aquí
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

function cargarPoligonosDB() {
    fetch('poligonos.php')
        .then(res => res.json())
        .then(data => {
            poligonos = data;
            poligonos.forEach(dibujarPoligonoGuardado);
            actualizarLista();
        });
}

function guardarPoligono() {
    const nombre = document.getElementById('nombre-poligono').value;
    if(!nombre) {
        alert('¡Debes poner un nombre!');
        return;
    }
    const nuevoPoligono = {
        nombre: nombre,
        color: colorActual,
        coordenadas: puntos.map(p => [p.lat, p.lng])
    };

    // Guardar en base de datos por AJAX
    fetch('poligonos.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(nuevoPoligono)
    })
    .then(res => res.json())
    .then(resp => {
        if(resp.ok) {
            nuevoPoligono.id = resp.id;
            poligonos.push(nuevoPoligono);
            actualizarLista();
            cancelarDibujo();
            dibujarPoligonoGuardado(nuevoPoligono);
        } else {
            alert('Error al guardar');
        }
    });
}

function dibujarPoligonoGuardado(poligono) {
    L.polygon(poligono.coordenadas, {
        color: poligono.color,
        fillColor: poligono.color,
        fillOpacity: 0.3
    }).bindPopup(`<b>${poligono.nombre}</b>`).addTo(mapa);
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
            <!-- Aquí puedes poner un botón de eliminar si implementas esa función -->
        `;
        lista.appendChild(item);
    });
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
function eliminarPoligonoDB(id) {
    if (!confirm('¿Seguro que deseas eliminar este polígono?')) return;
    fetch('poligonos.php?id=' + id, {method: 'DELETE'})
        .then(res => res.json())
        .then(resp => {
            if(resp.ok) {
                    poligonos = poligonos.filter(p => p.id !== id);
                actualizarLista();
                mapa.eachLayer(layer => {
                    if(layer instanceof L.Polygon && layer !== poligonoTemporal) {
                        mapa.removeLayer(layer);
                    }
                });
                poligonos.forEach(dibujarPoligonoGuardado);
            } else {
                alert('No se pudo eliminar');
            }
        });
}
window.onload = inicializarMapa;