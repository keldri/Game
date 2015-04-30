jQuery(document).ready(function($) {
   
   	function rwpshuffle(o) {
		for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
		return o;
	};
   var tt = -1;
		$.fn.winner = function(m){
			var t = 0;
			$('div#letters ul li').remove();
			for(var i=0;i<m.length;i++){
   				$('div#letters ul').append('<li class="right flipped"><div>'+m[i]+'</div></li>');	
			}
			$('div#letters ul li').each(function(){
				var el = $(this);
				setTimeout(function(){el.removeClass('flipped')},t*50);
				t++;
			});
			//setTimeout(function(){$.fn.winner(winner[Math.floor((Math.random()*(winner.length-1))+1)]);},2000);
			if(tt < winner.length-1)
				setTimeout(function(){$.fn.winner(winner[tt])},2000);
			tt++;
		};
		//$.fn.report = function(success,message){
		function rwpreport(success,message){
			var t;
			if(success){
				t = 0;
				$('div#letters ul li').remove();
				$('div#answer ul li').addClass('solved');
				var w = "winner!";
				setTimeout(function(){$.fn.winner(w);},0);
			}else{
				t = $('div#letters ul li').length*-1;
				$('div#letters ul li').hide();
				var w = "wrong!";
				for(var i=0;i<w.length;i++){
   					$('div#letters ul').append('<li class="loser flipped"><div>'+w[i]+'</div></li>');
				};
				$('div#letters ul li').each(function(){
					var el = $(this);
					setTimeout(function(){el.removeClass('flipped')},t*50);
					t++;
				});
				setTimeout(function(){
					$('div#letters ul li').hide();
					t = $('div#letters ul li').length*-1;
					for(var i=0;i<message.length;i++){
   						$('div#letters ul').append('<li class="loser flipped"><div>'+message[i]+'</div></li>');
					};
					$('div#letters ul li').each(function(){
						var el = $(this);
						setTimeout(function(){el.removeClass('flipped')},t*50);
						t++;
					});
					setTimeout(function(){$.fn.resetLetters();},2000);
				},2000);
			}
		}
		$.fn.resetLetters = function(){
			$('div#letters ul li.loser').remove();
			$('div#answer ul li').trigger('click');
			//$('div#letters ul li').removeClass('flip').show();
			$('div#letters ul li').show();
			
		}
   //hide puzzle answer on front page
   $('body.blog article.riadwordplay p').remove();
   
   //check to be sure we're on a puzzle page - avoid 'strict' issues
   if($('div#answer').data('word') !== undefined){
   	/* Set up puzzle pieces, reformat the_content() */
	$('#puzzle p').wrapInner('<ul></ul>').find('a').each(function(){// SET UP IMAGES
		var photog = ($(this).find('img').attr('title') !== undefined)?$(this).find('img').attr('title'):"RIAD REPRESENTS";
   		var photo = $(this).find('img').attr('src');
   		var src = $(this).attr('href').substr($(this).attr('href').indexOf('/wp-content/'));
   		//alert(src)
   		$(this).find('img').remove();
   		$(this).attr('target','_blank');
   		$(this).attr('href','/blog/wp-content/plugins/riadwordplay/riadwordplay-popup.php?img=/blog'+src+'&photog='+photog);
   		$(this).append('<li class="new"></li>');
   		$(this).find('li').append('<div class="puzzle-photo"></div>','<div class="label">'+ photog+'</div>');
   		$(this).find('div.puzzle-photo').css({'background':'url('+photo+') center center no-repeat','-webkit-background-size': 'contain','-moz-background-size': 'contain','o-background-size': 'contain','background-size': 'contain'});
   		$(this).find('span').remove();
   		
   	});
   /*$('#puzzle p').find('a').each(function(){// SET UP IMAGES
		var photog = ($(this).find('img').attr('title') !== undefined)?$(this).find('img').attr('title'):"RIAD REPRESENTS";
   		var photo = $(this).find('img').attr('src');
   		var src = $(this).attr('href').substr($(this).attr('href').indexOf('/wp-content/'));
   		$(this).find('img').remove();
   		$(this).find('span').remove();
   		//$(this).attr('target','_blank');
   		//$(this).attr('href','wp-content/plugins/riadwordplay/riadwordplay-popup.php?img=/blog'+src+'&photog='+photog);
   		
   		$('div#rwp-pieces ul').append('<li class="new"><a href="/blog/wp-content/plugins/riadwordplay/riadwordplay-popup.php?img=/blog'+src+'&photog='+photog+'" target="_blank"><div class="puzzle-photo" data-photo="'+photo+'"></div><div class="label">'+ photog+'</div></a></li>');
   		//$('div#rwp-pieces ul li a').append('<div class="puzzle-photo"></div>','<div class="label">'+ photog+'</div>');
   		//$('div#rwp-pieces ul li div.puzzle-photo').css({'background':'url('+photo+') center center no-repeat','-webkit-background-size': 'contain','-moz-background-size': 'contain','o-background-size': 'contain','background-size': 'contain'});
   	});
   	$('#puzzle p').remove();
   	$('div#rwp-pieces ul li div.puzzle-photo').each(function(){
   		$(this).css({'background':'url('+$(this).data('photo')+') center center no-repeat','-webkit-background-size': 'contain','-moz-background-size': 'contain','o-background-size': 'contain','background-size': 'contain'});
   	});
   	*/
   	$('#puzzle').prepend('<div class="instructions">What do these four images have in common? Guess the word!</div>');
   
   	// SET UP BLANKS
   	var answer = $('div#answer').data('word').split('');
   	var lettercount = answer.length;
   	var letterstring = "aabcddeeefghiijkllmmnoopqrssttuvwxyz";
   	var letters = rwpshuffle(letterstring.split(''));
   	
   	
   	var selectletters = (lettercount+letters.length < 13)?answer.concat(letters.slice(0,lettercount*2)):answer.concat(letters.slice(0,13-lettercount));
   		
    var selectedletters = rwpshuffle(selectletters);
    
   	$('div#answer').removeAttr('data-word').append('<ul></ul>');
   	
   //	alert($('div#answer').data('word'));
   
   	for(var i=0;i<lettercount;i++){
   		$('div#answer ul').append('<li><div></div></li>');//'+answer[i]+'
	}
  	$('div#answer').show();
  	
  	//$('#puzzle').append('<div id="letters"><ul></ul></div>');
	for(var i=0;i<selectedletters.length;i++){
   		$('div#letters ul').append('<li data-letter="'+selectedletters[i]+'" data-place="'+i+'" class="solution-letter"><div>'+selectedletters[i]+'</div></li>');
	}
	var hints;
	if(lettercount < 4){
		hints = 1;
	}else if(lettercount < 6){
		hints = 2;
	}else{
		hints = 3;
	}
	var hintcount = hints;
	$('div#letters ul').append('<li data-hint="3" id="hint"><div><div class="hintcount">'+hints+'</div></div></li>');
   
   $(window).on('resize',function(){
   		$('#puzzle p li').height($('#puzzle li').width());
   		//bump down height of div.puzzle-photo to stay shorter than label
   		$('#puzzle li div.puzzle-photo').height($('#puzzle li').height()-$('div.label').height()+5);
   });
   $(window).trigger('resize');
   
   
   
	
	
	var loser = ['WTF!','um... no!','seriously?!','spell check?'];
	var winner = ['Hell yeah!','smartypants!','good stuff!','mad props','killin\' it','brilliant','sweet!'];
	var l = 0;
	var c=0;
	var solved;
	
	$('li#hint').on('click',function(){
		var h = 0;
		var b = false;
		if($('div#answer li.filled').length < lettercount){
			if(hints>0){
				hints--;
				$(this).find('div.hintcount').text(hints);
			
				$('div#answer li').each(function(){
					if(!$(this).hasClass('filled')){
						var hintletter = answer[h];
						if(b) return false;
						$('div#letters li').each(function(){
							if($(this).data('letter')==hintletter){
								$(this).trigger('click');
								b = true;
								return false;
							}
						});
					}
					h++;
				});
			}else{
				if(hintcount == 1){
					alert('You already used your '+hintcount+' hint!');
				}else{
					alert('You already used your '+hintcount+' hints!');
				}
			}
		}
	});
	$('div#letters li.solution-letter').on('click',function(){
		//alert('clicked');
		if(c<lettercount && !$(this).hasClass('used')){
			var letter = $(this).data('letter');
			var place = $(this).data('place');
			$(this).addClass('used').find('div').fadeOut(300);//hide('scale',{},100);//'scale',{},100
			$('div#answer li').each(function(){
				if(!$(this).hasClass('filled')){
					$(this).addClass('filled').data({'place':place,'letter':letter}).find('div').text(letter).show();//'scale',{},250
					
					return false;
				}
			});
			c++;
			if(c>=lettercount){
				solved = true;
				for(var i=0;i<lettercount;i++){
					if(answer[i] != $('div#answer li').eq(i).data('letter')){
						solved = false;
						break;
					}
				}
				if(solved){
					//$.fn.report(true,winner[Math.floor((Math.random()*(winner.length-1))+1)]);
					rwpreport(true,winner[Math.floor((Math.random()*(winner.length-1))+1)]);
					//$('div#letters li').hide();//'scale',{},100
				}else{
					//$.fn.report(false,loser[l]);
					rwpreport(false,loser[l]);
					l = (l<loser.length-1)?++l:0;
				}
				
			}
			}
		});
		$('div#answer li').on('click',function(){
			if(!solved){
				var letter = $(this).data('letter');
				var place = $(this).data('place');
				$(this).removeClass('filled').find('div').hide();//'scale',{},100
				$('div#letters li').each(function(){
					if($(this).data('place')==place){
						$(this).removeClass('used').find('div').text(letter).show();//'scale',{},250
						return false;
					}
				});
				c--;
			}
		});
		
   	}
});