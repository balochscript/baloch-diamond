/**
 * Baloch Diamond Theme - Main JavaScript
 *
 * @package Baloch_Diamond
 * @version 1.0.0
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

    function $$( selector ) {
        return document.querySelectorAll( selector );
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

            // Touch support
            heroSlider.addEventListener( 'touchstart', function( e ) {
                slider.touchStartX = e.changedTouches[0].screenX;
            }, { passive: true } );

            heroSlider.addEventListener( 'touchend', function( e ) {
                var diff = slider.touchStartX - e.changedTouches[0].screenX;
                if ( Math.abs( diff ) > 50 ) {
                    slider.change( diff > 0 ? 1 : -1 );
                }
            }, { passive: true } );

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
            var settingsBtn = $( '#menuSettingsOpen' );

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

            // Settings from mobile menu
            if ( settingsBtn ) {
                settingsBtn.addEventListener( 'click', function( e ) {
                    e.preventDefault();
                    mobileMenu.close();
                    setTimeout( function() {
                        settingsPanel.open();
                    }, 300 );
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
                // Fallback: just show "press enter to search"
                results.innerHTML = '<p style="text-align:center;color:var(--text-muted);padding:30px 0;font-size:0.9rem">' +
                    'Press Enter to search...' +
                    '</p>';
                return;
            }

            // Show loading
            results.innerHTML = '<p style="text-align:center;color:var(--text-muted);padding:30px 0">' +
                '<span style="display:inline-block;width:20px;height:20px;border:2px solid var(--border);border-top-color:var(--color-primary);border-radius:50%;animation:spin 0.6s linear infinite"></span>' +
                '</p>';

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
            .then( function( response ) {
                return response.json();
            } )
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
                    var noResultsText = ( typeof bdData !== 'undefined' && bdData.i18n && bdData.i18n.noResults )
                        ? bdData.i18n.noResults
                        : 'No results found for';

                    results.innerHTML = '<p style="text-align:center;color:var(--text-muted);padding:40px 0">' +
                        noResultsText + ' "' + search.escapeHtml( query ) + '"</p>';
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

            var lastScroll = 0;

            window.addEventListener( 'scroll', function() {
                var scrollY = window.pageYOffset || document.documentElement.scrollTop;

                // Add/remove scrolled class
                if ( scrollY > 50 ) {
                    header.classList.add( 'scrolled' );
                } else {
                    header.classList.remove( 'scrolled' );
                }

                lastScroll = scrollY;
            }, { passive: true } );
        }
    };


    // ================================================================
    //  7. SETTINGS PANEL (Disabled in favor of WordPress Customizer)
    // ================================================================
    var settingsPanel = {
        init: function() {},
        open: function() {},
        close: function() {},
        updateColors: function() {},
        loadSavedColors: function() {}
    };

    // Make open accessible globally (for menu button)
    window.bdOpenSettings = function() {
        settingsPanel.open();
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
            .then( function( response ) {
                return response.json();
            } )
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
                    settingsPanel.close();
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
    //  15. BACK TO TOP (Optional Enhancement)
    // ================================================================
    var backToTop = {

        init: function() {
            // The theme toggle button is at bottom-left
            // We can use the logo click as back-to-top on front page
            var logo = $( '.site-logo' );

            if ( logo && document.body.classList.contains( 'is-front-page' ) ) {
                logo.addEventListener( 'click', function( e ) {
                    // Only if already on front page
                    if ( window.location.pathname === '/' ||
                         window.location.pathname === window.location.pathname ) {
                        // Let the default link work, but also scroll to top
                    }
                } );
            }
        }
    };


    // ================================================================
    //  16. FRONTEND COLOR SWITCHER (Proposal 1)
    // ================================================================
    var frontendSwitcher = {
        init: function() {
            var toggleBtn = $( '#switcherToggleBtn' );
            var switcher  = $( '#floatingSwitcher' );
            var dots      = $$( '.switcher-color-dot' );
            var resetBtn  = $( '#resetSwitcherBtn' );

            if ( ! toggleBtn || ! switcher ) return;

            // Toggle switcher visibility
            toggleBtn.addEventListener( 'click', function( e ) {
                e.stopPropagation();
                switcher.classList.toggle( 'active' );
            } );

            // Close switcher on click outside
            document.addEventListener( 'click', function( e ) {
                if ( ! switcher.contains( e.target ) && e.target !== toggleBtn ) {
                    switcher.classList.remove( 'active' );
                }
            } );

            // Color dots click logic
            dots.forEach( function( dot ) {
                dot.addEventListener( 'click', function() {
                    var primary   = this.getAttribute( 'data-primary' );
                    var secondary = this.getAttribute( 'data-secondary' );

                    // Remove active from all dots
                    dots.forEach( function( d ) { d.classList.remove( 'active' ); } );
                    this.classList.add( 'active' );

                    // Apply styles
                    document.documentElement.style.setProperty( '--color-primary', primary, 'important' );
                    document.documentElement.style.setProperty( '--color-secondary', secondary, 'important' );
                    document.documentElement.style.setProperty(
                        '--gradient',
                        'linear-gradient(135deg, ' + primary + ', ' + secondary + ')',
                        'important'
                    );
                    document.documentElement.style.setProperty(
                        '--gradient-reverse',
                        'linear-gradient(135deg, ' + secondary + ', ' + primary + ')',
                        'important'
                    );

                    // Save to localStorage
                    localStorage.setItem( 'bd_temp_primary', primary );
                    localStorage.setItem( 'bd_temp_secondary', secondary );
                } );
            } );

            // Reset button click
            if ( resetBtn ) {
                resetBtn.addEventListener( 'click', function() {
                    document.documentElement.style.removeProperty( '--color-primary' );
                    document.documentElement.style.removeProperty( '--color-secondary' );
                    document.documentElement.style.removeProperty( '--gradient' );
                    document.documentElement.style.removeProperty( '--gradient-reverse' );

                    dots.forEach( function( d ) { d.classList.remove( 'active' ); } );
                    if ( dots[0] ) dots[0].classList.add( 'active' );

                    localStorage.removeItem( 'bd_temp_primary' );
                    localStorage.removeItem( 'bd_temp_secondary' );
                    showNotify( 'Reset to Admin Colors!' );
                } );
            }

            // Load temporary colors on page load if set
            var tempPrimary   = localStorage.getItem( 'bd_temp_primary' );
            var tempSecondary = localStorage.getItem( 'bd_temp_secondary' );

            if ( tempPrimary && tempSecondary ) {
                document.documentElement.style.setProperty( '--color-primary', tempPrimary, 'important' );
                document.documentElement.style.setProperty( '--color-secondary', tempSecondary, 'important' );
                document.documentElement.style.setProperty(
                    '--gradient',
                    'linear-gradient(135deg, ' + tempPrimary + ', ' + tempSecondary + ')',
                    'important'
                );
                document.documentElement.style.setProperty(
                    '--gradient-reverse',
                    'linear-gradient(135deg, ' + tempSecondary + ', ' + tempPrimary + ')',
                    'important'
                );

                // Set active dot
                dots.forEach( function( d ) {
                    var p = d.getAttribute( 'data-primary' );
                    if ( p === tempPrimary ) {
                        dots.forEach( function( other ) { other.classList.remove( 'active' ); } );
                        d.classList.add( 'active' );
                    }
                } );
            }
        }
    };

    // ================================================================
    //  17. SKELETON LOADER (Proposal 6)
    // ================================================================
    var skeletonLoader = {
        init: function() {
            var cards = $$( '.project-card, .post-card, .product-card' );
            if ( cards.length === 0 ) return;

            // Simple transition out after a brief moment to simulate elegant skeletal placeholder transitions
            setTimeout( function() {
                cards.forEach( function( card ) {
                    card.style.transition = 'opacity 0.4s ease';
                    card.style.opacity = '1';
                } );
            }, 800 );
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
        settingsPanel.init();
        newsletter.init();
        scrollAnimations.init();
        keyboard.init();
        smoothScroll.init();
        lazyLoad.init();
        backToTop.init();
        frontendSwitcher.init();
        skeletonLoader.init();

    } );

} )();
