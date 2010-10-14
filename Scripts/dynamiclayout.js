// - - - - - - - - - - - - - - - - - - - - -
//
// Title : Dynamic Resolution Dependent Layout Demo
// Author : Kevin Hale
// URL : http://particletree.com
//
// Description : This is a demonstration of a dynamic 
// resolution dependent layout in action. Change your browser 
// window size to see the layout respond to your changes. To 
// preserve the separation of the presentation and behavior 
// layers, this implementation delegates all the presentation 
// details to external CSS stylesheets instead of changing 
// each style property through JavaScript.
//
// Created : July 30, 2005
// Modified : November 15, 2005
//
// - - - - - - - - - - - - - - - - - - - - -
// getBrowserWidth is taken from The Man in Blue Resolution Dependent Layout Script
// http://www.themaninblue.com/experiment/ResolutionLayout/
	function getBrowserWidth(){
		if (window.innerWidth){
			return window.innerWidth;}	
		else if (document.documentElement && document.documentElement.clientWidth != 0){
			return document.documentElement.clientWidth;	}
		else if (document.body){return document.body.clientWidth;}		
			return 0;
	}

// dynamicLayout by Kevin Hale
function dynamicLayout(){
	var browserWidth = getBrowserWidth();
			
	//Load Thin CSS Rules
	if (browserWidth < 1220){
		changeLayout("1024");
		changeSize(0.533);
	}
	//Load Wide CSS Rules
	if ((browserWidth >= 1220) && (browserWidth < 1400)){
		changeLayout("1280");
		changeSize(0.667);
	}
	if ((browserWidth >= 1400) && (browserWidth < 1640)){
		changeLayout("1440");
		changeSize(0.75);
	}
	if ((browserWidth >= 1640) && (browserWidth < 1850)){
		changeLayout("1680");
		changeSize(0.875);
	}
	//Load Wider CSS Rules
	if (browserWidth >= 1850){
		changeLayout("1920");
		changeSize(1);
	}
}

// changeLayout is based on setActiveStyleSheet function by Paul Sowdon 
// http://www.alistapart.com/articles/alternate/
function changeLayout(description){
	
   	var i, a;
   	for(i=0; (a = document.getElementsByTagName("link")[i]); i++){
	    	if(   a.getAttribute("title") == description 
		   || a.getAttribute("title") == "default" )
			{a.disabled = false; }
		else { a.disabled = true; }

   }
}

function changeSize(description){

   var i, a;
   
   if( typeof this.imgsize == 'undefined' ) this.imgsize = [];  
   if( typeof this.flashsize == 'undefined' ) this.flashsize = [];
   
   for(i=0; (a = document.getElementsByTagName("img")[i]); i++)
   {
		if( typeof this.imgsize[i] == 'undefined' ) this.imgsize[i] = a.width;
		a.width = description * this.imgsize[i];
   }

   // Firefox
   for(i=0; (a = document.getElementsByTagName("object")[i]); i++)
   {
		if( typeof this.flashsize[i] == 'undefined' )
		{	
			this.flashsize[i] = [];
			this.flashsize[i][0] = []; this.flashsize[i][0] = a.width;
			this.flashsize[i][1] = []; this.flashsize[i][1] = a.height/a.width;
		}
		a.style.width = (description * this.flashsize[i][0]) + "px";
		a.style.height = (description * this.flashsize[i][0] * this.flashsize[i][1]) + "px";
   }
   /*
   // IE / Chrome
   for(i=0; (a = document.getElementsByName("movie")[i]); i++)
   {
		a.width = description * this.flashsize[i][0];
		a.height = description * this.flashsize[i][0] * this.flashsize[i][1];
   }   */
}

//addEvent() by John Resig
function addEvent( obj, type, fn ){ 
   if (obj.addEventListener){ 
	  obj.addEventListener( type, fn, false );
   }
   else if (obj.attachEvent){ 
	  obj["e"+type+fn] = fn; 
	  obj[type+fn] = function(){ obj["e"+type+fn]( window.event ); } 
	  obj.attachEvent( "on"+type, obj[type+fn] ); 
   } 
} 
	
//Run dynamicLayout function when page loads and when it resizes.
//addEvent(window, 'load', dynamicLayout);
addEvent(window, 'resize', dynamicLayout);
