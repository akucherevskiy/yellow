/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _aboutGallery = __webpack_require__(1);

	var _aboutGallery2 = _interopRequireDefault(_aboutGallery);

	var _shop = __webpack_require__(2);

	var _shop2 = _interopRequireDefault(_shop);

	var _shopItemGallery = __webpack_require__(3);

	var _shopItemGallery2 = _interopRequireDefault(_shopItemGallery);

	var _addToBasket = __webpack_require__(4);

	var _addToBasket2 = _interopRequireDefault(_addToBasket);

	var _googleMaps = __webpack_require__(5);

	var _googleMaps2 = _interopRequireDefault(_googleMaps);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/***/ },
/* 1 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});

	exports.default = function aboutGallery($) {
	  var owlCarousel = $('.owl-carousel');
	  var galleryContent = $('#galleryCarousel');
	  var gallerySelector = $('.about-gallery-sel');
	  var ACTIVE_CLASS = 'is-active';
	  var owlOptions = {
	    items: 3,
	    center: true,
	    loop: true
	  };

	  owlCarousel.owlCarousel(owlOptions);

	  gallerySelector.on('click', function () {
	    gallerySelector.removeClass(ACTIVE_CLASS);
	    var galleryId = $(this).data('gallery-id');
	    $(this).addClass(ACTIVE_CLASS);
	    $.get('partials/about/' + galleryId + '.html').then(function (response) {
	      galleryContent.html(response);
	      $('body').animate({
	        scrollTop: $(galleryContent).offset().top
	      }, 1000);
	      $('.owl-carousel').owlCarousel(owlOptions);
	    });
	  });
	}($);

/***/ },
/* 2 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});

	exports.default = function shop() {
	  var shopNavItem = $('.shop-nav-cat');
	  var shopItems = $('#shopItems');

	  shopNavItem.on('click', function (e) {
	    var ACTIVE_CLASS = 'is-active';
	    e.preventDefault();
	    shopItems.fadeOut(50);
	    var catId = $(this).data('cat-id');
	    $.get('/partials/shop/' + catId + '.html').then(function (response) {
	      return shopItems.fadeOut(10, function () {
	        return shopItems.empty().html(response).fadeIn(500);
	      });
	    });

	    $(this).addClass(ACTIVE_CLASS).siblings().removeClass(ACTIVE_CLASS);
	  });
	}();

/***/ },
/* 3 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});

	exports.default = function shopItemGallery() {
	  var galleryItem = $('.shopItem-gallery-carouselImg');
	  var activeGalleryItem = $('.shopItem-gallery-mainImg');
	  var ACTIVE_CLASS = 'is-active';

	  galleryItem.on('click', function () {
	    $(this).parent().addClass(ACTIVE_CLASS).siblings().removeClass(ACTIVE_CLASS);
	    var src = $(this).attr('src');
	    activeGalleryItem.attr('src', src);
	  });
	}();

/***/ },
/* 4 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});

	exports.default = function addToBasket() {
	  var addItemBtn = $('#shopItemOrderBtn');
	  var body = $('body');

	  addItemBtn.on('click', function () {
	    body.addClass('dialog-enabled').append('\n      <div class="backdrop"></div>\n      <div class="dialog">\n        <header class="dialog-header">\n          <button class="dialog-close">&times;</button>\n        </header>\n        <div class="dialog-body">\n        <img src="/assets/img/icons/basket-large.png" alt="" class="dialog-basketImg">\n          <p class="dialog-text">Product added to cart</p>\n          <div class="u-textCenter">\n            <a class="link dialog-button" href="shop.html">Continue shopping</a>\n            <a class="button dialog-button" href="#">GO TO BASKET</a>\n          </div>\n        </div>\n      </div>\n    ');
	  });

	  $(document).on('click', '.dialog-close', function () {
	    $('.dialog, .backdrop').remove();
	    body.removeClass('dialog-enabled');
	  });
	}();

/***/ },
/* 5 */
/***/ function(module, exports) {

	"use strict";

	Object.defineProperty(exports, "__esModule", {
	  value: true
	});

	exports.default = function initMap() {
	  var a = 'prostir';
	  var b = [{ featureType: "all", elementType: "all", stylers: [{ invert_lightness: true }, { saturation: -100 }] }];
	  var c = {
	    center: new google.maps.LatLng(50.414385, 30.519246),
	    zoom: 16,
	    panControl: false,
	    zoomControl: true,
	    scaleControl: true,
	    scrollwheel: false,
	    mapTypeControl: false,
	    mapTypeId: a
	  };
	  var d = new google.maps.Map(document.getElementById("map"), c);
	  var e = new google.maps.Marker({ position: c.center, map: d, title: "", icon: "/assets/img/map-marker.png" });
	  var f = { name: "Grayscale" };
	  var g = new google.maps.StyledMapType(b, f);
	  d.mapTypes.set(a, g);
	}();

/***/ }
/******/ ]);