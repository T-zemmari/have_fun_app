$(document).ready(function () {
    console.log('Aqui');
    const menuToggle = $("#menu-toggle");
    const sidebar = $("#sidebar");
    const mainContent = $("#main-content");

    menuToggle.on("click", function () {
        console.log('click en menutoogle');
        sidebar.toggleClass("show");
        // Ajusta el ancho del contenido principal cuando el menú se abre o se cierra
        mainContent.css("margin-left", sidebar.hasClass("show") ? "250px" : "50px");
        $(`.span_menu_hide_all`).toggleClass("span_menu_show_all");
    });
});

function mostrar_submenu(elemento) {
    console.log('click en ',`#menu_lateral_${elemento}`);
    $('.submenu_lateral').hide();
    $(`#menu_lateral_${elemento}`).toggle();
}