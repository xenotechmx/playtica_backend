window.onload = function () {
    var container = document.getElementById("widget-container");
    var button = document.getElementsByClassName('btn-reservation-submenu')[0];

    // Esta parte inicializa el widget
    window.WidgetReservaciones.render(container, {
        isAdmin: true // False o no pasar opciones en el caso del visitante
    });
    
    // Además del método render y show, puedes llamar: hide()
    button.addEventListener("click", function (event) {
        event.preventDefault();
        window.WidgetReservaciones.show();
    });
}