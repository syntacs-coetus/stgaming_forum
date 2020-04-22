$(function () {
    $('a[href="#search"]').on('click', function(event) {
        event.preventDefault();
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
    });
    
    $('#search, #search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
    
});

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(3(e){e.p.q=3(t){2 n={8:s,5:"9",a:"u",b:6,7:6,c:6,v:w};e.x(n,t);2 r=e(y);2 i=r.d();i.f(":g").h();r.4("z",t.a);r.4("j-A",t.b);r.4("7",t.7);r.4("j-B",t.c);C(3(){2 e=r.d();e.f(":g").h();2 n=e.k(0);2 i=e.k(1);l(t.5=="D"){n.E();i.F(3(){n.m().o(r)})}l(t.5=="9"){n.G(3(){i.H();n.m().o(r)})}},t.8)}})(I);',45,45,'||var|function|css|effect|null|color|speed|fade|dir|font_size|font_family|children||not|first|hide||font|eq|if|remove||appendTo|fn|inewsticker||200||ltr|delay_after|3e3|extend|this|direction|size|family|setInterval|slide|slideUp|slideDown|fadeOut|fadeIn|jQuery'.split('|'),0,{}))


//News-Ticker

$( document ).ready(function() {
	// News-ticker
    $('.fade-ticker').inewsticker({
		speed       : 3000,
		effect      : 'fade',
		dir         : 'ltr',
		font_size   : 12,
		// color       : '#fff',
		font_family : 'arial',
		delay_after : 1000		
	});
	$('.slide-ticker').inewsticker({
		speed       : 2500,
		effect      : 'slide',
		dir         : 'ltr',
		font_size   : 12,
		font_family : 'arial',
		delay_after : 1000						
	});
});
