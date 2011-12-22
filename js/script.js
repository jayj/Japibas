(function($) {

	/**
	 * Slider
	 */
	if ( typeof ( jQuery().sudoSlider ) == 'function' ) {
		var auto = true;
   		var autostopped = false;
		var sudoSlider = $("#featured-section #inner-slider").sudoSlider({
			auto: true,
			continuous: true,
			numeric: true,
			speed: 600,
			numericAttr: 'id="feature-slider"'
		/* Pause on hover*/
		}).mouseenter(function() {
      		auto = sudoSlider.getValue('autoAnimation');
			if (auto)
				sudoSlider.stopAuto();
			else
				autostopped = true;
		}).mouseleave(function() {
			if (!autostopped)
			sudoSlider.startAuto();
		});
	}

	 /**
	 * Equal Heights In Rows
	 * http://css-tricks.com/equal-height-blocks-in-rows/
	 */
	var currentTallest = 0,
		currentRowStart = 0,
		rowDivs = [],
		$el,
		topPosition = 0,
		currentDiv = 0;

	$('.not-found-widgets .widget').each(function() {
		$el = $(this);
		topPosition = $el.position().top;

		if (currentRowStart != topPosition) {
			// we just came to a new row.  Set all the heights on the completed row
			for (currentDiv = 0; currentDiv < rowDivs.length ; currentDiv++) {
				rowDivs[currentDiv].height(currentTallest);
			}

			// set the variables for the new row
			rowDivs.length = 0; // empty the array
			currentRowStart = topPosition;
			currentTallest = $el.height();
			rowDivs.push($el);
		} else {
			// another div on the current row.  Add it to the list and check if it's taller
			rowDivs.push($el);
			currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
		}

		// do the last row
		for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
			rowDivs[currentDiv].height(currentTallest);
		}
	});
})(jQuery);