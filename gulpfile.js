var gulp = require('gulp');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var gutil = require('gulp-util');
var cssbeautify = require('gulp-cssbeautify');
var rename = require("gulp-rename");

var paths = {
    scripts: [],
    libs: [],
    styles: []
};

gulp.task('default', ['compress', 'sass', 'minify'], function() {
    return gutil.log('Gulp is running!');
});

/* Uglify js files */
gulp.task('compress', function () {
    return gulp.src('./app/Resources/assets/js/*.js')
        .pipe(uglify()) // Uglify
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('web/dist/js'));
});

/* Compile ssas and minify css */
gulp.task('sass', function () {
  return gulp.src('./app/Resources/assets/sass/**/*.scss')
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(cleanCSS({compatibility: 'ie8'}))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('./web/app/css'));
});

/* Minify css */
gulp.task('minify', function () {
    return gulp.src('./app/Resources/assets/css/**/*.css')
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./web/dist/css/'));
});