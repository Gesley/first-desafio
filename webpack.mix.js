const mix = require('laravel-mix');

// Compila o arquivo CSS
mix.css('resources/css/app.css', 'public/css')
    .js('resources/js/app.js', 'public/js') // Se você também estiver usando JS
    .version(); // Para versionamento de arquivos
