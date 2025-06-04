function alternarTema() {
    const body = document.body;
    body.classList.toggle("oscuro");

    // Guarda la preferencia
    if (body.classList.contains("oscuro")) {
        localStorage.setItem("modo", "oscuro");
    } else {
        localStorage.setItem("modo", "claro");
    }
}

document.addEventListener("DOMContentLoaded", () => {
    if (localStorage.getItem("modo") === "oscuro") {
        document.body.classList.add("oscuro");
    }
});
