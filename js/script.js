(function(h){h.fn.sudoSlider=function(X){var c=!1,e=!c,g=this,X=h.extend({controlsShow:e,controlsFadeSpeed:400,controlsFade:e,insertAfter:e,firstShow:c,lastShow:c,vertical:c,speed:800,ease:"swing",auto:c,pause:2E3,continuous:c,prevNext:e,numeric:c,numericAttr:'class="controls"',numericText:[],clickableAni:c,history:c,speedhistory:400,autoheight:e,customLink:c,fade:c,crossFade:e,fadespeed:1E3,updateBefore:c,ajax:c,preloadAjax:100,startSlide:c,ajaxLoadFunction:c,beforeAniFunc:c,afterAniFunc:c,uncurrentFunc:c,
currentFunc:c,prevHtml:'<a href="#" class="prevBtn"> previous </a>',nextHtml:'<a href="#" class="nextBtn"> next </a>',loadingText:"Loading Content...",firstHtml:'<a href="#" class="firstBtn"> first </a>',controlsAttr:'id="controls"',lastHtml:'<a href="#" class="lastBtn"> last </a>',autowidth:e,slideCount:1,resumePause:c,moveCount:1},X);return this.each(function(){function ea(d,o){k=0;for(b in K)a[k]=K[b],k++;y=c;E=e;q=d.children("ul");m=q.children("li");i=m.length;if(a[25]&&(q.length==0&&d.append(q=
h("<ul></ul>")),a[25].length>i)){for(b=1;b<=a[25].length-i;b++)q.append("<li><p>"+a[35]+"</p></li>");m=q.children("li");i=m.length}t=f=0;r=i-1;p=e;L=s=Y=c;R=[];y=c;d.css("overflow","hidden");d.css("position")=="static"&&d.css("position","relative");m.css({"float":"left",display:"block"});a[40]=n(a[40]);a[42]--;v=a[40];a[21]||(a[40]+=a[42]);a[40]>i&&(a[40]=i);a[27]=n(a[27])||1;F=a[11]&&(!a[21]||a[40]>1);for(b=0;b<i;b++)a[15][b]=a[15][b]||b+1,a[25][b]=a[25][b]||c;if(F){for(j=a[40];j>=1;j--)q.prepend(m.eq(-a[40]+
j-1).clone()).append(m.eq(a[40]-j).clone());u=q.children("li");if(a[25])for(b=i-a[40];b<i;b++)a[25][b]&&b!=a[27]-1&&A(b,c,0,c)}a[2]=a[2]&&!a[11];q[a[6]?"height":"width"](1E7);u=q.children("li");B=c;if(a[0]){B=h("<span "+a[37]+"></span>");h(d)[a[3]?"after":"before"](B);if(a[13]){fa=B.prepend("<ol "+a[14]+"></ol>").children();k=a[13]=="pages"?v:1;for(b=0;b<i-(a[11]||a[13]=="pages"?1:v)+1;b+=k)R[b]=h("<li rel='"+(b+1)+"'><a href='#'><span>"+a[15][b]+"</span></a></li>").appendTo(fa).click(function(){G(h(this).attr("rel")-
1,e);return c})}a[4]&&(ga=S(a[36],"first"));a[5]&&(ha=S(a[38],"last"));a[12]&&(ia=S(a[34],"next"),ja=S(a[33],"prev"))}if(a[26]===e)for(j=0;j<=r;j++)a[25][j]&&a[27]-1!=j&&A(j,c,0,c);k=[1,7,10,18,23];for(b in k)a[n(k[b])]=ta(a[n(k[b])]);a[20]&&h(a[20]).live("click",function(){if(b=h(this).attr("rel"))b=="stop"?(a[9]=c,clearTimeout(z),M=c):b=="start"?(z=N(a[10]),a[9]=e):b=="block"?p=c:b=="unblock"?p=e:p&&G(b==n(b)?b-1:b,e);return c});Z(u.slice(0,a[40]),e,function(){a[9]&&(z=N(a[10]));o?C(o,c,c,c):a[17]?
(h.hashchange?h(window).hashchange(T):h.address?h.address.change(function(){T()}):h(window).bind("hashchange",T),T()):C(a[27]-1,c,c,c)})}function ka(){if(a[25]&&n(a[26]))for(b in a[25])if(a[25][b]){clearTimeout(U);U=setTimeout(function(){A(b,c,0,c)},n(a[26]));break}}function T(){a:{var d=location.hash.substr(1);for(j in a[15])if(a[15][j]==d)break a;j=d?f:0}E?C(j,c,c,c):j!=f&&G(j,c)}function N(a){M=e;return setTimeout(function(){G("next",c)},a)}function ta(a){return n(a)||a==0?n(a):a=="fast"?200:a==
"normal"||a=="medium"?400:a=="slow"?600:400}function S(a,b){return h(a).prependTo(B).click(function(){G(b,e);return c})}function G(d,o){O=c;if(!y){if(a[9]){var w=a[7];s&&a[22]?w=n(w*0.6):s&&(w=0);o?(clearTimeout(z),M=c,a[41]&&(z=N(w+a[41]))):z=N(a[10]+w)}a[21]?la(d,o):(a[11]&&(d=H(d,f),b=x(d),w=Math.abs(f-d),b<a[40]-v+1&&Math.abs(f-b-i)<w&&(d=b+i,w=Math.abs(f-b-i)),b>r-a[40]&&Math.abs(f-b+i)<w&&(d=b-i)),C(d,o,e,c))}}function ma(d,c,b){if(b)var b=ia,e=ha,f="next",g="last",i=a[5];else b=ja,e=ga,f="prev",
g="first",i=a[4];if(a[0]){if(a[12])b[d?"fadeIn":"fadeOut"](c);if(i)e[d?"fadeIn":"fadeOut"](c)}if(a[20])h(a[20]).filter(function(){return h(this).attr("rel")==f||h(this).attr("rel")==g})[d?"fadeIn":"fadeOut"](c)}function na(a,b){ma(a,b,c);ma(a<i-v,b,e)}function $(d){d=x(d)+1;if(a[13])for(b in R)oa(R[b],d);a[20]&&oa(h(a[20]),d)}function oa(d,o){d.filter&&(d.filter(".current").removeClass("current").each(function(){h.isFunction(a[31])&&a[31].call(this,h(this).attr("rel"))}),d.filter(function(){k=h(this).attr("rel");
if(a[13]=="pages")for(b=0;b<v;b++){if(k==o-b)return e}else return k==o;return c}).addClass("current").each(function(){h.isFunction(a[32])&&a[32].call(this,o)}))}function Z(a,b,c){var a=a.add(a.find("img")).filter("img"),e=a.length;e||c();a.load(function(){this.naturalHeight&&!this.clientHeight&&h(this).height(this.naturalHeight).width(this.naturalWidth);b?(e--,e==0&&c()):c()}).each(function(){if((this.complete||this.complete===void 0)&&b){var a=this.src;this.src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
this.src=a}})}function V(d,b){a[19]&&pa(d,b,e);a[39]&&pa(d,b,c)}function pa(a,b,e){P.ready(function(){qa(a,b,e);Z(m.eq(a),c,function(){qa(a,b,e)})})}function qa(d,b,e){d=x(d);k=m.eq(d)[e?"height":"width"]();P.animate(e?{height:k}:{width:k},{queue:c,duration:b,easing:a[8]})}function aa(){q.css(a[6]?"margin-top":"margin-left",ba(f))}function ba(d){return-u.eq(d+(F?a[40]:0)).position()[a[6]?"top":"left"]}function ua(){f=x(f);a[24]||$(f);aa();p=e;if(a[17]&&Y)window.location.hash=a[15][f];!s&&O&&D(f,e)}
function D(d,b){(b?ca:da)(m.eq(d),x(d)+1);if(F&&(d<a[40]&&(b?ca:da)(u.eq(d<0?d+a[40]:d-a[40]),d+1),d>r-a[40]||d==-a[40]))(b?ca:da)(u.eq(d==-a[40]?-1:a[40]+d-r-1),d+1)}function ca(d,b){h.isFunction(a[30])&&a[30].call(d,b)}function da(d,b){h.isFunction(a[29])&&a[29].call(d,b)}function H(d,b){return d=="next"?b>=r?a[11]?f+1+a[42]:f==0?1+a[42]:0:f+1+a[42]:d=="prev"?f<=0?a[11]?f-1-a[42]:f==r?r-1-a[42]:r:f-1-a[42]:d=="first"?0:d=="last"?r:n(d)}function A(d,b,f,g){U&&clearTimeout(U);var l=a[25][d],i=m.eq(d),
k=f===e,f=f===e?0:f;s&&!a[22]&&n(a[23]*0.4);var j=c;h.ajax({url:l,success:function(a,h,l){l.getResponseHeader("Content-Type").substr(0,5)!="image"&&(j=e,i.html(a),ra(d,f,g,b,k,c))},complete:function(){if(!j)image=new Image,i.html("").append(image),image.src=l,ra(d,f,g,b,k,e)}});a[25][d]=c;K.ajax[d]=c}function ra(d,b,f,g,l,i){var k=m.eq(d);F&&(d<a[40]&&u.eq(d<0?d+a[40]:d-a[40]).replaceWith(h(k).clone()),d>r-a[40]&&u.eq(a[40]+d-r-1).replaceWith(h(k).clone()),u=q.children("li"),l===e&&aa());g&&V(d,b);
Z(k,e,function(){l===e&&aa();h.isFunction(f)&&f();ka()});h.isFunction(a[28])&&a[28].call(k,n(d)+1,i);f==2&&(D(d,c),O||(D(d,e),O=e))}function la(d,o,g){if(H(d,t)!=f&&!y&&p){L=c;a[24]&&$(H(d,t));var i=!o&&!a[9]&&a[17]?a[23]*(a[18]/a[7]):a[23],l=x(H(d,t));a[2]&&na(l,a[1]);if(g)i=W,I&&I--;else if(a[25]){I=0;W=i;for(b=l;b<l+v;b++)a[25][b]&&(A(x(b),c,i,function(){la(d,o,e)}),I++)}else I=c;if(!I)if(p=!o,V(l,a[23]),D(l,c),a[22]){var k=e,g=0;for(b=l;b<l+v;b++)m.eq(x(b)).clone().prependTo(P).css({"z-index":"100000",
position:"absolute","list-style":"none",top:a[6]?g:0,left:a[6]?0:g}).hide().fadeIn(a[23],function(){sa();s=p=e;if(k){C(l,c,c,c);if(a[17]&&o)window.location.hash=a[15][f];D(l,e);k=c}h(this).remove();s=c}),g+=m.eq(b)[a[6]?"outerHeight":"outerWidth"](e)}else{var j=n(i*0.6);m.stop().fadeTo(i-j,0.001,function(){s=p=e;C(l,c,c,c);p=!o;m.fadeTo(j,1,function(){sa();if(a[17]&&o)window.location.hash=a[15][f];p=e;s=c;D(l,e)})})}}}function C(d,g,i,h){if(p&&!y&&(H(d,t)!=f||E)||h){h||(L=c);p=!g&&!a[9]?e:a[16];Y=
g;t=f;f=H(d,t);a[24]&&$(f);var l=Math.sqrt(Math.abs(t-f)),j=!i?0:!g&&!a[9]?n(l*a[18]):n(l*a[7]),l=x(f);if(h)j=W,Q&&Q--;else if(a[25]){a[25][l]&&(A(l,e,E||j,2),L=e);if(!s){var h=t>f?f:t,m=t>f?t:f;Q=0;W=j;for(b=h;b<=m;b++)b<=r&&b>=0&&a[25][b]&&(A(b,c,j,function(){C(d,g,i,e)}),Q++)}for(b=l+1;b<=l+v;b++)a[25][b]&&A(b,c,0,c)}Q||(!s&&!L&&(D(l,c),O=e),s||V(f,j),k=ba(f),q.animate(a[6]?{marginTop:k}:{marginLeft:k},{queue:c,duration:j,easing:a[8],complete:ua}),a[2]&&(j=a[1],!g&&!a[9]&&(j=a[18]/a[7]*a[1]),i||
(j=0),s&&(j=n(a[23]*0.6)),na(f,j)),E&&(a[25][l]||ka()),E=c)}}function x(a){return a<0?a+i:a>r?a-i:a}function n(a){return parseInt(a,10)}function sa(){screen.fontSmoothingEnabled&&this.style.removeAttribute("filter")}var E,q,m,u,i,f,t,r,p,Y,s,L,R,fa,y,B,ga,ha,ia,ja,z,J,W,Q,I,M,b,k,j,F,v,O=c,U,P=h(this),K=X,a=[];ea(P,c);g.getOption=function(a){return K[a]};g.setOption=function(a,b){b&&(g.destroy(),K[a]=b,g.init());return g};g.insertSlide=function(b,c,e){if(b){g.destroy();c>i&&(c=i);b="<li>"+b+"</li>";
!c||c==0?q.prepend(b):m.eq(c-1).after(b);(c<=J||!c||c==0)&&J++;if(a[15].length<c)a[15].length=c;a[15].splice(c,0,e||n(c)+1);g.init()}return g};g.removeSlide=function(b){b--;g.destroy();m.eq(b).remove();a[15].splice(b,1);b<J&&J--;g.init();return g};g.goToSlide=function(a){G(a==n(a)?a-1:a,e);return g};g.block=function(){p=c;return g};g.unblock=function(){p=e;return g};g.startAuto=function(){a[9]=e;z=N(a[10]);return g};g.stopAuto=function(){a[9]=c;clearTimeout(z);M=c;return g};g.destroy=function(){J=
f;B&&B.remove();y=e;h(a[20]).die("click");if(F)for(b=1;b<=a[40];b++)u.eq(b-1).add(u.eq(-b)).remove();q.css(a[6]?"margin-top":"margin-left",ba(f));return g};g.init=function(){y&&ea(P,J);return g};g.adjust=function(a){a||(a=0);V(j,a);return g};g.getValue=function(a){return a=="currentSlide"?f+1:a=="totalSlides"?i:a=="clickable"?p:a=="destroyed"?y:a=="autoAnimation"?M:void 0}})}})(jQuery);

jQuery(document).ready(function($){
	
	/**
	 * Add Comment number to comments
	 */
	$('.commentlist li').each(function(i) {
		$(this).append('<span class="comment-number">' + (i + 1) + '</span>');
	});
	
	/**
	 * Slider
	 */

	var sudoSlider = $("#featured-section #inner-slider").sudoSlider({
		auto: false,
		numeric: true,
		numericAttr: 'id="feature-slider"',
	});

function oldslider(){
	
	// The autoplay function
	// Any ideas for improvements?
/*	var autoplay = setInterval(function(){
		var next = $('#featured-section .slide:first-child').next(),
		nextId = next.attr('id'),
		currentId = $('#featured-section .slide:first-child').attr('id');

		$('#featured-section .slide:first-child').css({
			opacity: 0,
			visibility: 'hidden'
		}).next().css({
			opacity: 1,
			visibility: 'visible'
		}).end().appendTo('#featured-section .slides');

		$('#feature-slider a[href=#' + currentId + ']').removeClass('active');
		$('#feature-slider a[href=#' + nextId + ']').addClass('active'); 
	}, 3000 );*/
		

	
	$('#feature-slider a').click(function(e) {
		$('#featured-section .slide').css({
			opacity: 0,
			visibility: 'hidden'
		});
		
		$(this.hash).css({
			opacity: 1,
			visibility: 'visible'
		});
		
		$('#featured-section .slide').removeClass( 'current-slide' );
		$(this.hash).addClass( 'current-slide' );
		
		$('#feature-slider a').removeClass('active');
		$(this).addClass('active');
		
		//clearInterval(autoplay); // Stop autoplay when clicking
		/*cancelRequestAnimFrame(request);		*/
		
		e.preventDefault();
	});
	
	var current = $('#featured-section .slide.current-slide');
		
	if( current.length < 1 ) {
		current = $('#featured-section .slide').filter(':first');
	}
		
	$('#next-slide').click(function(e) {
		
		var current = $('#featured-section .slide.current-slide');
		
		if( current.length < 1 ) {
			current = $('#featured-section .slide').filter(':first');	
		}
		
		var next = $(current).next(),
			nextId = next.attr('id'),
			currentId = $(current).attr('id');
		
		$(current).css({
			opacity: 0,
			visibility: 'hidden'
		});
		
		$(current).next().css({
			opacity: 1,
			visibility: 'visible'
		}).end().appendTo('#featured-section .slides');
		
		$(current).removeClass( 'current-slide' );
		$(current).next().addClass( 'current-slide' );
		
		$('#feature-slider a[href=#' + currentId + ']').removeClass('active');
		$('#feature-slider a[href=#' + nextId + ']').addClass('active'); 
		
		e.preventDefault();
	});
	
	$('#prev-slide').click(function(e) {
		
		var current = $('#featured-section .slide.current-slide');
		
		if( current.length < 1 ) {
			var current = $('#featured-section .slide').filter(':first');
			/*
			
							last = $('#featured-section .slide').filter(':last');
			
			if( current == $('#featured-section .slide').filter(':first') )	
				$(last).clone().prependTo('#featured-section .slides');*/
		}
		
		var prev = $(current).prev();
			
		if( prev.length < 1 ) {
			var prev = $('#featured-section .slide').filter(':last');
		}
		
		var prevId = prev.attr('id'),
		currentId = $(current).attr('id');
		
		$(current).css({
			opacity: 0,
			visibility: 'hidden'
		});
		
		prev.css({
			opacity: 1,
			visibility: 'visible'
		}).end().appendTo('#featured-section .slides');
		
		$(current).removeClass( 'current-slide' );
		prev.addClass( 'current-slide' );
		
		console.log( current );
		
		$('#feature-slider a[href=#' + currentId + ']').removeClass('active');
		$('#feature-slider a[href=#' + prevId + ']').addClass('active'); 
		
		e.preventDefault();
	});

	// Stop autoplay when hovering over the slides	 
	$('#featured-section').hover(function(){
		//clearInterval(autoplay); 
		
		/*cancelRequestAnimFrame(request);*/
	});
	
}; // slider
	 
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

});