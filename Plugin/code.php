<?php 
/**
 * Plugin Name: Plugin ManuWP
 * Description: Es un plugin de prueba para saber como crearlo y como funciona
 * Version: 1.0.2
 * Author: Manu García
 */

 
add_shortcode( "banner", function($atts, $content){
    $mensaje_banner = get_option('mensaje_banner', 'Este es el mensaje por defecto'); // Obtiene el mensaje del banner, si no hay uno guardado, se usa el mensaje por defecto
    $output = '<div
    style="
    background-color: #2698d1;
    font-size: 25px;
    line-height: 24px;
    color: #070707;
    text-align: center;
    padding: 20px 0;
    font-family: Arial, Helvetica, sans-serif;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    "
  >
    <marquee  direction="right" height="100px">
      ' . esc_html($mensaje_banner) . ' <!-- Muestra el mensaje del banner -->
    </marquee>
  </div>';
    return $output;
});

// Agregar la página de opciones en el panel de control
add_action('admin_menu', 'manuwp_agregar_pagina_opciones');

function manuwp_agregar_pagina_opciones() {
    add_options_page('Top Bar', 'Banner', 'manage_options', 'manuwp_opciones_banner', 'manuwp_mostrar_pagina_opciones');
}

function manuwp_mostrar_pagina_opciones() {
    ?>
    <div class="wrap">
        <h2>Opciones del Banner</h2>
        <form method="post" action="options.php">
            <?php settings_fields('manuwp_opciones_banner_group'); ?>
            <?php do_settings_sections('manuwp_opciones_banner'); ?>
            <input type="submit" class="button-primary" value="Guardar cambios">
        </form>
    </div>
    <?php
}

// Registrar la opción de mensaje del banner
add_action('admin_init', 'manuwp_registrar_opciones');

function manuwp_registrar_opciones() {
    register_setting('manuwp_opciones_banner_group', 'mensaje_banner');
    add_settings_section('manuwp_banner_section', 'Configuración del Banner', 'manuwp_mostrar_seccion_banner', 'manuwp_opciones_banner');
    add_settings_field('manuwp_mensaje_banner', 'Mensaje del Banner', 'manuwp_mostrar_campo_mensaje', 'manuwp_opciones_banner', 'manuwp_banner_section');
}

function manuwp_mostrar_seccion_banner() {
    echo 'Personaliza el mensaje del banner:';
}

function manuwp_mostrar_campo_mensaje() {
    $mensaje_banner = esc_attr(get_option('mensaje_banner'));
    echo '<input type="text" name="mensaje_banner" value="' . $mensaje_banner . '" />';
}
