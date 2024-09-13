const gulp = require('gulp');
const concat = require('gulp-concat');
//const gzip = require('gulp-gzip');
//const uglify_es = require('gulp-uglify-es').default;
//const clean_css = require('gulp-clean-css');

function concatGulpCss () {
    return gulp.src([
        'resources/css/bootstrap.min.css',
        'resources/css/select2v1.4.6-bootstrap.min.css',
        'resources/css/select2v4.0.4.min.css',
        'resources/css/app.css'
    ])
        .pipe(concat('app.css'))
        //.pipe(clean_css())
        //.pipe(gulp.dest("public/css"))
        //.pipe(gzip())
        .pipe(gulp.dest("public/css"));
};

function concatGulpJs () {
    return gulp.src([
        'resources/js/jquery-3.7.1.min.js',
        'resources/js/jquery.validate.min.js',
        'resources/js/bootstrap.bundle.v5.0.2.min.js',
        'resources/js/select2.v4.0.4.min.js',
        'resources/js/app.js'
    ])
        .pipe(concat('app.js'))
        //.pipe(uglify_es())
        //.pipe(gulp.dest("public/js"))
        //.pipe(gzip())
        .pipe(gulp.dest("public/js"));
};

exports.concatcss = concatGulpCss;
exports.concatjs = concatGulpJs;
