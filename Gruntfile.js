/**
    props
    http://24ways.org/2013/grunt-is-not-weird-and-hard/
    http://www.html5rocks.com/en/tutorials/tooling/supercharging-your-gruntfile/
 */

module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {   
            dist: {
                src: [
                    'js/jquery-1.10.1.min.js', // All JS in the libs folder
                    'js/superfish/js/superfish.js',  // This specific file
                    'js/superfish/js/hoverIntent.js',
                    'js/site.js',
                    'js/header.js'
                ],
                dest: 'js/global.js',
            }
        },

        uglify: {
            build: {
                src: 'js/global.js',
                dest: 'js/global.min.js'
            }
        },

        sass: {
            dist: {
                options: {
                    style: 'compressed'
                },
                files: {
                    'css/informedelectorate.css': 'css/sass/informedelectorate.scss'
                }
            } 
        },       



        watch: {
            scripts: {
                files: ['js/*.js'],
                tasks: ['concat', 'uglify'],
                options: {
                    spawn: false,
                },
            },
            css: {
                files: ['css/sass/*.scss'],
                tasks: ['sass'],
                options: {
                    spawn: false,
                }
            }            
        },


    });

    // 3. Install this, if needed: npm install load-grunt-tasks
    // loads tasks in package.json, rather than 
    // grunt.loadNpmTasks('grunt-contrib-concat'); ...
    require('load-grunt-tasks')(grunt);


    

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['concat', 'uglify', 'sass']);

};
