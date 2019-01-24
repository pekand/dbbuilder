var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var useref = require('gulp-useref');
var uglify = require('gulp-uglify');
var gulpIf = require('gulp-if');
var cssnano = require('gulp-cssnano');
var imagemin = require('gulp-imagemin');
var cache = require('gulp-cache');
var del = require('del');
var filter = require('gulp-filter');
var concat = require('gulp-concat');
var print = require('gulp-print');
var minimist = require('minimist');
var replace = require('gulp-replace');
var twig = require('gulp-twig');
var htmlmin = require('gulp-htmlmin');
var ext_replace = require('gulp-ext-replace');
var merge = require('gulp-merge');
 

// Command line arguments
// -----------------

// gulp build --env development
// gulp build --env production
var knownOptions = {
  string: 'env',
  default: { env: process.env.NODE_ENV || 'development' }
};

var options = minimist(process.argv.slice(2), knownOptions);

// Development Tasks 
// -----------------

var bowerMain = [
  //'node_modules/jquery/dist/jquery.js',

  'node_modules/bootstrap/dist/css/bootstrap.css',
  //'node_modules/bootstrap/dist/css/bootstrap-theme.css',  
  'node_modules/bootstrap/dist/fonts/*',
  'node_modules/bootstrap/dist/js/bootstrap.js',
  
  'node_modules/font-awesome/css/font-awesome.css',
  'node_modules/font-awesome/fonts/*',

  //'node_modules/jquery-ui/jquery-ui.js',
  //'node_modules/jquery-ui/themes/base/jquery-ui.css',
  'node_modules/jquery-ui/themes/base/images/*',

  'node_modules/moment/moment.js',  
  
  'Assets/js/**/*.js',
  'Assets/img/**/*.+(ico|png|jpg|jpeg|gif|svg)',
  'Assets/fonts/**/*'
];

gulp.task('js', function() {
  return 
      gulp.src(bowerMain)
      .pipe(filter('**/*.js'))
    //.pipe(print())
    .pipe(filter('**/*.js'))
    .pipe(concat('script.js'))
    .pipe(gulpIf(options.env === 'production', uglify()))
    .pipe(gulp.dest('Assets/'))
});


gulp.task('css', function() {
  return merge(
      gulp.src(bowerMain)    
      .pipe(filter('**/*.css')),
      gulp.src('Scss/**/*.scss')
      .pipe(sass().on('error', sass.logError)), 
      gulp.src('Assets/css/**/*.css')
    )
    //.pipe(print())    
    .pipe(concat('styles.css'))
    .pipe(replace('../fonts', '/Assets/fonts'))
    .pipe(replace('url("images', 'url("/Assets/img'))    
    .pipe(gulpIf(options.env === 'production', cssnano()))
    .pipe(gulp.dest('Assets/'));
})

// Optimization Tasks 
// ------------------

// Optimizing Images 
gulp.task('images', function() {
  return 
      gulp.src(bowerMain)          
      .pipe(filter('**/*.+(ico|png|jpg|jpeg|gif|svg)'))
    // Caching images that ran through imagemin
    //.pipe(print())
    .pipe(cache(imagemin({
      interlaced: true,
    })))
    .pipe(gulp.dest('Assets/img-min/'))
});

// Copying fonts 
gulp.task('fonts', function() {
  return gulp.src(bowerMain)          
    .pipe(filter('**/*.+(eot|svg|ttf|woff|woff2)'))
    //.pipe(print())
    .pipe(gulp.dest('Assets/'))
})

// Compile twig 
gulp.task('compile', function () {
    return gulp.src('Twig/**/**/!(_)*.twig.html')
        .pipe(twig())
        //.pipe(print())
        .pipe(gulpIf(options.env === 'production', htmlmin({collapseWhitespace: true})))
        .pipe(ext_replace('.html', '.twig.html'))
        .pipe(gulp.dest('Assets'));
});

// Build Sequences
// ---------------

// Watchers
gulp.task('watch', function() {
  gulp.watch('Scss/**/*.scss', ['css']);
  gulp.watch('Assets/js/**/*.js', ['js']);
  gulp.watch('Twig/**/*.twig.html', ['compile']);
})

gulp.task('default', gulp.series(
  'css', 
  'watch'
))

gulp.task('build', gulp.series(
  'images', 
  'fonts', 
  'js', 
  'css', 
  'compile'
))

