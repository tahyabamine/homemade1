$("#cp").autocomplete({
	source: function (request, response) {
		$.ajax({
			url: "https://api-adresse.data.gouv.fr/search/?q="+$("input[name='add-adresse[codePostal]']").val()+'&type=municipality&autocomplete=1',
			data: { q: request.term },
			dataType: "json",
			success: function (data) {
				response($.map(data.features, function (item) {
					return { label: item.properties.postcode + " - " + item.properties.city,
								 city: item.properties.city,
								 value: item.properties.postcode
						};
				}));
			}
		});
	},
	// On remplit aussi la ville
	select: function(event, ui) {
		$('#ville').val(ui.item.city);
	}
});
$("#ville").autocomplete({
	source: function (request, response) {
		$.ajax({
			url: "https://api-adresse.data.gouv.fr/search/?city="+$("input[name='add_adresse[ville]']").val(),
			data: { q: request.term },
			dataType: "json",
			success: function (data) {
				var cities = [];
				response($.map(data.features, function (item) {
					// Ici on est obligé d'ajouter les villes dans un array pour ne pas avoir plusieurs fois la même
					if ($.inArray(item.properties.postcode, cities) == -1) {
						cities.push(item.properties.postcode);
						return { label: item.properties.postcode + " - " + item.properties.city, 
								 postcode: item.properties.postcode,
								 value: item.properties.city
						};
					}
				}));
			}
		});
	},
	// On remplit aussi le CP
	select: function(event, ui) {
		$('#cp').val(ui.item.postcode);
	}
});
$("#adresse").autocomplete({
	source: function (request, response) {
		$.ajax({
			url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='add_adresse[codePostal]']").val(),
			data: { q: request.term },
			dataType: "json",
			success: function (data) {
				response($.map(data.features, function (item) {
					return { label: item.properties.name, value: item.properties.name};
				}));
			}
		});
	}
});