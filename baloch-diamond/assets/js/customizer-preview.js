/**
 * Customizer Live Preview
 *
 * @package Baloch_Diamond
 */

( function( $ ) {

    // Primary Color
    wp.customize( 'bd_primary_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty( '--color-primary', newval );
            document.documentElement.style.setProperty(
                '--gradient',
                'linear-gradient(135deg, ' + newval + ', ' + wp.customize( 'bd_secondary_color' ).get() + ')'
            );
        } );
    } );

    // Secondary Color
    wp.customize( 'bd_secondary_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty( '--color-secondary', newval );
            document.documentElement.style.setProperty(
                '--gradient',
                'linear-gradient(135deg, ' + wp.customize( 'bd_primary_color' ).get() + ', ' + newval + ')'
            );
        } );
    } );

} )( jQuery );