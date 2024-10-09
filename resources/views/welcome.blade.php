<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white">
    <div id="success-banner" class="alert alert-success" style="display:none; position: fixed; top: 0; left: 0; right: 0; z-index: 1000; text-align: center;">

    </div>

    <section class="pb-4">
        <div class="border rounded-5 shadow-lg">
            <section class="p-5 w-100">
                <div class="row">
                    <div class="col-12">
                        <div class="card text-black" style="border-radius: 25px;">
                            <div class="card-body p-md-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                        <h1 class="text-center text-body fw-bold mb-5 mt-4">Cadastro de Usuário</h1>

                                        <form id="registrationForm" method="POST">
                                            <div class="mb-4">
                                                <div class="form-outline">
                                                    <input type="text" id="name" name="name" class="form-control" required>
                                                    <label class="form-label" for="name">Seu Nome</label>
                                                    <div class="invalid-feedback" id="name-error"></div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <div class="form-outline">
                                                    <input type="email" id="email" name="email" class="form-control" required>
                                                    <label class="form-label" for="email">Seu E-mail</label>
                                                    <div class="invalid-feedback" id="email-error"></div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <div class="form-outline">
                                                    <input type="password" id="password" name="password" class="form-control" required>
                                                    <label class="form-label" for="password">Senha</label>
                                                    <div class="invalid-feedback" id="password-error"></div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <div class="form-outline">
                                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                                                    <label class="form-label" for="password_confirmation">Repetir Senha</label>
                                                    <div class="invalid-feedback" id="password_confirmation-error"></div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center mb-3">
                                                <button type="submit" id="submitButton" class="btn btn-primary btn-lg" style="border-radius: 25px; transition: background-color 0.3s;">Registrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</body>


<script>
    $(document).ready(function() {

        $('#registrationForm').on('submit', function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            var formData = {
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val()
            };

            $.ajax({
                url: '/api/usuarios', // URL da sua API
                type: 'POST',
                data: formData,
                headers: {
                    'Accept': 'application/json'
                },
                success: function(response) {

                    $('#success-banner').text(response.message);
                    // Limpa mensagens de erro anteriores
                    $('.invalid-feedback').text('');
                    $('#success-banner').fadeIn().delay(3000).fadeOut();
                    // Limpa o formulário ou redireciona se necessário
                    $('#registrationForm')[0].reset();
                },
                error: function(response) {
                    // Limpa mensagens de erro anteriores
                    $('.invalid-feedback').text('');

                    var errors = response.responseJSON.errors;

                    // Exibe as mensagens de erro ao lado dos campos correspondentes
                    if (errors.name) {
                        $('#name-error').text(errors.name[0]).show();
                        $('#name').addClass('is-invalid');
                    }
                    if (errors.email) {
                        $('#email-error').text(errors.email[0]).show();
                        $('#email').addClass('is-invalid');
                    }
                    if (errors.password) {
                        $('#password-error').text(errors.password[0]).show();
                        $('#password').addClass('is-invalid');
                    }
                    if (errors.password_confirmation) {
                        $('#password_confirmation-error').text(errors.password_confirmation[0]).show();
                        $('#password_confirmation').addClass('is-invalid');
                    }
                }
            });
        });
    });
</script>

</html>