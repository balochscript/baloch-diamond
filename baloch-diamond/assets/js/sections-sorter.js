/**
 * Baloch Diamond — Sections Sorter Customizer Control (Multi-Zone)
 *
 * Handles drag-to-reorder, drag-between-columns (Left / Main / Right)
 * and eye-toggle for the bd_sections_layout setting.
 * Runs inside the WordPress Customizer panel (wp-admin side only).
 *
 * Locked sections (data-locked="1") can be reordered inside the main
 * column but can never be dropped into a sidebar zone.
 *
 * Hardened init:
 *  - Waits until jQuery UI Sortable is actually available (retries).
 *  - Re-initialises whenever the Customizer section is expanded.
 *  - Falls back to classic single-list mode if the multi-zone markup
 *    is not present (e.g. cached/older control HTML).
 *
 * Dependencies: jquery-ui-sortable, customize-controls
 *
 * @package Baloch_Diamond
 * @version 1.3.2
 */

( function( $, api ) {
    'use strict';

    var EYE_ON  = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
    var EYE_OFF = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';

    /**
     * Read all zone lists of a control and write the combined
     * layout JSON back to the hidden input + Customizer setting.
     *
     * @param {jQuery} $root     The .bd-sorter-zones wrapper (or a legacy list's parent).
     * @param {string} settingId The WP Customize setting ID.
     */
    function syncValue( $root, settingId ) {
        var items = [];

        $root.find( '.bd-sorter-list' ).each( function() {
            var zone = $( this ).data( 'zone' ) || 'main';

            $( this ).find( '.bd-sorter-item' ).each( function() {
                items.push( {
                    key:     $( this ).data( 'key' ),
                    visible: $( this ).data( 'visible' ) === 1 || $( this ).data( 'visible' ) === '1',
                    zone:    zone,
                } );
            } );
        } );

        var json = JSON.stringify( items );

        // Update hidden input
        $( '#' + settingId ).val( json );

        // Notify WP Customizer so it marks as "unsaved"
        if ( api && api( settingId ) ) {
            api( settingId ).set( json );
        }
    }

    /**
     * Show/hide the "drop here" placeholder text of sidebar lists
     * depending on whether they contain items.
     *
     * @param {jQuery} $zones The .bd-sorter-zones wrapper.
     */
    function refreshEmptyHints( $zones ) {
        $zones.find( '.bd-sorter-list' ).each( function() {
            var $list   = $( this );
            var zone    = $list.data( 'zone' );
            var isEmpty = $list.find( '.bd-sorter-item' ).length === 0;
            var $hint   = $list.find( '.bd-sorter-empty' );

            if ( zone === 'main' || ! zone ) {
                $hint.remove();
                return;
            }

            if ( isEmpty && ! $hint.length ) {
                $list.append(
                    '<li class="bd-sorter-empty">' +
                    ( window.bdSorterL10n && window.bdSorterL10n.dropHere
                        ? window.bdSorterL10n.dropHere
                        : 'Drop sections here to activate this sidebar' ) +
                    '</li>'
                );
            } else if ( ! isEmpty ) {
                $hint.remove();
            }
        } );
    }

    /**
     * Attach the eye-toggle click handler (works for both markups).
     *
     * @param {jQuery} $root     Wrapper element to delegate from.
     * @param {string} settingId Setting ID.
     */
    function bindEyeToggle( $root, settingId ) {
        $root.on( 'click', '.bd-sorter-toggle', function() {
            var $item        = $( this ).closest( '.bd-sorter-item' );
            var isNowVisible = $item.data( 'visible' ) !== 1 && $item.data( 'visible' ) !== '1';

            if ( isNowVisible ) {
                $item.data( 'visible', '1' );
                $item.removeClass( 'is-hidden' );
                $( this ).html( EYE_ON );
                $( this ).attr( 'title', 'Click to hide' );
            } else {
                $item.data( 'visible', '0' );
                $item.addClass( 'is-hidden' );
                $( this ).html( EYE_OFF );
                $( this ).attr( 'title', 'Click to show' );
            }

            syncValue( $root, settingId );
        } );
    }

    /**
     * Initialise a MULTI-ZONE sorter control (.bd-sorter-zones markup).
     *
     * @param {jQuery} $zones The .bd-sorter-zones wrapper.
     */
    function initZonesSorter( $zones ) {
        if ( $zones.data( 'bd-sorter-ready' ) ) {
            return;
        }
        $zones.data( 'bd-sorter-ready', true );

        var settingId = $zones.data( 'setting-id' );
        var $lists    = $zones.find( '.bd-sorter-list' );

        $lists.sortable( {
            connectWith: $lists,
            handle:      '.bd-sorter-handle',
            items:       '.bd-sorter-item',           // ignore the "empty" hint rows
            cursor:      'grabbing',
            placeholder: 'bd-sorter-item ui-sortable-placeholder',
            forcePlaceholderSize: true,
            tolerance:   'pointer',

            start: function( event, ui ) {
                var isLocked = ui.item.data( 'locked' ) === 1 || ui.item.data( 'locked' ) === '1';

                // Highlight only the zones this item may be dropped into
                $lists.each( function() {
                    var zone = $( this ).data( 'zone' );
                    if ( ! isLocked || zone === 'main' ) {
                        $( this ).addClass( 'bd-drop-active' );
                    }
                } );
            },

            stop: function() {
                $lists.removeClass( 'bd-drop-active' );
                refreshEmptyHints( $zones );
                syncValue( $zones, settingId );
            },

            receive: function( event, ui ) {
                var $target  = $( this );
                var zone     = $target.data( 'zone' );
                var isLocked = ui.item.data( 'locked' ) === 1 || ui.item.data( 'locked' ) === '1';

                // Locked sections may only live inside the main column —
                // bounce them back where they came from.
                if ( isLocked && zone !== 'main' ) {
                    $( ui.sender ).sortable( 'cancel' );
                }
            },

            update: function( event, ui ) {
                if ( this === ui.item.parent()[0] ) {
                    refreshEmptyHints( $zones );
                    syncValue( $zones, settingId );
                }
            },
        } );

        bindEyeToggle( $zones, settingId );
    }

    /**
     * Initialise a LEGACY single-list sorter control (old markup:
     * one .bd-sorter-list with id "bd-sorter-list-{settingId}" and
     * no .bd-sorter-zones wrapper). Order + visibility only.
     *
     * @param {jQuery} $list The legacy <ul> element.
     */
    function initLegacySorter( $list ) {
        if ( $list.data( 'bd-sorter-ready' ) ) {
            return;
        }
        $list.data( 'bd-sorter-ready', true );

        var settingId = ( $list.attr( 'id' ) || '' ).replace( 'bd-sorter-list-', '' );
        if ( ! settingId ) {
            return;
        }

        $list.sortable( {
            handle:      '.bd-sorter-handle',
            items:       '.bd-sorter-item',
            axis:        'y',
            cursor:      'grabbing',
            placeholder: 'bd-sorter-item ui-sortable-placeholder',
            forcePlaceholderSize: true,
            tolerance:   'pointer',
            update: function() {
                syncValue( $list.parent(), settingId );
            },
        } );

        bindEyeToggle( $list.parent(), settingId );
    }

    /**
     * Find and initialise every sorter control on the page.
     * Safe to call repeatedly.
     */
    function initSorters() {
        // jQuery UI Sortable might not be ready yet — bail, the
        // retry loop below will call us again.
        if ( typeof $.fn.sortable !== 'function' ) {
            return false;
        }

        try {
            // New multi-zone markup
            $( '.bd-sorter-zones' ).each( function() {
                initZonesSorter( $( this ) );
            } );

            // Legacy single-list markup (only when NOT inside a zones wrapper)
            $( '.bd-sorter-list' ).each( function() {
                if ( ! $( this ).closest( '.bd-sorter-zones' ).length ) {
                    initLegacySorter( $( this ) );
                }
            } );
        } catch ( err ) {
            if ( window.console && console.warn ) {
                console.warn( 'BD Sections Sorter init failed:', err );
            }
        }

        return true;
    }

    /**
     * Retry init until jQuery UI is available and controls are rendered.
     * Runs up to 40 times (10 seconds) — covers slow admin loads.
     */
    function initWithRetry() {
        var tries = 0;
        var timer = setInterval( function() {
            tries++;
            var ok = initSorters();
            var found = $( '.bd-sorter-zones, .bd-sorter-list' ).length > 0;
            if ( ( ok && found ) || tries >= 40 ) {
                clearInterval( timer );
            }
        }, 250 );
    }

    // Run on Customizer ready
    $( document ).ready( function() {
        initWithRetry();

        // Also run whenever a section/panel is expanded (handles lazy-rendered controls)
        if ( api && api.section ) {
            api.section.bind( 'add', function( section ) {
                section.expanded.bind( function( expanded ) {
                    if ( expanded ) {
                        setTimeout( initSorters, 100 );
                    }
                } );
            } );

            // Sections that already exist before our handler was bound
            api.section.each( function( section ) {
                section.expanded.bind( function( expanded ) {
                    if ( expanded ) {
                        setTimeout( initSorters, 100 );
                    }
                } );
            } );
        }
    } );

} )( jQuery, wp.customize );
