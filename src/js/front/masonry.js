export default function() {
	if ( 460 > window.innerWidth ) {
		return
	}
	jQuery( document ).ready( function( $ ) {
		const $grid = $( '#grid' ).imagesLoaded( function() {
			$grid.masonry({
				itemSelector: '.cell',
				columnWidth: '.grid-sizer',
				percentPosition: true
			})
		})
	})
}
