module.exports = function (grunt) {

// -- Config -------------------------------------------------------------------

grunt.initConfig({
	compass: {
		dist: {
			options: {
				config: 'config.rb'
			}
		}
	},
	concat: {
		options: {
			separator: ';',
		},
		dist: {
			src: [
				'js/src/libs/modernizr-2.6.2.min.js',
				'js/src/libs/jquery.js',
				'js/src/libs/jquery-ui.js',

                'js/src/libs/ui/toggles_switches.js',

                'js/src/libs/ui/jquery.validation.js',

                '../../calendar/thirdparty/timeentry/jquery.plugin.js',

				'../../framework/javascript/DateField.js',

				'../../calendar/thirdparty/timepicker/jquery.timepicker.js',
				'../../calendar/thirdparty/timeentry/jquery.timeentry.js',
				'../../calendar/thirdparty/fullcalendar/1.6.1/fullcalendar/fullcalendar.js',
				'../../calendar/thirdparty/xdate/xdate.js',

				'../../frontend/javascript/underscore.js',
				'../../framework/admin/javascript/lib.js',
				'../../frontend/javascript/jquery.ss.pagination.js',
				'../../frontend/javascript/jquery.ss.endless.js',
				'js/src/libs/parsleyjs/dist/parsley.js',
				'js/src/libs/isotope/dist/isotope.pkgd.min.js',
				'js/src/libs/isotope/js/layout-modes/fit-cols.js',
				'js/src/libs/ui/jquery.validation.js',
				"js/src/libs/tags-input/jquery.tagsinput.js",
				"js/src/libs/sharebutton/share-button.js",
                'js/src/libs/materialmodal.js',

                'js/src/libs/medium-editor/dist/js/medium-editor.js',
				'js/src/isotope.src.js',
				'../../calendar/javascript/pagetypes/CalendarPage.js',

				'../../calendar/javascript/fullcalendar/PublicFullcalendarView.js',

				'../../calendar/javascript/events/EventFields.js',
				'js/src/general.src.js'
			],
			dest: 'js/script.js',
		},
	},
  jshint: {
	options: {
	  browser: true,
	  reporterOutput: "",
	  globals: {
		jQuery: true
	  },
	},
	src: [
		'js/src/**/*.src.js'
		],
  },
  uglify: {
	options: {
		sourceMap: true,
		sourceMapIncludeSources: true
	},
	build: {
		files: {
			'js/script.min.js': ['js/script.js']
		}
	}
  },
  watch: {
	js: {
		files: ['js/**/*.js', '../../calendar/thirdparty/fullcalendar/1.6.1/fullcalendar/fullcalendar.js'],
		tasks: ['jshint', 'concat', 'uglify']
	},
	scss: {
		files: ['sass/**/*.scss'],
		tasks: ['compass']
	}
  }
});

// Load tasks
grunt.loadNpmTasks('grunt-contrib-compass');
grunt.loadNpmTasks('grunt-contrib-concat');
grunt.loadNpmTasks('grunt-contrib-uglify');
grunt.loadNpmTasks('grunt-contrib-watch');
grunt.loadNpmTasks('grunt-contrib-jshint');


grunt.registerTask('default', ['watch']);

};
