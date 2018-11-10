var pasos = 0;
function threadMapa() {
    pasos = pasos + 1;
    cargarMapa();
    setTimeout("threadMapa()",500);
}

threadMapa();