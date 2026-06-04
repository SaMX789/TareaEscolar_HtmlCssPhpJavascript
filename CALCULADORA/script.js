const pantalla = document.getElementById("pantalla");


function agregar(valor) {
    pantalla.value += valor;
}

function limpiar() {
    pantalla.value = "";
}

function calcular() {
    try {
           pantalla.value = eval(pantalla.value);
    } catch (error) {
        pantalla.value = "Error";
        setTimeout(limpiar, 1500); 
    }
}