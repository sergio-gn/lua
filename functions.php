<?php

// Adiciona um shortcode para exibir o formulário de cadastro
function custom_registration_form_shortcode() {
    ob_start();
    ?>
    <form id="registration-form" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post" style="
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    ">
        <label for="username" style="
            display: block;
            margin-bottom: 10px;
        ">Nome de Usuário:</label>
        <input type="text" name="username" required style="
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        ">

        <label for="email" style="
            display: block;
            margin-bottom: 10px;
        ">Email:</label>
        <input type="email" name="email" required style="
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        ">

        <label for="password" style="
            display: block;
            margin-bottom: 10px;
        ">Senha (mínimo 8 caracteres):</label>
        <input type="password" name="password" required style="
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        ">

        <input type="submit" name="submit" value="Cadastrar" style="
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        ">
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('registration_form', 'custom_registration_form_shortcode');

// Processa o formulário de registro quando enviado
function custom_registration_form_handler() {
    if (isset($_POST['submit'])) {
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];

        // Verifica se a senha tem pelo menos 8 caracteres
        if (strlen($password) < 8) {
            echo 'A senha deve ter pelo menos 8 caracteres.';
            return;
        }

        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            // Registro bem-sucedido
            echo 'Registro bem-sucedido!';
        } else {
            // Houve um erro no registro
            echo 'Erro ao registrar: ' . $user_id->get_error_message();
        }
    }
}
add_action('init', 'custom_registration_form_handler');