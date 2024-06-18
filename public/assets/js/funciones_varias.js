$(document).ready(function () {
    console.log("FUNCIONES VARIAS");

    $(".dropdown_accion").click(function () {
        const dropdownName = $(this).attr("data-dropdownname");
        $(`#${dropdownName}`).slideToggle(300);
    });

    $('#user-menu-button').on('click', function (event) {
        event.stopPropagation();
        $('#user-dropdown').toggleClass('hidden');
    });

    // Cerrar el menú al hacer clic fuera de él
    $(document).on('click', function (event) {
        if (!$(event.target).closest('#user-menu-button').length && !$(event.target).closest('#user-dropdown').length) {
            $('#user-dropdown').addClass('hidden');
        }
    });

});

function fn_cerrar_menu() {
    $(`.dropdown_accion`).each(function () {
        const dropdownName = $(this).attr("data-dropdownname");
        $(`#${dropdownName}`).hide(300);
    });
}

function fn_copiar_codigo(elemento_id) {
    const elemento = document.getElementById(elemento_id);
    if (elemento) {
        const texto = elemento.innerText || elemento.textContent;
        navigator.clipboard
            .writeText(texto)
            .then(() => {
                Swal.fire({
                    html: `<h4><b>Copiado al portapapeles</b></h4>`,
                    icon: `success`,
                });
            })
            .catch((err) => {
                Swal.fire({
                    html: `<h4><b>No ha sido posible la copia</b></h4>`,
                    icon: `error`,
                });
            });
    }
}

function fn_scroll_to(elemento_id) {
    const elemento = document.getElementById(`${elemento_id}`);
    console.log("Click en ", elemento_id);
    if (elemento) {
        console.log("elemento para el scroll", elemento);
        window.scrollTo({
            top: elemento.offsetTop - 100,
            behavior: "smooth",
        });
    }
}

function mostrar_error(mensaje) {
    Swal.fire({
        html: `<h4><b>${mensaje}</b></h4>`,
        icon: `error`,
    });
}







