import gulp from 'gulp';
import concat from 'gulp-concat';
import autoprefixer from 'gulp-autoprefixer';
import cssnano from 'gulp-cssnano';
import sourcemaps from 'gulp-sourcemaps';

const adminCssFiles = './assets/css/admin/*.css';
const blockCssFiles = './assets/css/block/*.css';
const cssDest = 'build';


// Helper function to process CSS files
function processCss(srcFiles, outputFile) {
    return gulp.src(srcFiles)
        .pipe(sourcemaps.init())
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(cssnano())
        .pipe(concat(outputFile))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(cssDest));
}

// Task for admin CSS files
gulp.task('admin-styles', function () {
    return processCss(adminCssFiles, 'build.admin.css');
});

// Task for block CSS files
gulp.task('block-styles', function () {
    return processCss(blockCssFiles, 'build.block.css');
});

gulp.task('styles', gulp.series('admin-styles', 'block-styles'));

// Watch task
gulp.task('watch', function () {
    gulp.watch(adminCssFiles, gulp.series('admin-styles'));
    gulp.watch(blockCssFiles, gulp.series('block-styles'));
});

gulp.task('default', gulp.series('styles', 'watch'));
