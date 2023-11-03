// Configuration object for API keys and defaults.
const apiConfig = {
  endpoint: 'https://weatherapi-com.p.rapidapi.com/forecast.json',
  key: '5a1f892a6fmsh79b914fdd2d4469p1d85fejsnfd6c65fa4b63',
  host: 'weatherapi-com.p.rapidapi.com',
};

// Function to fetch and display weather forecast for a city with a flexible number of days.
function fetchForecastForCity(city, days = apiConfig.defaultDays) {
    const xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener('readystatechange', function () {
        if (this.readyState === this.DONE) {
            displayForecast(JSON.parse(this.responseText));
        }
    });
    
    // Build the URL with query parameters.
    const url = `${apiConfig.endpoint}?q=${encodeURIComponent(city)}&days=${days}`;
    
    // Open a connection and set up the headers with API keys from the config.
    xhr.open('GET', url);
    xhr.setRequestHeader('X-RapidAPI-Key', apiConfig.key);
    xhr.setRequestHeader('X-RapidAPI-Host', apiConfig.host);
    
    xhr.send(null);
}

// Helper function to create and display forecast elements on the page.
function displayForecast(response) {
  const forecastContainer = document.getElementById('forecast-container');
  forecastContainer.innerHTML = ''; // Clear previous forecasts

  // Iterate over the forecast days and create forecast elements.
  response.forecast.forecastday.forEach(day => {
      const forecastDiv = document.createElement('div');
      forecastDiv.className = 'forecast';
      forecastDiv.innerHTML = `
          <p>Avg Temp: ${day.day.avgtemp_f}°F</p>
          <img src="https:${day.day.condition.icon}">
      `;
      forecastContainer.appendChild(forecastDiv);
  });
}

// Event listener to handle form submission.
document.addEventListener("DOMContentLoaded", function() {
  // When the form is submitted, prevent the default action and call fetchForecastForCity.
  const form = document.getElementById('city-form');
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    const city = document.getElementById('city').value;
    const days = document.getElementById('days').value || apiConfig.defaultDays;
    fetchForecastForCity(city, days);
  });
});