var elixir = require('laravel-elixir')
liveReload = require('gulp-livereload'),
    clean = require('rimraf'),
    gulp = require('gulp');



var config = {
    assets_path: './resources/assets',
    build_path: './public/build',
};

/*
 | Bower components path
 */
config.bower_path = config.assets_path + '/../bower_components';

config.build_path_js = config.build_path + '/js'
config.build_vendor_path_js = config.build_path_js + '/vendor';
config.vendor_path_js = [
    config.bower_path + '/jquery/dist/jquery.min.js',
    config.bower_path + '/bootstrap/dist/js/bootstrap.min.js',
    config.bower_path + '/angular/angular.min.js',
    config.bower_path + '/angular-route/angular-route.min.js',
    config.bower_path + '/angular-resource/angular-resource.min.js',
    config.bower_path + '/angular-animate/angular-animate.min.js',
    config.bower_path + '/angular-sanitize/angular-sanitize.min.js',
    config.bower_path + '/angular-messages/angular-messages.min.js',
    config.bower_path + '/angular-bootstrap/ui-bootstrap.min.js',
    config.bower_path + '/angular-bootstrap/ui-bootstrap-tpls.js',
    config.bower_path + '/ui-select/dist/select.min.js',
    config.bower_path + '/angular-cookies/angular-cookies.min.js',
    config.bower_path + '/query-string/query-string.js',
    config.bower_path + '/angular-oauth2/dist/angular-oauth2.min.js',
    config.bower_path + '/angular-papaparse/dist/js/angular-PapaParse.js',
    config.bower_path + '/papaparse/papaparse.min.js',
    config.bower_path + '/angular-slimscroll/angular-slimscroll.js',
    config.bower_path + '/slimScroll/jquery.slimscroll.min.js',
    config.bower_path + '/angular-toArrayFilter/toArrayFilter.js',
    config.bower_path + '/datatables/media/js/jquery.dataTables.min.js',
    config.bower_path + '/angular-datatables/dist/angular-datatables.min.js',
    config.bower_path + '/angular-datatables/dist/plugins/bootstrap/angular-datatables.bootstrap.min.js'
];


config.build_path_css = config.build_path + '/css';
config.build_vendor_path_css = config.build_path_css + '/vendor';
config.vendor_path_css = [
    config.bower_path + '/bootstrap/dist/css/bootstrap.min.css',
    config.bower_path + '/ui-select/dist/select.min.css',
    config.bower_path + '/bootstrap/dist/css/bootstrap-theme.min.css',
    config.bower_path + '/components-font-awesome/css/font-awesome.min.css',
    config.bower_path + '/simple-line-icons/css/simple-line-icons.css',
    config.bower_path + '/jquery.uniform/themes/default/css/uniform.default.min.css',
    config.bower_path + '/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
    config.bower_path + '/angular-datatables/dist/plugins/bootstrap/datatables.bootstrap.min.css'
];

config.build_path_html = config.build_path + '/views';
gulp.task('copy-html', function(){
    gulp.src([
        config.assets_path + '/js/views/**/*.html'
    ])
        .pipe(gulp.dest(config.build_path_html))
        .pipe(liveReload());
});


//config.build_path_font = config.build_path + '/css/fonts';
config.build_path_font = config.build_path + '/fonts';
gulp.task('copy-font', function(){
    gulp.src([
        config.assets_path + '/css/fonts/**/*'
    ])
        .pipe(gulp.dest(config.build_path_font))
        .pipe(liveReload());
});

config.build_path_img = config.build_path + '/images';
gulp.task('copy-img', function(){
    gulp.src([
        config.assets_path + '/images/**/*'
    ])
        .pipe(gulp.dest(config.build_path_img))
        .pipe(liveReload());


});


gulp.task('copy-styles', function(){
    gulp.src([
        config.assets_path + '/css/**/*.css'
    ])
        .pipe(gulp.dest(config.build_path_css))
        .pipe(liveReload());

    gulp.src(config.vendor_path_css)
        .pipe(gulp.dest(config.build_vendor_path_css))
        .pipe(liveReload());
});



gulp.task('copy-scripts', function(){
    gulp.src([
        config.assets_path + '/js/**/*.js'
    ])
        .pipe(gulp.dest(config.build_path_js))
        .pipe(liveReload());

    gulp.src(config.vendor_path_js)
        .pipe(gulp.dest(config.build_vendor_path_js))
        .pipe(liveReload());
});




gulp.task('clear-build-folder', function(){
    clean.sync(config.build_path);
});


gulp.task('default',['clear-build-folder'], function(){
    gulp.start('copy-html', 'copy-font', 'copy-img');

    elixir(function(mix){
        mix.styles(config.vendor_path_css.concat([config.assets_path+'/css/**/*.css']),
        'public/css/all.css', config.assets_path);

        mix.scripts(config.vendor_path_js.concat([config.assets_path+'/js/**/*.js']),
            'public/js/all.js', config.assets_path);

        mix.version(['js/all.js', 'css/all.css']);
    });
});




gulp.task('watch-dev',['clear-build-folder'] ,function(){
    liveReload.listen();
    gulp.start('copy-styles', 'copy-scripts', 'copy-html', 'copy-font', 'copy-img');
    gulp.watch(config.assets_path + '/**',['copy-styles','copy-scripts', 'copy-html']);
});



