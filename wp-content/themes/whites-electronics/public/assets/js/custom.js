/*****
Custom
******/
whitesElectronics = {

    init: function() {

        whitesElectronics.setupLocaleLightbox();

        $( window ).on( 'resize', whitesElectronics.debounce( function( ) {}, 500 ) );

        $( window ).load( function() {
        } );
    },

    setupLocale: function() {
        var vars = [], hash;
        var hashes = window.location.href.slice( window.location.href.indexOf( '?' ) + 1 ).split( '&' );
        for( var i = 0; i < hashes.length; i++ ) {
            hash = hashes[i].split( '=' );
            vars.push( hash[0] );
            vars[ hash[0] ] = hash[1];
        }
        return vars;
    },

    setupLocaleLightbox: function() {
        var lang = whitesElectronics.setupLocale()[ 'lang' ];

        if ( typeof lang !== 'undefined' ) {
            console.log('------------------------------------');
            console.log(lang);
            console.log('------------------------------------');            
        } else {
            $( '.lightbox' ).delay( '200ms' ).fadeIn();
        }
    }

} // end object

// Debounce function used to throttle frequency
whitesElectronics.debounce = function( func, wait, immediate ) {
    var timeout;
    return function() {
        var context = this,
            args = arguments;
        var later = function() {
            timeout = null;
            if ( ! immediate ) func.apply( context, args );
        };
        var callNow = immediate && !timeout;
        clearTimeout( timeout );
        timeout = setTimeout( later, wait );
        if ( callNow ) func.apply( context, args );
    };
};

whitesElectronics.isMobile = function() {
    return $( window ).width() < 960 ? true : false;
};

/**
 * Runs on window resize every 50ms
 * Calculates css line-height on the slide overlays
 *
 */
whitesElectronics.resizeThrottle = whitesElectronics.debounce( function() {
    whitesElectronics.productDetail();
}, 50 );

$( document ).ready( function() {
    whitesElectronics.init();
} );