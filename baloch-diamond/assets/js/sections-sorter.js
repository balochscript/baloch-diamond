/**
 * Baloch Diamond — Sections Sorter Customizer Control
 *
 * Handles drag-to-reorder and eye-toggle for the bd_sections_layout setting.
 * Runs inside the WordPress Customizer panel (wp-admin side only).
 *
 * Dependencies: jquery-ui-sortable, customize-controls
 *
 * @package Baloch_Diamond
 * @version 1.1.2
 */

( function( $, api ) {
    'use strict';

    /**
     * Read the current sorted list and write it back to the hidden input,
     * then notify the Customizer that the setting changed.
     *
     * @param {jQuery} $list  The <ul> element.
     * @param {string} settingId  The WP Customize setting ID.
     */
    function syncValue( $list, settingId ) {
        var items = [];

        $list.find( '.bd-sorter-item' ).each( function() {
            items.push( {
                key:     $( this ).data( 'key' ),
                visible: $( this ).data( 'visible' ) === 1 || $( this ).data( 'visible' ) === '1',
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
     * Initialise all Sorter controls found on the page.
     * Called on customize-ready and after any control added dynamically.
     */
    function initSorters() {
        $( '.bd-sorter-list' ).each( function() {
            var $list = $( this );

            // Avoid double-init
            if ( $list.data( 'bd-sorter-ready' ) ) {
                return;
            }
            $list.data( 'bd-sorter-ready', true );

            // Extract setting ID from the list's id attribute:
            //   "bd-sorter-list-bd_sections_layout"  →  "bd_sections_layout"
            var settingId = $list.attr( 'id' ).replace( 'bd-sorter-list-', '' );

            // ---- Drag to reorder ----
            $list.sortable( {
                handle:      '.bd-sorter-handle',
                axis:        'y',
                cursor:      'grabbing',
                placeholder: 'bd-sorter-item ui-sortable-placeholder',
                forcePlaceholderSize: true,
                tolerance:   'pointer',
                update: function() {
                    syncValue( $list, settingId );
                },
            } );

            // ---- Eye toggle ----
            $list.on( 'click', '.bd-sorter-toggle', function() {
                var $item    = $( this ).closest( '.bd-sorter-item' );
                var isNowVisible = $item.data( 'visible' ) !== 1 && $item.data( 'visible' ) !== '1';

                // Eye SVG icons
                var eyeOn  = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
                var eyeOff = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';

                if ( isNowVisible ) {
                    $item.data( 'visible', '1' );
                    $item.removeClass( 'is-hidden' );
                    $( this ).html( eyeOn );
                    $( this ).attr( 'title', 'Click to hide' );
                } else {
                    $item.data( 'visible', '0' );
                    $item.addClass( 'is-hidden' );
                    $( this ).html( eyeOff );
                    $( this ).attr( 'title', 'Click to show' );
                }

                syncValue( $list, settingId );
            } );
        } );
    }

    // Run on Customizer ready
    $( document ).ready( function() {
        // Slight delay to ensure all controls are rendered
        setTimeout( initSorters, 300 );

        // Also run whenever a section/panel is expanded (handles lazy-rendered controls)
        if ( api && api.section ) {
            api.section.bind( 'add', function( section ) {
                section.expanded.bind( function( expanded ) {
                    if ( expanded ) {
                        setTimeout( initSorters, 100 );
                    }
                } );
            } );
        }
    } );

} )( jQuery, wp.customize );
