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
          'js/src/libs/jquery-1.11.0.min.js',
          'js/src/libs/jquery-ui-1.10.3.custom.min.js',
          '../../frontend/javascript/underscore.js',
          '../../framework/admin/javascript/lib.js',
          '../../frontend/javascript/jquery.ss.pagination.js',
          '../../frontend/javascript/jquery.ss.endless.js',
          'js/src/libs/isotope/dist/isotope.pkgd.min.js',
          'js/src/libs/isotope/js/layout-modes/fit-cols.js',
          'js/src/libs/gumby.js',
          'js/src/libs/ui/gumby.retina.js',
          'js/src/libs/ui/gumby.fixed.js',
          'js/src/libs/ui/gumby.skiplink.js',
          'js/src/libs/ui/gumby.toggleswitch.js',
          'js/src/libs/ui/gumby.checkbox.js',
          'js/src/libs/ui/gumby.radiobtn.js',
          'js/src/libs/ui/gumby.tabs.js',
          'js/src/libs/ui/gumby.navbar.js',
          'js/src/libs/ui/gumby.fittext.js',
          'js/src/libs/ui/jquery.validation.js',
          'js/src/libs/gumby.init.js',
          "js/src/libs/tags-input/jquery.tagsinput.js",
          'js/src/libs/parsleyjs/dist/parsley.js',
          'js/src/libs/gumby.min.js',
          'js/src/general.src.js',
          'js/src/isotope.src.js',
          '../../calendar/javascript/pagetypes/CalendarPage.js',
         '../../calendar/thirdparty/fullcalendar/1.6.1/jquery/jquery-ui-1.10.2.custom.min.js',
         '../../calendar/thirdparty/fullcalendar/1.6.1/fullcalendar/fullcalendar.min.js',
         '../../calendar/thirdparty/xdate/xdate.js',
         '../../calendar/javascript/fullcalendar/PublicFullcalendarView.js'
      ],
      dest: 'js/script.js',
    },
  },
  jshint: {
    options: {
      browser: true,
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
        sourceMap: true
    },
    build: {
        files: {
            'js/script.min.js': ['js/script.js']
        }
    }
  },
  watch: {
    js: {
        files: ['js/**/*.js'],
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


grunt.registerTask('default', []);

};
