// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
    // directory where all compiled assets will be stored
    .setOutputPath('public/build/')

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath('/build')

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // will output as public/build/js/app.js
    .addEntry('js/app', './assets/js/main.js')

    // will output as public/build/css/global.css
    .addStyleEntry('css/app', './assets/css/app.scss')
    .addStyleEntry('css/bootstrap.min', './assets/css/bootstrap.min.css')

    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

    // create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();
