/**
 * Baloch Diamond Theme - Main JavaScript
 *
 * @package Baloch_Diamond
 * @version 1.1.2
 */

( function() {
    'use strict';

    // ================================================================
    //  UTILITY: DOM Ready
    // ================================================================
    function domReady( fn ) {
        if ( document.readyState === 'loading' ) {
            document.addEventListener( 'DOMContentLoaded', fn );
        } else {
            fn();
        }
    }

    // ================================================================
    //  UTILITY: Get Element
    // ================================================================
    function $( selector ) {
        return document.querySelector( selector );
    }

    // ================================================================
    //  UTILITY: Get Elements
    // ================================================================
    function $$( selector ) {
        return document.querySelectorAll( selector );
    }

    // ================================================================
    //  UTILITY: Build the Balochi-embroidered "bookmark" sale ribbon
    // ================================================================
    var bdBookmarkUidCounter = 0;
    function bdBuildBookmarkHTML( discount, size ) {
        bdBookmarkUidCounter++;
        var gradId    = 'bdBookmarkGradMain' + bdBookmarkUidCounter;
        var sizeClass = ( size === 'sm' ) ? ' bd-bookmark--sm' : '';
        return '<div class="bd-bookmark' + sizeClass + '" role="img" aria-label="' + discount + '% off">' +
            '<svg viewBox="0 0 52 76" xmlns="http://www.w3.org/2000/svg" focusable="false" aria-hidden="true">' +
                '<defs><linearGradient id="' + gradId + '" x1="0" y1="0" x2="0" y2="1">' +
                    '<stop offset="0%" stop-color="#f43f5e"/>' +
                    '<stop offset="55%" stop-color="#dc2626"/>' +
                    '<stop offset="100%" stop-color="#9f1239"/>' +
                '</linearGradient></defs>' +
                '<path d="M2,0 H50 V70 L26,52 L2,70 Z" fill="url(#' + gradId + ')"/>' +
                '<rect x="2" y="0" width="48" height="4" fill="#fbbf24"/>' +
                '<path d="M2,0 H50 V70 L26,52 L2,70 Z" fill="none" stroke="#fde68a" stroke-width="1.2" stroke-dasharray="3 2" opacity="0.9"/>' +
                '<g fill="none" stroke="#fde68a" stroke-width="1.1">' +
                    '<path d="M13,10 L16,14 L13,18 L10,14 Z"/>' +
                    '<path d="M26,10 L29,14 L26,18 L23,14 Z"/>' +
                    '<path d="M39,10 L42,14 L39,18 L36,14 Z"/>' +
                '</g>' +
                '<g fill="#38bdf8">' +
                    '<circle cx="13" cy="14" r="1.1"/>' +
                    '<circle cx="26" cy="14" r="1.1"/>' +
                    '<circle cx="39" cy="14" r="1.1"/>' +
                '</g>' +
                '<text x="26" y="38" text-anchor="middle" fill="#ffffff" font-size="14" font-weight="900" font-family="Arial, sans-serif">-' + discount + '%</text>' +
                '<text x="26" y="47" text-anchor="middle" fill="#fde68a" font-size="6" font-weight="700" letter-spacing="1.2" font-family="Arial, sans-serif">OFF</text>' +
            '</svg>' +
        '</div>';
    }


    // ================================================================
    //  1. NOTIFICATION SYSTEM
    // ================================================================
    var notifyTimer = null;

    function showNotify( text ) {
        var el   = $( '#notification' );
        var txt  = $( '#notificationText' );

        if ( ! el || ! txt ) return;

        txt.textContent = text;
        el.classList.add( 'show' );

        if ( notifyTimer ) {
            clearTimeout( notifyTimer );
        }

        notifyTimer = setTimeout( function() {
            el.classList.remove( 'show' );
        }, 3000 );
    }

    // Make globally available
    window.bdShowNotify = showNotify;


    // ================================================================
    //  2. HERO SLIDER
    // ================================================================
    var slider = {
        current: 0,
        total: 0,
        interval: null,
        delay: 5000,
        touchStartX: 0,

        init: function() {
            var heroSlider = $( '#heroSlider' );
            if ( ! heroSlider ) return;

            this.total = parseInt( heroSlider.getAttribute( 'data-total' ) ) || 0;

            if ( this.total <= 0 ) return;

            // Start autoplay
            this.startAutoplay();

            // Arrow buttons
            var prevBtn = $( '#sliderPrev' );
            var nextBtn = $( '#sliderNext' );

            if ( prevBtn ) {
                prevBtn.addEventListener( 'click', function() {
                    slider.change( -1 );
                } );
            }

            if ( nextBtn ) {
                nextBtn.addEventListener( 'click', function() {
                    slider.change( 1 );
                } );
            }

            // Dot buttons
            var dots = $$( '.slider-dot' );
            dots.forEach( function( dot ) {
                dot.addEventListener( 'click', function() {
                    var slideIndex = parseInt( this.getAttribute( 'data-slide' ) );
                    slider.goTo( slideIndex );
                    slider.resetAutoplay();
                } );
            } );

            // Touch + Mouse drag (Pointer Events API covers both)
            var pointerStartX = 0;
            var pointerMoved  = false;

            heroSlider.addEventListener( 'pointerdown', function( e ) {
                pointerStartX = e.clientX;
                pointerMoved  = false;
                heroSlider.setPointerCapture( e.pointerId );
            }, { passive: true } );

            heroSlider.addEventListener( 'pointermove', function( e ) {
                if ( Math.abs( e.clientX - pointerStartX ) > 8 ) {
                    pointerMoved = true;
                }
            }, { passive: true } );

            heroSlider.addEventListener( 'pointerup', function( e ) {
                if ( ! pointerMoved ) return;
                var diff = pointerStartX - e.clientX;
                if ( Math.abs( diff ) > 40 ) {
                    slider.change( diff > 0 ? 1 : -1 );
                    slider.resetAutoplay();
                }
            }, { passive: true } );

            // Prevent image ghost drag
            heroSlider.addEventListener( 'dragstart', function( e ) {
                e.preventDefault();
            } );

            // Pause on hover
            heroSlider.addEventListener( 'mouseenter', function() {
                slider.stopAutoplay();
            } );

            heroSlider.addEventListener( 'mouseleave', function() {
                slider.startAutoplay();
            } );
        },

        goTo: function( n ) {
            var slides = $$( '.slide' );
            var dots   = $$( '.slider-dot' );

            if ( slides.length === 0 ) return;

            // Wrap around
            if ( n >= this.total ) n = 0;
            if ( n < 0 ) n = this.total - 1;

            this.current = n;

            slides.forEach( function( s ) {
                s.classList.remove( 'active' );
            } );

            dots.forEach( function( d ) {
                d.classList.remove( 'active' );
            } );

            if ( slides[ this.current ] ) {
                slides[ this.current ].classList.add( 'active' );
            }

            if ( dots[ this.current ] ) {
                dots[ this.current ].classList.add( 'active' );
            }
        },

        change: function( dir ) {
            this.goTo( this.current + dir );
            this.resetAutoplay();
        },

        startAutoplay: function() {
            var self = this;

            if ( this.total <= 1 ) return;

            this.stopAutoplay();
            this.interval = setInterval( function() {
                self.goTo( self.current + 1 );
            }, this.delay );
        },

        stopAutoplay: function() {
            if ( this.interval ) {
                clearInterval( this.interval );
                this.interval = null;
            }
        },

        resetAutoplay: function() {
            this.stopAutoplay();
            this.startAutoplay();
        }
    };


    // ================================================================
    //  3. MOBILE MENU
    // ================================================================
    var mobileMenu = {

        init: function() {
            var openBtn    = $( '#menuOpen' );
            var closeBtn   = $( '#menuClose' );
            var overlay    = $( '#menuOverlay' );

            if ( openBtn ) {
                openBtn.addEventListener( 'click', function() {
                    mobileMenu.open();
                } );
            }

            if ( closeBtn ) {
                closeBtn.addEventListener( 'click', function() {
                    mobileMenu.close();
                } );
            }

            if ( overlay ) {
                overlay.addEventListener( 'click', function() {
                    mobileMenu.close();
                } );
            }

            // Close menu on menu item click (smooth scroll links)
            var menuItems = $$( '.mobile-menu .menu-item' );
            menuItems.forEach( function( item ) {
                item.addEventListener( 'click', function() {
                    var href = this.getAttribute( 'href' );
                    // Only close if it's a hash link on same page
                    if ( href && href.indexOf( '#' ) !== -1 ) {
                        mobileMenu.close();
                    }
                } );
            } );
        },

        open: function() {
            var menu    = $( '#mobileMenu' );
            var overlay = $( '#menuOverlay' );

            if ( menu ) menu.classList.add( 'active' );
            if ( overlay ) overlay.classList.add( 'active' );
            document.body.style.overflow = 'hidden';
        },

        close: function() {
            var menu    = $( '#mobileMenu' );
            var overlay = $( '#menuOverlay' );

            if ( menu ) menu.classList.remove( 'active' );
            if ( overlay ) overlay.classList.remove( 'active' );
            document.body.style.overflow = '';
        }
    };


    // ================================================================
    //  4. SEARCH OVERLAY
    // ================================================================
    var search = {

        debounceTimer: null,

        init: function() {
            var openBtn  = $( '#searchOpen' );
            var closeBtn = $( '#searchClose' );
            var input    = $( '#searchInput' );
            var form     = $( '#bdSearchForm' );

            if ( openBtn ) {
                openBtn.addEventListener( 'click', function() {
                    search.open();
                } );
            }

            if ( closeBtn ) {
                closeBtn.addEventListener( 'click', function() {
                    search.close();
                } );
            }

            // AJAX Search on typing
            if ( input ) {
                input.addEventListener( 'input', function() {
                    var query = this.value;
                    search.debounceSearch( query );
                } );
            }

            // Form submit (fallback to WordPress search)
            if ( form ) {
                form.addEventListener( 'submit', function( e ) {
                    var input = $( '#searchInput' );
                    if ( input && input.value.trim().length < 2 ) {
                        e.preventDefault();
                    }
                } );
            }
        },

        open: function() {
            var overlay = $( '#searchOverlay' );
            var input   = $( '#searchInput' );

            if ( overlay ) overlay.classList.add( 'active' );
            document.body.style.overflow = 'hidden';

            setTimeout( function() {
                if ( input ) input.focus();
            }, 300 );
        },

        close: function() {
            var overlay = $( '#searchOverlay' );
            var input   = $( '#searchInput' );
            var results = $( '#searchResults' );

            if ( overlay ) overlay.classList.remove( 'active' );
            document.body.style.overflow = '';

            if ( input ) input.value = '';
            if ( results ) results.innerHTML = '';
        },

        debounceSearch: function( query ) {
            var self = this;

            if ( this.debounceTimer ) {
                clearTimeout( this.debounceTimer );
            }

            this.debounceTimer = setTimeout( function() {
                self.doSearch( query );
            }, 300 );
        },

        doSearch: function( query ) {
            var results = $( '#searchResults' );

            if ( ! results ) return;

            if ( query.length < 2 ) {
                results.innerHTML = '';
                return;
            }

            // Check if bdData exists (WordPress localized data)
            if ( typeof bdData === 'undefined' ) {
                results.innerHTML = '<p style="text-align:center;color:var(--text-muted);padding:30px 0;font-size:0.9rem">Press Enter to search...</p>';
                return;
            }

            // Show loading
            results.innerHTML = '<p style="text-align:center;color:var(--text-muted);padding:30px 0"><span style="display:inline-block;width:20px;height:20px;border:2px solid var(--border);border-top-color:var(--color-primary);border-radius:50%;animation:spin 0.6s linear infinite"></span></p>';

            // AJAX request
            var formData = new FormData();
            formData.append( 'action', 'bd_search' );
            formData.append( 'nonce', bdData.nonce );
            formData.append( 'query', query );

            fetch( bdData.ajaxUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            } )
            .then( function( response ) { return response.json(); } )
            .then( function( data ) {
                if ( data.success && data.data.length > 0 ) {
                    var html = '';
                    data.data.forEach( function( item ) {
                        html += '<a href="' + item.url + '" class="search-result-item" style="text-decoration:none;color:var(--text)">';
                        html += '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px">';
                        html += '<strong style="font-size:0.95rem">' + search.escapeHtml( item.title ) + '</strong>';
                        html += '<span style="font-size:0.7rem;padding:3px 8px;border-radius:6px;background:var(--bg-alt);color:var(--text-muted)">' + search.escapeHtml( item.type ) + '</span>';
                        html += '</div>';
                        html += '<p style="font-size:0.85rem;color:var(--text-muted);margin:0">' + search.escapeHtml( item.desc ) + '</p>';
                        html += '</a>';
                    } );
                    results.innerHTML = html;
                } else {
                    var noResultsText = ( typeof bdData !== 'undefined' && bdData.i18n && bdData.i18n.noResults ) ? bdData.i18n.noResults : 'No results found for';
                    results.innerHTML = '<p style="text-align:center;color:var(--text-muted);padding:40px 0">' + noResultsText + ' "' + search.escapeHtml( query ) + '"</p>';
                }
            } )
            .catch( function() {
                results.innerHTML = '<p style="text-align:center;color:var(--text-muted);padding:30px 0">Search error. Press Enter to use standard search.</p>';
            } );
        },

        escapeHtml: function( str ) {
            var div = document.createElement( 'div' );
            div.appendChild( document.createTextNode( str ) );
            return div.innerHTML;
        }
    };


    // ================================================================
    //  5. THEME TOGGLE (Dark / Light)
    // ================================================================
    var themeToggle = {

        init: function() {
            var btn = $( '#themeToggle' );

            if ( ! btn ) return;

            // Load saved theme
            var saved = localStorage.getItem( 'bd_theme' );
            if ( saved ) {
                document.documentElement.setAttribute( 'data-theme', saved );
                this.updateIcons( saved );
            }

            var self = this;
            btn.addEventListener( 'click', function() {
                self.toggle();
            } );
        },

        toggle: function() {
            var html    = document.documentElement;
            var isDark  = html.getAttribute( 'data-theme' ) === 'dark';
            var newMode = isDark ? 'light' : 'dark';

            html.setAttribute( 'data-theme', newMode );
            localStorage.setItem( 'bd_theme', newMode );

            this.updateIcons( newMode );
        },

        updateIcons: function( mode ) {
            var sun  = $( '#sunIcon' );
            var moon = $( '#moonIcon' );

            if ( ! sun || ! moon ) return;

            if ( mode === 'dark' ) {
                sun.style.display  = 'inline-flex';
                moon.style.display = 'none';
            } else {
                sun.style.display  = 'none';
                moon.style.display = 'inline-flex';
            }
        }
    };


    // ================================================================
    //  6. HEADER SCROLL EFFECT
    // ================================================================
    var headerScroll = {

        init: function() {
            var header = $( '#siteHeader' );

            if ( ! header ) return;

            window.addEventListener( 'scroll', function() {
                var scrollY = window.pageYOffset || document.documentElement.scrollTop;

                // Add/remove scrolled class
                if ( scrollY > 50 ) {
                    header.classList.add( 'scrolled' );
                } else {
                    header.classList.remove( 'scrolled' );
                }
            }, { passive: true } );
        }
    };


    // ================================================================
    //  8. NEWSLETTER FORM (AJAX)
    // ================================================================
    var newsletter = {

        init: function() {
            var form = $( '#newsletterForm' );

            if ( ! form ) return;

            form.addEventListener( 'submit', function( e ) {
                e.preventDefault();
                newsletter.submit();
            } );
        },

        submit: function() {
            var emailInput = $( '#newsletterEmail' );
            var btn        = $( '#newsletterBtn' );

            if ( ! emailInput || ! btn ) return;

            var email = emailInput.value.trim();

            if ( ! email || ! newsletter.isValidEmail( email ) ) {
                showNotify( 'Please enter a valid email address.' );
                return;
            }

            // Check if bdData exists
            if ( typeof bdData === 'undefined' ) {
                showNotify( 'Thanks for subscribing!' );
                emailInput.value = '';
                return;
            }

            // Disable button
            var originalText = btn.textContent;
            btn.textContent = '...';
            btn.disabled = true;

            // AJAX request
            var formData = new FormData();
            formData.append( 'action', 'bd_subscribe' );
            formData.append( 'nonce', bdData.nonce );
            formData.append( 'email', email );

            fetch( bdData.ajaxUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            } )
            .then( function( response ) { return response.json(); } )
            .then( function( data ) {
                if ( data.success ) {
                    showNotify( data.data );
                    emailInput.value = '';
                } else {
                    showNotify( data.data || 'Something went wrong.' );
                }
            } )
            .catch( function() {
                showNotify( 'Network error. Please try again.' );
            } )
            .finally( function() {
                btn.textContent = originalText;
                btn.disabled = false;
            } );
        },

        isValidEmail: function( email ) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test( email );
        }
    };


    // ================================================================
    //  9. SCROLL ANIMATIONS (Intersection Observer)
    // ================================================================
    var scrollAnimations = {

        init: function() {
            if ( ! ( 'IntersectionObserver' in window ) ) return;

            var options = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            var observer = new IntersectionObserver( function( entries ) {
                entries.forEach( function( entry ) {
                    if ( entry.isIntersecting ) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve( entry.target );
                    }
                } );
            }, options );

            var animatedElements = $$(
                '.project-card, .post-card, .doc-card, .team-card'
            );

            animatedElements.forEach( function( el, i ) {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease ' + ( i % 4 * 0.1 ) + 's, transform 0.6s ease ' + ( i % 4 * 0.1 ) + 's';
                observer.observe( el );
            } );
        }
    };


    // ================================================================
    //  10. KEYBOARD SHORTCUTS
    // ================================================================
    var keyboard = {

        init: function() {
            document.addEventListener( 'keydown', function( e ) {

                // ESC key
                if ( e.key === 'Escape' ) {
                    search.close();
                    mobileMenu.close();
                }

                // "/" key to open search (when not in input)
                if ( e.key === '/' && ! keyboard.isInputFocused() ) {
                    var searchOverlay = $( '#searchOverlay' );
                    if ( searchOverlay && ! searchOverlay.classList.contains( 'active' ) ) {
                        e.preventDefault();
                        search.open();
                    }
                }

            } );
        },

        isInputFocused: function() {
            var active = document.activeElement;
            if ( ! active ) return false;

            var tag = active.tagName.toLowerCase();
            return ( tag === 'input' || tag === 'textarea' || tag === 'select' || active.isContentEditable );
        }
    };


    // ================================================================
    //  11. SMOOTH SCROLL FOR ANCHOR LINKS
    // ================================================================
    var smoothScroll = {

        init: function() {
            var links = $$( 'a[href*="#"]' );

            links.forEach( function( link ) {
                link.addEventListener( 'click', function( e ) {
                    var href = this.getAttribute( 'href' );

                    // Only handle hash links on same page
                    if ( ! href || href === '#' ) return;

                    // Check if it's same page
                    var hashIndex = href.indexOf( '#' );
                    if ( hashIndex === -1 ) return;

                    var hash = href.substring( hashIndex );
                    var path = href.substring( 0, hashIndex );

                    // If path is empty or matches current page
                    if ( path === '' || path === window.location.pathname || path === window.location.href.split( '#' )[0] ) {
                        var target = document.querySelector( hash );

                        if ( target ) {
                            e.preventDefault();

                            var headerHeight = 80;
                            var targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                            window.scrollTo( {
                                top: targetPosition,
                                behavior: 'smooth'
                            } );
                        }
                    }
                } );
            } );
        }
    };


    // ================================================================
    //  12. LOADING ANIMATION (Add spin keyframe)
    // ================================================================
    function addSpinKeyframe() {
        var style = document.createElement( 'style' );
        style.textContent = '@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }';
        document.head.appendChild( style );
    }


    // ================================================================
    //  13. ACCESSIBILITY: Focus Trap for Modals
    // ================================================================
    var focusTrap = {

        trapElement: null,

        trap: function( element ) {
            this.trapElement = element;

            var focusable = element.querySelectorAll(
                'a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
            );

            if ( focusable.length === 0 ) return;

            var first = focusable[0];
            var last  = focusable[ focusable.length - 1 ];

            element.addEventListener( 'keydown', function( e ) {
                if ( e.key !== 'Tab' ) return;

                if ( e.shiftKey ) {
                    if ( document.activeElement === first ) {
                        e.preventDefault();
                        last.focus();
                    }
                } else {
                    if ( document.activeElement === last ) {
                        e.preventDefault();
                        first.focus();
                    }
                }
            } );

            first.focus();
        }
    };


    // ================================================================
    //  14. LAZY LOAD ENHANCEMENT
    // ================================================================
    var lazyLoad = {

        init: function() {
            // Add loading="lazy" to images that don't have it
            var images = $$( 'img:not([loading])' );

            images.forEach( function( img ) {
                // Skip small images and slider images
                if ( img.closest( '.slide' ) || img.closest( '.site-header' ) ) return;
                img.setAttribute( 'loading', 'lazy' );
            } );
        }
    };


    // ================================================================
    //  15. SKELETON SHIMMER LOADING
    // ================================================================
    var skeletonLoader = {
        init: function() {
            var enabled = document.body.classList.contains( 'skeleton-enabled' );
            if ( ! enabled ) return;

            var cards = $$( '.project-card, .post-card, .doc-card, .team-card, .shop-product-card' );

            cards.forEach( function( card, i ) {
                if ( card.querySelector( 'img' ) && ! card.dataset.forceSkeleton ) return;

                card.classList.add( 'skeleton-card' );

                var shimmer = document.createElement( 'div' );
                shimmer.className = 'skeleton-shimmer';
                shimmer.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;z-index:2;pointer-events:none;border-radius:20px;';

                card.style.position = 'relative';
                card.appendChild( shimmer );

                setTimeout( function() {
                    if ( shimmer && shimmer.parentNode ) shimmer.parentNode.removeChild( shimmer );
                    card.classList.remove( 'skeleton-card' );
                }, 900 + ( i * 120 ) );
            } );
        }
    };


    // ================================================================
    //  16. BACK TO TOP (Optional Enhancement)
    // ================================================================
    var backToTop = {

        init: function() {
            var logo = $( '.site-logo' );

            if ( logo && document.body.classList.contains( 'is-front-page' ) ) {
                logo.addEventListener( 'click', function() {
                    // Smooth scroll top fallback handled by anchor standard
                } );
            }
        }
    };


    // ================================================================
    //  17. SINGLE FEATURED PRODUCT MULTI-SLIDER (WooCommerce Single Mode)
    // ================================================================
    var singleProductSlider = {
        init: function() {
            var prevBtn = $( '#singlePrev' );
            var nextBtn = $( '#singleNext' );
            var container = $( '#shopSingleShowcase' );

            if ( ! prevBtn || ! nextBtn || ! container ) return;

            // Load products from JSON tag
            var jsonEl = $( '#bd-single-products-json' );
            if ( ! jsonEl ) return;

            try {
                var products = JSON.parse( jsonEl.textContent );
                if ( ! products || products.length <= 1 ) return;

                var currentIndex = 0;

                function updateCard(index) {
                    var prod = products[index];

                    // Select elements
                    var imgCol = container.querySelector( 'div:first-child' );
                    var infoCol = container.querySelector( 'div:last-child' );

                    if ( ! imgCol || ! infoCol ) return;

                    // Update Image
                    if ( prod.image ) {
                        imgCol.innerHTML = '';
                        var img = document.createElement( 'img' );
                        img.src = prod.image;
                        img.alt = prod.title;
                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.objectFit = 'cover';
                        imgCol.appendChild( img );
                    } else {
                        imgCol.innerHTML = '<div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;"><div style="opacity:0.15; transform:scale(2);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="48" height="48"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></div></div>';
                    }

                    // Add the Balochi-embroidered bookmark sale badge back if applicable
                    if ( prod.on_sale && prod.discount > 0 ) {
                        imgCol.insertAdjacentHTML( 'beforeend', bdBuildBookmarkHTML( prod.discount, 'md' ) );
                    }

                    // Update Title
                    var titleEl = infoCol.querySelector( 'h3' );
                    if ( titleEl ) titleEl.textContent = prod.title;

                    // Update Desc
                    var descEl = infoCol.querySelector( 'p' );
                    if ( descEl ) descEl.textContent = prod.desc;

                    // Update Price
                    var priceEl = infoCol.querySelector( 'div:nth-child(4)' );
                    if ( priceEl ) priceEl.innerHTML = prod.price;

                    // Update Rating Stars
                    var ratingEl = infoCol.querySelector( 'div:first-child' );
                    if ( ratingEl ) {
                        ratingEl.innerHTML = '';
                        var fullStars = Math.floor( prod.rating );
                        for ( var s = 1; s <= 5; s++ ) {
                            ratingEl.innerHTML += s <= fullStars ? '★' : '☆';
                        }
                    }

                    // Update Buy Link
                    var linkBtn = infoCol.querySelector( '.btn-gradient' );
                    if ( linkBtn ) linkBtn.href = prod.link;
                }

                nextBtn.addEventListener( 'click', function() {
                    currentIndex = ( currentIndex + 1 ) % products.length;
                    updateCard( currentIndex );
                } );

                prevBtn.addEventListener( 'click', function() {
                    currentIndex = ( currentIndex - 1 + products.length ) % products.length;
                    updateCard( currentIndex );
                } );

            } catch ( e ) {
                console.error( "JSON Parse error on single mode slider", e );
            }
        }
    };


    // ================================================================
    //  18. BLOG LOAD MORE (AJAX)
    // ================================================================
    var blogLoadMore = {
        init: function() {
            var btn = document.getElementById( 'bd-loadmore-btn' );
            if ( ! btn ) return;
            btn.addEventListener( 'click', function() { blogLoadMore.load(); } );
        },
        load: function() {
            var btn    = document.getElementById( 'bd-loadmore-btn' );
            var grid   = document.getElementById( 'bd-blog-grid' );
            var status = document.querySelector( '.bd-loadmore-status' );
            if ( ! btn || ! grid || typeof bdData === 'undefined' ) return;

            var page         = parseInt( btn.getAttribute( 'data-page' ) ) || 1;
            var perPage      = parseInt( btn.getAttribute( 'data-per-page' ) ) || 6;
            var initialCount = parseInt( btn.getAttribute( 'data-initial-count' ) ) || 6;
            var loadingText  = btn.getAttribute( 'data-loading-text' ) || 'Loading...';
            var nomoreText   = btn.getAttribute( 'data-nomore-text' ) || 'No more posts';
            var archiveUrl   = btn.getAttribute( 'data-archive-url' ) || '';
            var originalHTML = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<span style="opacity:0">' + loadingText + '</span><span style="position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);width:20px;height:20px;border:2.5px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:bd-spin 0.6s linear infinite"></span>';

            var fd = new FormData();
            fd.append( 'action',         'bd_loadmore' );
            fd.append( 'nonce',          bdData.nonce );
            fd.append( 'page',           page );
            fd.append( 'per_page',       perPage );
            fd.append( 'initial_count',  initialCount );

            fetch( bdData.ajaxUrl, { method: 'POST', body: fd, credentials: 'same-origin' } )
            .then( function( r ) { return r.json(); } )
            .then( function( data ) {
                if ( data.success && data.data.html ) {
                    grid.insertAdjacentHTML( 'beforeend', data.data.html );
                    btn.setAttribute( 'data-page', page + 1 );

                    if ( status ) {
                        status.style.display = 'block';
                        status.textContent = ( data.data.shown || 0 ) + ' / ' + ( data.data.total || 0 );
                    }

                    if ( ! data.data.has_more ) {
                        var wrap = btn.parentNode;
                        btn.remove();
                        var msg = document.createElement( 'div' );
                        msg.className = 'bd-nomore-msg';
                        msg.textContent = nomoreText;
                        wrap.appendChild( msg );
                        if ( archiveUrl ) {
                            var link = document.createElement( 'a' );
                            link.href = archiveUrl;
                            link.className = 'bd-blog-archive-link';
                            link.textContent = bdData.i18n && bdData.i18n.viewArchive ? bdData.i18n.viewArchive : 'View Full Archive';
                            wrap.appendChild( link );
                        }
                        if ( status ) status.style.display = 'none';
                    } else {
                        btn.disabled = false;
                        btn.innerHTML = originalHTML;
                    }
                } else {
                    btn.disabled = false;
                    btn.innerHTML = originalHTML;
                }
            } )
            .catch( function() {
                btn.disabled = false;
                btn.innerHTML = originalHTML;
                if ( status ) { status.style.display = 'block'; status.textContent = 'Error. Try again.'; }
            } );
        }
    };


    // ================================================================
    //  INITIALIZE EVERYTHING
    // ================================================================
    domReady( function() {

        // Add spin animation
        addSpinKeyframe();

        // Initialize all modules
        slider.init();
        mobileMenu.init();
        search.init();
        themeToggle.init();
        headerScroll.init();
        newsletter.init();
        scrollAnimations.init();
        keyboard.init();
        smoothScroll.init();
        lazyLoad.init();
        backToTop.init();
        skeletonLoader.init();
        singleProductSlider.init();
        blogLoadMore.init();
    } );

} )();
