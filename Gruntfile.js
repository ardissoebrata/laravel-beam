/* jshint node: true */

module.exports = function(grunt) {
	'use strict';

	// Force use of Unix newlines
	grunt.util.linefeed = '\n';

	// Project configuration.
	grunt.initConfig({
		// Metadata.
		pkg: grunt.file.readJSON('package.json'),
		banner: '/*!\n' +
				' * Bootstrap v3.0.3 (http://getbootstrap.com)\n' +
				' * Copyright 2013 Twitter, Inc.\n' +
				' * Licensed under http://www.apache.org/licenses/LICENSE-2.0\n' +
				' */\n',
		jqueryCheck: 'if (typeof jQuery === "undefined") { throw new Error("Bootstrap requires jQuery") }\n\n',
		bootstrapDir: 'public/assets/bootstrap/',
		// Task configuration.
		clean: {
			options: {
				force: true
			},
			dist: ['<%= bootstrapDir %>dist/css', '<%= bootstrapDir %>dist/js']
		},
		concat: {
			options: {
				banner: '<%= banner %>\n<%= jqueryCheck %>',
				stripBanners: false
			},
			bootstrap: {
				src: [
					'<%= bootstrapDir %>js/transition.js',
					'<%= bootstrapDir %>js/alert.js',
					'<%= bootstrapDir %>js/button.js',
					'<%= bootstrapDir %>js/carousel.js',
					'<%= bootstrapDir %>js/collapse.js',
					'<%= bootstrapDir %>js/dropdown.js',
					'<%= bootstrapDir %>js/modal.js',
					'<%= bootstrapDir %>js/tooltip.js',
					'<%= bootstrapDir %>js/popover.js',
					'<%= bootstrapDir %>js/scrollspy.js',
					'<%= bootstrapDir %>js/tab.js',
					'<%= bootstrapDir %>js/affix.js'
				],
				dest: '<%= bootstrapDir %>dist/js/bootstrap.js'
			}
		},
		uglify: {
			options: {
				banner: '<%= banner %>\n',
				report: 'min'
			},
			bootstrap: {
				src: ['<%= concat.bootstrap.dest %>'],
				dest: '<%= bootstrapDir %>dist/js/bootstrap.min.js'
			}
		},
		less: {
			compileCore: {
				options: {
					sourceMap: true,
					outputSourceFiles: true,
					sourceMapURL: 'bootstrap.css.map',
					sourceMapFilename: '<%= bootstrapDir %>dist/css/bootstrap.css.map'
				},
				files: {
					'<%= bootstrapDir %>dist/css/bootstrap.css': '<%= bootstrapDir %>less/bootstrap.less'
				}
			},
			compileTheme: {
				options: {
					sourceMap: true,
					outputSourceFiles: true,
					sourceMapURL: 'bootstrap-theme.css.map',
					sourceMapFilename: '<%= bootstrapDir %>dist/css/bootstrap-theme.css.map'
				},
				files: {
					'<%= bootstrapDir %>dist/css/bootstrap-theme.css': '<%= bootstrapDir %>less/theme.less'
				}
			},
			minify: {
				options: {
					cleancss: true,
					report: 'min'
				},
				files: {
					'<%= bootstrapDir %>dist/css/bootstrap.min.css': '<%= bootstrapDir %>dist/css/bootstrap.css',
					'<%= bootstrapDir %>dist/css/bootstrap-theme.min.css': '<%= bootstrapDir %>dist/css/bootstrap-theme.css'
				}
			}
		},
		usebanner: {
			dist: {
				options: {
					position: 'top',
					banner: '<%= banner %>'
				},
				files: {
					src: [
						'<%= bootstrapDir %>dist/css/bootstrap.css',
						'<%= bootstrapDir %>dist/css/bootstrap.min.css',
						'<%= bootstrapDir %>dist/css/bootstrap-theme.css',
						'<%= bootstrapDir %>dist/css/bootstrap-theme.min.css',
					]
				}
			}
		},
		csscomb: {
			sort: {
				options: {
					sortOrder: '.csscomb.json'
				},
				files: {
					'<%= bootstrapDir %>dist/css/bootstrap.css': ['<%= bootstrapDir %>dist/css/bootstrap.css'],
					'<%= bootstrapDir %>dist/css/bootstrap-theme.css': ['<%= bootstrapDir %>dist/css/bootstrap-theme.css'],
				}
			}
		}
	});


	// These plugins provide necessary tasks.
	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

	// JS distribution task.
	grunt.registerTask('dist-js', ['concat', 'uglify']);

	// CSS distribution task.
	grunt.registerTask('dist-css', ['less', 'csscomb', 'usebanner']);
	
	// Full distribution task.
	grunt.registerTask('dist', ['clean', 'dist-css', 'dist-js']);

	// Default task.
	grunt.registerTask('default', ['dist']);
};
