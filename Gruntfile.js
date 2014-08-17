module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bowercopy: {
            options: {
                srcPrefix: '',
                destPrefix: 'web/assets'
            },
            scripts: {
                files: {
                    'js/jquery.min.js': 'bower_components/jquery/dist/jquery.min.js',
                    'js/bootstrap.min.js': 'bower_components/bootstrap/dist/js/bootstrap.min.js',
                    'js/app.js': 'local_assets/js/app.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.min.css': 'bower_components/bootstrap/dist/css/bootstrap.min.css',
                    'css/theme.css': 'local_assets/business-casual/css/business-casual.css',
                    'css/app.css': 'local_assets/css/app.css'
                }
            },
            fonts: {
                files: {
                    'fonts/glyphicons-halflings-regular.eot': 'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.eot',
                    'fonts/glyphicons-halflings-regular.svg': 'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.svg',
                    'fonts/glyphicons-halflings-regular.ttf': 'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.ttf',
                    'fonts/glyphicons-halflings-regular.woff': 'bower_components/bootstrap/dist/fonts/glyphicons-halflings-regular.woff'
                }
            },
            images: {
                files: {
                    'img/': 'local_assets/img/*',
                    'img/bg.jpg': 'local_assets/business-casual/img/bg.jpg'
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.registerTask('default', ['bowercopy']);
};