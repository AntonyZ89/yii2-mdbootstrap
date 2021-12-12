const { src, dest } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const uglify = require('gulp-uglify');
const uglifycss = require('gulp-uglifycss');
const rename = require('gulp-rename');

const css = src('./src/assets/css/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(uglifycss())
    .pipe(rename({ extname: '.min.css' }))
    .pipe(dest('./src/assets/dist/css'))

const js = src('./src/assets/js/*.js')
    .pipe(uglify())
    .pipe(rename({ extname: '.min.js' }))
    .pipe(dest('./src/assets/dist/js'))

exports.default = async function () {
    return [css, js]
}