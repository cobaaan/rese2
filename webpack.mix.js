const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/bootstrap-icons/font/fonts', 'public/fonts')
   .version(); // セミコロンの位置を修正

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.(woff|woff2|eot|ttf|svg)$/,
                use: {
                  loader: 'url-loader',
                }
            }
        ]
    }
});
