document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form-review");

    // Cargar valoraciones al iniciar
    cargarValoraciones();

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const data = new FormData(form);

        fetch("valoraciones.php", {
            method: "POST",
            body: data
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.ok) {
                alert("¡Gracias por tu valoración!");
                form.reset();
                cargarValoraciones();
            } else {
                alert("Error al enviar valoración");
            }
        });
    });
});

function cargarValoraciones() {
    fetch("valoraciones.php")
        .then(res => res.json())
        .then(data => {
            const contenedor = document.getElementById("lista-valoraciones");
            let html = "<h4>Últimas valoraciones:</h4>";
            data.forEach(v => {
                const fecha = new Date(v.datetime * 1000).toLocaleString();
                const estrellas = "⭐".repeat(v.user_rating);
                html += `
                    <div class="valoracion">
                        <strong>${v.user_name}</strong> (${fecha})<br>
                        ${estrellas}<br>
                        <em>${v.user_review}</em>
                        <hr>
                    </div>
                `;
            });
            contenedor.innerHTML = html;
        });
}
    