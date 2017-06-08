var gulp = require('gulp');
var eta = require('gulp-eta');
var config = {};

config.scaffold = {
  source: {
    root: '_src'
  },
  assets: {
    root: 'public/assets',
    sass: '/public'
  }
};

config.browserSync = {
  settings: {
    server: false,
    proxy: "local.whites-electronics",
    files: [
      './**/*.js',
      './**/*.css',
      './**/*.html',
      '!node_modules/'
    ]
  }
};

eta(gulp, config);