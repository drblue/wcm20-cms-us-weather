(function(){
	const ajax_url = ww_settings.ajax_url;

	// find all (if any) weather-widgets
	const widgets = document.querySelectorAll('.current-weather');
	console.log("Widgets found:", widgets);

	widgets.forEach(widget => {
		// do stuff with widget
		console.log("Widget:", widget);

		const location = widget.dataset.location;
		console.log("The location is:", location);

		// fetch weather for this specific widget
		fetch(ajax_url + '?action=ww_get_current_weather&location=' + location)
			.then(res => res.json())
			.then(res => {
				// do other stuff with response
				console.log("Got response for widget:", widget, res);

				// was request successful?
				if (res.success) {
					// render weather
					widget.innerHTML = `
						<div class="current-weather-temperature">
							${res.data.temperature}&deg;C
						</div>
						<div class="current-weather-feels-like">
							<span class="label">Feels like:</span> ${res.data.feels_like}&deg;C
						</div>
					`;
				} else {
					// render error message
					widget.innerHTML = `
						<p><em>${res.data}</em></p>
					`;
				}
			})
	});
})();
