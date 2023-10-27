/**
 * Default gulpfile for HALMA projects
 *
 * Version 2021-05-20
 *
 * @see https://www.sitepoint.com/introduction-gulp-js/
 * @see https://nystudio107.com/blog/a-gulp-workflow-for-frontend-development-automation
 * @see https://nystudio107.com/blog/a-better-package-json-for-the-frontend
 *
 * @usage
 * gulp : Start browser-sync, watch css and js files for changes and run development builds on change
 * gulp build : run a development build
 * gulp build --production : run a production build
 * gulp --tasks : Show available tasks (if you want to run a single specific task)
 * 
 * To enable Notifications on Error see:
 * @see https://www.npmjs.com/package/gulp-notify
 * (linux: $ sudo apt-get install libnotify-bin )
 */
'use strict';

// Read command line paramters (arguments)
const argv = require('yargs').argv;

// Check if we want a prodcution build
// Call like `gulp build --production` (or a single task instead of `build`)
const isProduction = (argv.production !== undefined);

// package vars
const pkg = require('./package.json');
const fs = require('fs');

// gulp
const gulp = require('gulp');
const { series } = require('gulp');

// Load all plugins in 'devDependencies' into the variable $
const $ = require('gulp-load-plugins')({
	pattern: ['*'],
	scope: ['devDependencies'],
	rename: {
		'fancy-log': 'log',
		'sass': 'dartSass',
		'gulp-typescript': 'ts'
	}
});

const sass = require('gulp-sass')(require('sass'));
sass.compiler = $.dartSass;

// Default error handler: Log to console
const onError = (err) => {
	console.log(err);
};

const src = pkg.project_settings.source;
const dist = pkg.project_settings.prefix;

// A banner to output as header for dist files
const banner = [
	"/**",
	" * @project       <%= pkg.name %>",
	" * @author        <%= pkg.author %>",
	" * @build         " + $.moment().format("llll") + " ET",
	" * @release       " + $.gitRevSync.long() + " [" + $.gitRevSync.branch() + "]",
	" * @copyright     Copyright (c) " + $.moment().format("YYYY") + ", <%= pkg.copyright %>",
	" *",
	" */",
	""
].join("\n");

// Settings for SVG optimization, used in other settings (see below)
let svgoOptions = {
	plugins: [
		{ cleanupIDs: false },
		{ mergePaths: false },
		{ removeViewBox: false },
		{ convertStyleToAttrs: false },
		{ removeUnknownsAndDefaults: false },
		{ cleanupAttrs: false },
		{ inlineStyles: false }
	]
};


// Project settings
var settings = {
	browserSync: {
		proxy:
			"https://" +
			pkg.name +
			".localhost",
		open: false, // Don't open browser, change to "local" if you want or see https://browsersync.io/docs/options#option-open
		notify: false, // Don't notify on every change
		https: {
			key: require("os").homedir() + "/server.key",
			cert: require("os").homedir() + "/server.crt",
		},
	},
	templates: {
		// Only used for browser-sync / auto-refresh when saving templates
		src: "./templates/**/*.php",
		active: true,
	},
	css: {
		src: src + "css/**/*.scss",
		dest: dist + "css/",
		srcMain: [
			src + "css/tusk.scss",
			src + "css/swu.scss",
			src + "css/webfonts.scss",
			src + "css/pico.scss",
			src + "css/layout.scss"
			// './src/css/email.scss',
			// You can add more files here that will be built seperately,
			// f.e. newsletter.scss
		],
		options: {
			sass: {
				outputStyle: "expanded",
				precision: 3,
				errLogToConsole: true,
			},
		},
		optionsProd: {
			sass: {
				outputStyle: "compressed",
				precision: 3,
				errLogToConsole: true,
			},
		},
	},
	js: {
		src: src + "js/**/*.js",
		srcMain: [
			src + "js/main.js",
			src + "js/layout.js",
			// You can add more files here that will be built seperately,
			// f.e. newsletter.js
		],
		concat: false,
		dest: dist + "js/",
		destFile: "main.js",
	},

	ts: {
		src: src + "js/**/*.ts",
		dest: dist + "js/",
	},

	jsModules: {
		src: src + "js/modules/**/*.js",
		dest: dist + "js/modules/",
	},

	jsVendor: {
		src: [
			src + "js/vendor/**/*.js",
			src + "js/shapes/**/*.js",
			"./node_modules/@editorjs/editorjs/dist/editor.js",
			"./node_modules/@editorjs/header/dist/bundle.js",
			// "./node_modules/@editorjs/list/dist/bundle.js"
			// "./shapes/src/js/**/*.js",
			// Add single vendor files here,
			// they will be copied as is to `{prefix}/js/vendor/`,
			// e.g. './node_modules/flickity/dist/flickity.pkgd.min.js',
		],
		dest: dist + "js/vendor/",
	},

	cssVendor: {
		src: [
			src + "css/vendor/**/*.css",
			// "./node_modules/@picocss/pico/css/pico.min.css"
			// Add single vendor files here,
			// they will be copied as is to `{prefix}/css/vendor/`,
			// e.g. './node_modules/flickity/dist/flickity.min.css'
		],
		dest: dist + "css/vendor/",
	},

	vendor: {
		src: [
			// end in "src/path*/**" to copy all contents to the folder "dist/path"
			"./node_modules/@editorjs/editorjs*/**",
			"./node_modules/@editorjs/header*/**",
			"./node_modules/@editorjs/list*/**",
		],
		dest: dist + "vendor/"
	},

	fonts: {
		src: src + "font/**/*",
		dest: dist + "font/",
	},

	images: {
		src: src + "img/**/*",
		dest: dist + "img/",
		options: [
			$.imagemin.optipng({ optimizationLevel: 5 }),
			$.imagemin.svgo(svgoOptions),
		],
	},

	icons: {
		src: [
			src + "icon/**/*.svg",
			'./node_modules/feather-icons/dist/icons/*.svg'
		],
		dest: dist + "icon/",
		options: [$.imagemin.svgo(svgoOptions)],
	},

	favicon: {
		src: src + "icon/tusk.svg",
		dest: dist + "favicons/",
		background: "#ffffff",
	},

	clean: {
		folders: dist + '/(css|font|icon|img|js|vendor)'
	}
};

// Clean dist before building
function cleanDist() {
	return $.del([settings.clean.folders]);
}

/*
 *  Task: Compile SASS to CSS
 */
function css() {
	$.log("Building CSS" + ((isProduction) ? " [production build]" : " [development build]"));

	var options = (isProduction) ? settings.css.optionsProd.sass : settings.css.options.sass;
	var stream =
		gulp.src(settings.css.srcMain, { sourcemaps: !isProduction })
			.pipe($.plumber({ errorHandler: $.notify.onError("Error: <%= error.message %>") }))
			.pipe(sass(options))
			.pipe($.autoprefixer(settings.css.options.autoprefixer));

	if (isProduction) {
		stream = stream
			.pipe($.cleanCss())
			.pipe($.header(banner, { pkg: pkg }));
	}

	stream = stream
		.pipe(gulp.dest(settings.css.dest, {
			sourcemaps: (!isProduction ? '.' : false)
		}))
		.pipe($.browserSync.stream());

	return stream;
}


function cssVendor() {
	return gulp.src(settings.cssVendor.src)
		.pipe($.plumber({ errorHandler: $.notify.onError("Error: <%= error.message %>") }))
		.pipe(gulp.dest(settings.cssVendor.dest));
}


/*
 * Task: Concat and uglify Javascript with terser
 */
function js() {
	$.log("Building Javascript" + ((isProduction) ? " [production build]" : " [development build]"));

	var stream =
		gulp.src(settings.js.srcMain, { sourcemaps: !isProduction })
			.pipe($.plumber({ errorHandler: $.notify.onError("Error: <%= error.message %>") }))
			.pipe($.jsvalidate());

	if (settings.js.concat) {
		stream = stream.pipe($.concat(settings.js.destFile));
	}

	if (isProduction) {
		stream = stream
			.pipe($.terser({ compress: { drop_console: true } }))
			.on('error', function (error) {
				if (error.plugin !== "gulp-terser-js") {
					console.log(error.message);
				}
				this.emit('end');
			})
			.pipe($.header(banner, { pkg: pkg }));
	}

	stream = stream
		.pipe(gulp.dest(settings.js.dest, {
			sourcemaps: (!isProduction ? '.' : false)
		}))
		.pipe($.browserSync.stream());

	return stream;
}

function ts() {
	$.log("Converting Typescript" + ((isProduction) ? " [production build]" : " [development build]"));
	var tsProject = $.ts.createProject("tsconfig.json");
	var stream = tsProject.src()
		.pipe($.plumber({ errorHandler: $.notify.onError("Error: <%= error.message %>") }))
		.pipe(tsProject())
		.js
		.pipe($.jsvalidate());

	if (settings.js.concat) {
		stream = stream.pipe($.concat(settings.js.destFile));
	}

	if (isProduction) {
		stream = stream
			.pipe($.terser({ compress: { drop_console: true } }))
			.on('error', function (error) {
				if (error.plugin !== "gulp-terser-js") {
					console.log(error.message);
				}
				this.emit('end');
			})
			.pipe($.header(banner, { pkg: pkg }));
	}

	stream = stream
		.pipe(gulp.dest(settings.ts.dest, {
			sourcemaps: (!isProduction ? '.' : false)
		}))
		.pipe($.browserSync.stream());

	return stream;
}


function jsModules() {
	$.log("Building Javascript modules " + ((isProduction) ? " [production build]" : " [development build]"));

	var stream = gulp.src(settings.jsModules.src, { sourcemaps: !isProduction })
		.pipe($.plumber({ errorHandler: $.notify.onError("Error: <%= error.message %>") }))
		.pipe($.jsvalidate());

	if (isProduction) {
		stream = stream
			.pipe($.terser({ compress: { drop_console: true } }))
			.on('error', function (error) {
				if (error.plugin !== "gulp-terser-js") {
					console.log(error.message);
				}
				this.emit('end');
			})
			.pipe($.header(banner, { pkg: pkg }));
	}

	stream = stream
		.pipe(gulp.dest(settings.jsModules.dest, {
			sourcemaps: (!isProduction ? '.' : false)
		}))
		.pipe($.browserSync.stream());

	return stream;
}


function jsVendor() {
	return gulp.src(settings.jsVendor.src)
		.pipe($.plumber({ errorHandler: $.notify.onError("Error: <%= error.message %>") }))
		.pipe(gulp.dest(settings.jsVendor.dest));
}

function vendor() {
	return gulp.src(settings.vendor.src)
		.pipe($.plumber({ errorHandler: $.notify.onError("Error: <%= error.message %>") }))
		.pipe(gulp.dest(settings.vendor.dest));
}

function fonts() {
	return gulp.src(settings.fonts.src)
		.pipe($.plumber({ errorHandler: $.notify.onError("Error: <%= error.message %>") }))
		.pipe(gulp.dest(settings.fonts.dest));
}


/*
 * Task: create images
 * TODO: Check if optimization is more effectiv when it is done separately for all different image types(png, svg, jpg)
 */
function images() {
	// optimize all other images
	// TODO: It seems that plugin in don't overwrites existing files in destination folder!??
	return gulp.src(settings.images.src)
		.pipe($.newer(settings.images.dest))
		.pipe($.imagemin(settings.images.options, { verbose: true }))
		.pipe(gulp.dest(settings.images.dest));
}


function icons() {
	return gulp.src(settings.icons.src)
		.pipe($.newer(settings.icons.dest))
		.pipe($.imagemin(settings.icons.options))
		.pipe(gulp.dest(settings.icons.dest));
}


/**
 * Task: Dummy task to perform reload on template change
 */
function templates(done) {
	$.browserSync.reload();
	done();
}

/*
 * Default TASK: Watch SASS and JAVASCRIPT files for changes,
 * build CSS file and inject into browser
 */
function gulpDefault(done) {
	checkKey();
	$.browserSync.init(settings.browserSync);

	gulp.watch(settings.css.src, css);
	gulp.watch(settings.jsModules.src, jsModules);
	gulp.watch(settings.js.src, js);
	gulp.watch(settings.ts.src, ts);

	if (settings.templates.active) {
		gulp.watch(settings.templates.src, templates);
	}

	done();
}


/**
 * Generate favicons
 */
function favicon(done) {
	if (!fs.existsSync(settings.favicon.src)) {
		$.log("Favicon not found at " + settings.favicon.src);
		return done();
	}

	return gulp.src(settings.favicon.src)
		.pipe($.favicons({
			appName: pkg.name,
			appShortName: pkg.name,
			appDescription: pkg.description,
			developerName: pkg.author,
			developerUrl: pkg.repository.url,
			background: settings.favicon.background,
			path: settings.favicon.dest,
			url: pkg.project_settings.url,
			display: "standalone",
			orientation: "portrait",
			scope: "/",
			start_url: "/",
			version: pkg.version,
			logging: false,
			pipeHTML: false,
			replace: true,
			icons: {
				android: false,
				appleIcon: false,
				appleStartup: false,
				coast: false,
				firefox: false,
				windows: false,
				yandex: false,
				favicons: true
			}
		}))
		.pipe(gulp.dest(settings.favicon.dest));
}

// Check if SSL Key exists in default Directory
function checkKey() {
	try {
		fs.accessSync(settings.browserSync.https.key, fs.constants.R_OK);
	}
	catch (err) {
		settings.browserSync.https = null;
		settings.browserSync.proxy = 'http://' + pkg.name + '.' + require('os').userInfo().username + '.localhost';
	}
}

/*
 * Task: Build all
 */
exports.build = series(cleanDist, ts, js, jsModules, jsVendor, css, cssVendor, vendor, images, icons, fonts, favicon);

exports.default = gulpDefault;
exports.cleanDist = cleanDist;
exports.css = css;
exports.js = js;
exports.jsVendor = jsVendor;
exports.cssVendor = cssVendor;
exports.fonts = fonts;
exports.images = images;
exports.icons = icons;
exports.favicon = favicon;
exports.jsModules = jsModules;
exports.templates = templates;
exports.ts = ts;
exports.vendor = vendor;
