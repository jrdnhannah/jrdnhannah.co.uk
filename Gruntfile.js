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
                    'js/bootstrap.min.js': 'bower_components/bootstrap/dist/js/bootstrap.min.js'
                }
            },
            stylesheets: {
                files: {
                    'css/bootstrap.min.css': 'bower_components/bootstrap/dist/css/bootstrap.min.css'
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
                    'images/': 'local_assets/images/*'
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.registerTask('default', ['bowercopy']);
};