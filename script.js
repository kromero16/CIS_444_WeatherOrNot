// Listen for when the HTML document is fully loaded and parsed
document.addEventListener("DOMContentLoaded", function() {
  
    const form = document.getElementById('city-form');
    
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const city = document.getElementById('city').value;
      
      // Make the API request
      fetchForecastForCity(city);
    });
  
  });
  
  // Set up a listener for the XMLHttpRequest state change
  function fetchForecastForCity(city) {
    const data = null;

    const xhr = new XMLHttpRequest();
    xhr.withCredentials = true;
    
    xhr.addEventListener('readystatechange', function () {
        if (this.readyState === this.DONE) {
            const response = JSON.parse(this.responseText);
            const forecastdays = response.forecast.forecastday;
  
            // Clear existing forecasts if any
            const forecastContainer = document.getElementById('forecast-container');
            forecastContainer.innerHTML = '';
  
            // Loop through each forecast day to capture the data
            for (let i = 0; i < forecastdays.length; i++) {
              const avgtemp_f = forecastdays[i].day.avgtemp_f;
              const icon = forecastdays[i].day.condition.icon;
  
              // Create HTML elements dynamically
              const forecastDiv = document.createElement('div');
              forecastDiv.className = 'forecast';
  
              const tempElement = document.createElement('p');
              tempElement.textContent = `Avg Temp: ${avgtemp_f}°F`;
  
              const iconElement = document.createElement('img');
              iconElement.src = `https:${icon}`;
  
              // Append elements to the forecast div
              forecastDiv.appendChild(tempElement);
              forecastDiv.appendChild(iconElement);
  
              // Append forecast div to some parent container in your HTML
              forecastContainer.appendChild(forecastDiv);
            }
        }
    });
    
    xhr.open('GET', `https://weatherapi-com.p.rapidapi.com/forecast.json?q=${encodeURIComponent(city)}&days=3`);
    xhr.setRequestHeader('X-RapidAPI-Key', process.env.WEATHER_API_KEY);
    xhr.setRequestHeader('X-RapidAPI-Host', 'weatherapi-com.p.rapidapi.com');
    
    xhr.send(data);
  }
  