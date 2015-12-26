var gulp = require('gulp'),
		uglify = require('gulp-uglify'),
		less = require('gulp-less'),
		rename = require('gulp-rename'),
		minify = require('gulp-minify-css');

var static = 'static';
var src = {
	js: static + '/js/hljs.js',
	less: static + '/less/hljs.less',
};
var dest = {
  js: static + '/js',
  css: static + '/css',
};


// Uglfiy JS files
gulp.task('uglify-js', function () {
	return gulp.src(src.js)
		.pipe(uglify())
		.pipe(rename({
			extname: '.min.js'
		}))
		.pipe(gulp.dest(dest.js));
});

// Compile less to css
gulp.task('compile-less', function () {
	return gulp.src(src.less)
		.pipe(less())
		.pipe(minify())
		.pipe(rename({
			extname: '.min.css'
		}))
		.pipe(gulp.dest(dest.css));
});

var exec = require('child_process').exec;

// Compile Highlight.JS library
gulp.task('compile-highlightjs', function (cb) {
  var cmd = 'cd highlightjs;';
  cmd += 'node tools/build.js -t cdn;';
  cmd += '(test -d "../static/lib/highlightjs" || mkdir -p "../static/lib/highlightjs");';
  cmd += 'cp -Rf build/* ../static/lib/highlightjs/';

  exec(cmd, function (err, stdout, stderr) {
    console.log(stdout);
    console.log(stderr);
    cb(err);
  });
});


// Default Task
gulp.task('default', [
	'uglify-js', 'compile-less', 
	'compile-highlightjs'
]);