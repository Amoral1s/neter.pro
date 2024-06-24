import path from 'path';
import { promises as fs } from 'fs';
import browsersync from 'browser-sync';
import fileinclude from 'gulp-file-include';
import * as sass from 'sass';
import gulpSass from 'gulp-sass';
import group_media from 'gulp-group-css-media-queries';
import clean_css from 'gulp-clean-css';
import rename from 'gulp-rename';
import imagemin from 'gulp-imagemin';
import ttf2woff from 'gulp-ttf2woff';
import ttf2woff2 from 'gulp-ttf2woff2';
import fonter from 'gulp-fonter';
import newer from 'gulp-newer';
import del from 'del';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify-es';
import mergeStream from 'merge-stream';

import pkg from 'gulp';
const { src, dest, series, parallel, watch } = pkg;

const project_folder = path.basename(path.resolve());
const source_folder = '#src';

const paths = {
    build: {
        html: './',
        css: './css/',
        js: './js/',
        img: './img/',
        fonts: './fonts/',
    },
    src: {
        html: './**/*.html',
        css: [
            source_folder + '/sass/**/*.sass',
            '!' + source_folder + '/sass/**/_*.sass' // Исключаем файлы с префиксом "_"
        ],
        cssAll: source_folder + '/sass/**/*.sass', // Все SASS файлы, включая префиксы
        js: [
            source_folder + '/js/menu.js',
            source_folder + '/js/swiper.js',
            source_folder + '/js/lightgallery.js',
            source_folder + '/js/lg-thumbnail.js',
            source_folder + '/js/phone_mask.js',
            source_folder + '/js/range.js',
            source_folder + '/js/sliders.js',
            source_folder + '/js/forms.js',
            source_folder + '/js/single_page.js',
            source_folder + '/js/scripts_main.js',
            source_folder + '/js/yandex.js',
            source_folder + '/js/calc.js'
        ],
        img: source_folder + '/img/**/*.{jpg,png,svg,gif,ico,webp}',
        fonts: source_folder + '/fonts/*.ttf',
    },
    watch: {
        html: './**/*.php',
        css: source_folder + '/sass/**/*.sass',
        js: source_folder + '/js/**/*.js',
        img: source_folder + '/img/**/*.{jpg,png,svg,gif,ico,webp}',
    },
    clean: './' + project_folder + '/'
};

const browsersyncInstance = browsersync.create();
const gulpSassInstance = gulpSass(sass);

function logPaths(done) {
    console.log('CSS Source Paths:', paths.src.css);
    console.log('JS Source Paths:', paths.src.js);
    done();
}

function browserSync() {
    browsersyncInstance.init({
        proxy: 'http://neter.local', // Убедитесь, что этот прокси соответствует вашему серверу MAMP
        notify: false,
        open: true, // Открыть новое окно браузера при запуске
        codeSync: true, // Включить синхронизацию кода
        cors: true // Включить CORS
    });
}

function html() {
    return src(paths.src.html)
        .pipe(fileinclude())
        .pipe(dest(paths.build.html))
        .pipe(browsersyncInstance.stream());
}

function css() {
    // Компилируем все файлы, включая префиксы
    return src(paths.src.cssAll)
        .pipe(gulpSassInstance({ outputStyle: 'expanded' }).on('error', gulpSassInstance.logError))
        .pipe(group_media())
        .pipe(dest(paths.build.css))
        .pipe(clean_css())
        .pipe(rename({ extname: '.min.css' }))
        .pipe(dest(paths.build.css))
        .pipe(browsersyncInstance.stream({ match: '**/*.css' }));
}

function js() {
    const includedJsFiles = paths.src.js.map(jsFile => path.join(source_folder, 'js', path.basename(jsFile)));
    
    // Конкатенация и минификация включенных файлов
    const includedStream = src(includedJsFiles)
        .pipe(concat('main.js'))
        .pipe(dest(paths.build.js))
        .pipe(uglify.default())
        .pipe(rename({ extname: '.min.js' }))
        .pipe(dest(paths.build.js))
        .pipe(browsersyncInstance.stream());
    
    // Копирование остальных файлов
    const allJsFilesGlob = path.join(source_folder, 'js', '*.js');
    const excludedJsFilesGlob = includedJsFiles.map(file => `!${file}`);
    
    const remainingStream = src([allJsFilesGlob, ...excludedJsFilesGlob])
        .pipe(dest(paths.build.js))
        .pipe(uglify.default())
        .pipe(rename({ extname: '.min.js' }))
        .pipe(dest(paths.build.js))
        .pipe(browsersyncInstance.stream());
    
    return mergeStream(includedStream, remainingStream);
}

function images() {
    return src(paths.src.img)
        .pipe(newer(paths.build.img))
        .pipe(dest(paths.build.img));
}

function fonts() {
    return src(paths.src.fonts)
        .pipe(ttf2woff())
        .pipe(dest(paths.build.fonts))
        .pipe(src(paths.src.fonts))
        .pipe(ttf2woff2())
        .pipe(dest(paths.build.fonts));
}

function fonts_otf() {
    return src('./' + source_folder + '/fonts/*.otf')
        .pipe(fonter({ formats: ['ttf'] }))
        .pipe(dest('./' + source_folder + '/fonts/'));
}

async function fontstyle() {
    const file_content = await fs.readFile(source_folder + '/sass/reset/_fonts.sass', 'utf-8');
    if (!file_content) {
        await fs.writeFile(source_folder + '/sass/reset/_fonts.sass', '');
        const items = await fs.readdir(paths.build.fonts);
        if (items) {
            let c_fontname;
            for (let i = 0; i < items.length; i++) {
                let fontname = items[i].split('.')[0];
                if (c_fontname != fontname) {
                    await fs.appendFile(source_folder + '/sass/reset/_fonts.sass', '@include font("' + fontname + '", "' + fontname + '", "400", "normal");\r\n');
                }
                c_fontname = fontname;
            }
        }
    }
    return src(paths.src.html).pipe(browsersyncInstance.stream());
}

function reload(done) {
    browsersyncInstance.reload();
    done();
}

function watchFiles() {
    watch([paths.watch.html], series(html, reload));
    watch([paths.watch.css], series(css));
    watch([paths.watch.js], series(js, reload));
    watch([paths.watch.img], series(images, reload));
}

function clean() {
    return del(paths.clean);
}

const fontsBuild = series(fonts_otf, fonts, fontstyle);
const buildDev = series(clean, parallel(fontsBuild, css, html, js, images));
const watcher = series(logPaths, buildDev, parallel(watchFiles, browserSync));

export { fontsBuild as fonts };
export { watcher as watch };
export default watcher;