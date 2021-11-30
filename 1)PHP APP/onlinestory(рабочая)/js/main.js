/* libs start */
;
(function() {
    var canUseWebP = function() {
        var elem = document.createElement('canvas');

        if (!!(elem.getContext && elem.getContext('2d'))) {
            // was able or not to get WebP representation
            return elem.toDataURL('image/webp').indexOf('data:image/webp') == 0;
        }

        // very old browser like IE 8, canvas not supported
        return false;
    };

    var isWebpSupported = canUseWebP();

    if (isWebpSupported === false) {
        var lazyItems = document.querySelectorAll('[data-src-replace-webp]');

        for (var i = 0; i < lazyItems.length; i += 1) {
            var item = lazyItems[i];

            var dataSrcReplaceWebp = item.getAttribute('data-src-replace-webp');
            if (dataSrcReplaceWebp !== null) {
                item.setAttribute('data-src', dataSrcReplaceWebp);
            }
        }
    }

    var lazyLoadInstance = new LazyLoad({
        elements_selector: ".lazy"
    });
})();
/* libs end */

/* myLib start */
;
(function() {
    window.myLib = {};

    window.myLib.body = document.querySelector('body');

    window.myLib.closestAttr = function(item, attr) {
        var node = item;

        while (node) {
            var attrValue = node.getAttribute(attr);
            if (attrValue) {
                return attrValue;
            }

            node = node.parentElement;
        }

        return null;
    };

    window.myLib.closestItemByClass = function(item, className) {
        var node = item;

        while (node) {
            if (node.classList.contains(className)) {
                return node;
            }

            node = node.parentElement;
        }

        return null;
    };

    window.myLib.toggleScroll = function() {
        myLib.body.classList.toggle('no-scroll');
    };
})();
/* myLib end */

/* header start */
;
(function() {
    if (window.matchMedia('(max-width: 992px)').matches) {
        return;
    }

    var headerPage = document.querySelector('.header-page');

    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 0) {
            headerPage.classList.add('is-active');
        } else {
            headerPage.classList.remove('is-active');
        }
    });
})();
/* header end */



/* scrollTo start */
;
(function() {


    var scroll = function(target) {
        var targetTop = target.getBoundingClientRect().top;
        var scrollTop = window.pageYOffset;
        var targetOffsetTop = targetTop + scrollTop;
        var headerOffset = document.querySelector('.header-page').clientHeight;

        window.scrollTo(0, targetOffsetTop - headerOffset);
    }

    myLib.body.addEventListener('click', function(e) {
        var target = e.target;
        var scrollToItemClass = myLib.closestAttr(target, 'data-scroll-to');

        if (scrollToItemClass === null) {
            return;
        }

        e.preventDefault();
        var scrollToItem = document.querySelector('.' + scrollToItemClass);

        if (scrollToItem) {
            scroll(scrollToItem);
        }
    });
})();
/* scrollTo end */

/* catalog start */
;
(function() {
    var catalogSection = document.querySelector('.section-catalog');

    if (catalogSection === null) {
        return;
    }

    var removeChildren = function(item) {
        while (item.firstChild) {
            item.removeChild(item.firstChild);
        }
    };

    var updateChildren = function(item, children) {
        removeChildren(item);
        for (var i = 0; i < children.length; i += 1) {
            item.appendChild(children[i]);
        }
    };

    var catalog = catalogSection.querySelector('.catalog');
    var catalogNav = catalogSection.querySelector('.catalog-nav');
    var catalogItems = catalogSection.querySelectorAll('.catalog__item');

    catalogNav.addEventListener('click', function(e) {
        var target = e.target;
        var item = myLib.closestItemByClass(target, 'catalog-nav__btn');

        if (item === null || item.classList.contains('is-active')) {
            return;
        }

        e.preventDefault();
        var filterValue = item.getAttribute('data-filter');
        var previousBtnActive = catalogNav.querySelector('.catalog-nav__btn.is-active');

        previousBtnActive.classList.remove('is-active');
        item.classList.add('is-active');

        if (filterValue === 'all') {
            updateChildren(catalog, catalogItems);
            return;
        }

        var filteredItems = [];
        for (var i = 0; i < catalogItems.length; i += 1) {
            var current = catalogItems[i];
            if (current.getAttribute('data-category') === filterValue) {
                filteredItems.push(current);
            }
        }

        updateChildren(catalog, filteredItems);
    });
})();
/* catalog end */