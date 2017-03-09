module.exports = function(grunt) {

	// 1. All configuration goes here
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// 2. Configuration for concatinating files goes here.
		uglify: {
			target: {
				files: [{
					expand: true,
					cwd: 'assets/js',
					src: ['**/*.js','!**/*.min.js'],
					dest: 'assets/js',
					ext:  '.min.js'
				}]
			}
		},
		cssmin: {
			options: {
				sourceMap: true
			},
			target: {
				files: [{
					expand: true,
					cwd: 'assets/css',
					src: '**/*.css',
					dest: ''
				}]
			},
		},
		info:	'/*\n'+
				'Theme Name: Sans\n'+
				'Theme URI: https://github.com/davidakennedy/sans\n'+
				'Author: David A. Kennedy\n'+
				'Author URI: https://davidakennedy.com\n'+
				'Description: A minimalist theme with substance and without the superficial.\n'+
				'Version: 2.0.0\n'+
				'License: GNU General Public License v2 or later\n'+
				'License URI: http://www.gnu.org/licenses/gpl-2.0.html\n'+
				'Text Domain: sans\n'+
				'Tags: one-column, blog, accessibility-ready, custom-menu, custom-logo, footer-widgets, rtl-language-support, sticky-post, threaded-comments, translation-ready\n'+
				'*/',
		header: {
			dist: {
				options: {
					text: '<%= info %>'
				},
				files: {
					'style.css': 'style.css'
				}
			}
		},
		watch: {
			scripts: {
				files: ['assets/js/*.js'],
				tasks: ['uglify'],
				options: {
					spawn: false,
				},
			},
			css: {
				files: ['assets/css/*.css'],
				tasks: ['cssmin'],
				options: {
					spawn: false,
				},
			},
		},
	});

	// 3. Where we tell Grunt we plan to use this plug-in.
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-header');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
	grunt.registerTask('default', ['uglify', 'cssmin', 'header']);
};