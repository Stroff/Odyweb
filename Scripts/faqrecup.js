// JavaScript Document
	window.addEvent('domready', function() {
	var status = {
		'true': 'open',
		'false': 'close'
	};
	
	//-vertical

	myVerticalSlide = new Array();
	for( idx = 1; idx < 50; idx++ )
	{
		var t = "textefaq" + idx;
		var y = "titrefaq" + idx;
		
		try {
			myVerticalSlide[idx] = new Fx.Slide(t);
			$(y).addEvent('click', function(e){
				if ( typeof this.num == 'undefined' ) this.num = this.id.substr(8);
                        	e.stop();
	                        myVerticalSlide[this.num].toggle();
        	        });
			myVerticalSlide[idx].toggle();
		} catch(e) {
			// If exception they're no more slide
			break ;
//			alert("An exception occurred in the script. Error name: " + e.name 
//			+ ". Error message: " + e.message); 
		}
	}
});
