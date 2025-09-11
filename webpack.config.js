const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .addStyleEntry('styles', './assets/css/app.css')
    .enableSingleRuntimeChunk()  // Active un runtime chunk unique pour éviter les conflits
    .enableVersioning(Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();


