;(function($) {
	$(document).ready(function() {
		if (!WordCloud.isSupported) {
			$('#cloudtags-container').remove();
			$('#splash-container').removeClass('col-sm-8').addClass('col-sm-12');
			return;
		}
	});
})(jQuery);

'use strict';
jQuery(function($) {
	var $canvas = $('#canvas');
	var $htmlCanvas = $('#html-canvas');
	var $canvasContainer = $('#canvas-container');
	var dppx = 1;

	var $box = $('<div id="box" hidden />');
	$canvasContainer.append($box);
	window.drawBox = function drawBox(item, dimension) {
		if (!dimension) {
			$box.prop('hidden', true);

			return;
		}

		$box.prop('hidden', false);
		$box.css({
			left : dimension.x / dppx + 'px',
			top : dimension.y / dppx + 'px',
			width : dimension.w / dppx + 'px',
			height : dimension.h / dppx + 'px'
		});
	};

	// Update the default value if we are running in a hdppx device
	if (('devicePixelRatio' in window) && window.devicePixelRatio !== 1) {
		dppx = window.devicePixelRatio;
	}

	var run = function run() {

		// devicePixelRatio
		var devicePixelRatio = parseFloat(dppx);

		// Set the width and height
		var width = $('#canvas-container').width();
		var height = $('#splash-container').height();
		var pixelWidth = width;
		var pixelHeight = height;

		if (devicePixelRatio !== 1) {
			$canvas.css({
				'width' : width + 'px',
				'height' : height + 'px'
			});

			pixelWidth *= devicePixelRatio;
			pixelHeight *= devicePixelRatio;
		} else {
			$canvas.css({
				'width' : '',
				'height' : ''
			});
		}

		$canvas.attr('width', pixelWidth);
		$canvas.attr('height', pixelHeight);

		$htmlCanvas.css({
			'width' : pixelWidth + 'px',
			'height' : pixelHeight + 'px'
		});

		// Set the options object
		var options = {
			gridSize : Math.round(16 * $('#canvas').width() / 1024),
			weightFactor : function(size) {
				return Math.pow(size, 2.3) * $('#canvas').width() / 1024;
				
			},
			fontFamily : 'Times, serif',
			color : function(word, weight) {
				return ((Math.random() > 0.5)?'#fff':'#718000');
			},
			rotateRatio : 0.5,
			backgroundColor : '#B7CD20'
		}

		// Set devicePixelRatio options
		if (devicePixelRatio !== 1) {
			if (!('gridSize' in options)) {
				options.gridSize = 8;
			}
			options.gridSize *= devicePixelRatio;

			if (options.origin) {
				if (typeof options.origin[0] == 'number')
					options.origin[0] *= devicePixelRatio;
				if (typeof options.origin[1] == 'number')
					options.origin[1] *= devicePixelRatio;
			}

			if (!('weightFactor' in options)) {
				options.weightFactor = 1;
			}
			if (typeof options.weightFactor == 'function') {
				var origWeightFactor = options.weightFactor;
				options.weightFactor = function weightFactorDevicePixelRatioWrap() {
					return origWeightFactor.apply(this, arguments) * devicePixelRatio;
				};
			} else {
				options.weightFactor *= devicePixelRatio;
			}
		}

		// Put the word list into options
		var words = [
			'Mieux vivre ensemble',
			'Transition ',
			'Transition énergétique',
			'Permaculture',
			'Agroécologie',
			'Sobriété heureuse',
			'Intelligence collective',
			'Solidarité',
			'Innovation Sociale',
			'Partage',
			'Collaboration',
			'Coopération',
			'Biens Communs',
			'Autonomie',
			'Résilience',
			'Ecosystème',
			'Local',
			'Réseaux',
			"Consommac'teurs",
			'Eco-citoyens',
			'Open Source', 'Logiciels libres',
			'Alimentation', 'Commerce équitable', 'Convivialité', 'Dons', 'Associations'
		];
		shuffle = function(o){ //v1.0
		    for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
		    return o;
		};
		words = shuffle(words);
		var list = [['Solidées', 8]];
		$.each(words, function(word) {
			list.push([words[word], (8-1-Math.random()*3)]);
		});
		options.list = list;

		// All set, call the WordCloud()
		// Order matters here because the HTML canvas might by
		// set to display: none.
		WordCloud([ $canvas[0], $htmlCanvas[0] ], options);
	};

	run();
});