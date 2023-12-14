
// Define a function to toggle the visibility of a password field.
function togglePasswordVisibility(passwordFieldId, toggleIcon) {
  // Get the DOM element for the password field using its ID.
  var passwordField = document.getElementById(passwordFieldId);

  // Check if the current type of the password field is 'password'.
  if (passwordField.type === "password") {
    // If it is 'password', change the type to 'text' to show the password.
    passwordField.type = "text";
    // Remove the 'fa-eye' class to change the icon to an open eye (visible).
    toggleIcon.classList.remove('fa-eye');
    // Add the 'fa-eye-slash' class to change the icon to a slashed eye (indicating visibility).
    toggleIcon.classList.add('fa-eye-slash');
  } else {
    // If the type is not 'password', change it back to 'password' to hide the text.
    passwordField.type = "password";
    // revert the icon to the slashed eye (hidden).
    toggleIcon.classList.remove('fa-eye-slash');
    // change the icon back to an open eye.
    toggleIcon.classList.add('fa-eye');
  }
}

  // This ensures the script runs after the DOM is fully loaded.
  document.addEventListener('DOMContentLoaded', (event) => {

    // Listener for the registration form submission
    var registerForm = document.getElementById('register');
    if (registerForm) {
      registerForm.addEventListener('submit', function(event){
        event.preventDefault();
        
        var newUsername = document.getElementById('new-username').value;
        var newPassword = document.getElementById('password').value; // Corrected ID
        var confirmPassword = document.getElementById('confirm-password').value;
        var passwordError = document.getElementById('password-error');
        
        // Check if the passwords match
        if(newPassword !== confirmPassword){ // Use !== for inequality
          // If passwords don't match, show the error
          passwordError.style.display = 'block';
        } else {
          // If passwords match, hide the error and proceed
          passwordError.style.display = 'none';
          alert('User successfully created');
          
          // Log new username and password
          console.log("New Username: " + newUsername);
          console.log("New Password: " + newPassword);
    
          // Redirect to login on successful registration
          window.location.href = 'Login Page.html'; 
        }
      });
    }

  // Listener for the "Create New User" button click
  var createUserButton = document.getElementById('createUser');
  if (createUserButton) {
    createUserButton.addEventListener('click', function(){
      // Redirect to the registration page
      window.location.href = 'register.html'; 
    });
  }
});

document.addEventListener('DOMContentLoaded', (event) => {
  var loginForm = document.getElementById('login-form-id'); // Replace with your form's ID

  if (loginForm) {
    loginForm.addEventListener('submit', function(event) {
      event.preventDefault();

      var username = document.getElementById('username-id').value; // Replace with your username field's ID
      var password = document.getElementById('password-id').value; // Replace with your password field's ID

      // Add your login validation logic here

      // Redirect to the Location Page on successful login
      window.location.href = 'Location Page.html'; // Replace with your location page's filename
    });
  }
});


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

function fetchForecastForCity(city) {
  const forecastContainer = document.getElementById('forecast-container');
  forecastContainer.innerHTML = ''; // Clear existing forecasts

  // Generate dates for today and the next two days
  const dates = [new Date(), new Date(), new Date()];
  dates[1].setDate(dates[1].getDate() + 1); // Tomorrow
  dates[2].setDate(dates[2].getDate() + 2); // Day after tomorrow

  // Assume the first promise (today's date) includes the current weather data
  const promises = dates.map((date, index) => {
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.withCredentials = true;

      xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
          resolve(JSON.parse(this.responseText));
        } else if (this.readyState === XMLHttpRequest.DONE) {
          reject(new Error("Error in API request"));
        }
      };

      const formattedDate = date.toISOString().split('T')[0];
      xhr.open('GET', `https://weatherapi-com.p.rapidapi.com/forecast.json?q=${encodeURIComponent(city)}&days=1&dt=${formattedDate}`);
      xhr.setRequestHeader('X-RapidAPI-Key', '5a1f892a6fmsh79b914fdd2d4469p1d85fejsnfd6c65fa4b63');
      xhr.setRequestHeader('X-RapidAPI-Host', 'weatherapi-com.p.rapidapi.com');
      xhr.send();
    });
  });

  Promise.all(promises).then(responses => {
    responses.forEach((response, index) => {
      const forecastDay = response.forecast.forecastday[0];
      const maxtemp_f = forecastDay.day.maxtemp_f;
      const mintemp_f = forecastDay.day.mintemp_f;
      const icon = forecastDay.day.condition.icon;
      const date = dates[index];
      const dayOfWeek = date.toLocaleDateString('en-US', { weekday: 'long' });

      // Create and append HTML elements for each forecast
      const forecastDiv = document.createElement('div');
      forecastDiv.className = 'forecast';

      const dayElement = document.createElement('p');
      dayElement.className = 'day-of-week';
      dayElement.textContent = dayOfWeek;
      forecastDiv.appendChild(dayElement);

      const highLowElement = document.createElement('p');
      highLowElement.textContent = `High: ${maxtemp_f}°F, Low: ${mintemp_f}°F`;
      forecastDiv.appendChild(highLowElement);

      // If it's the first day (today), add the current weather data
      if (index === 0 && response.current) {
        const currentTemp_f = response.current.temp_f;
        const currentCondition = response.current.condition.text;

        const currentTempElement = document.createElement('p');
        currentTempElement.textContent = `Current: ${currentTemp_f}°F - ${currentCondition}`;
        forecastDiv.insertBefore(currentTempElement, highLowElement);
      }

      const iconElement = document.createElement('img');
      iconElement.src = `https:${icon}`;
      forecastDiv.appendChild(iconElement);

      forecastContainer.appendChild(forecastDiv);
    });
  }).catch(error => {
    console.error("Error in API requests:", error);
  });
}

function locateUser() {
  if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function(position) {
      getWeather(position.coords.latitude, position.coords.longitude);
    }, function(error) {
      console.log("Error occurred: ", error);
    });
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
}

function getWeather(latitude, longitude) {
  const xhr = new XMLHttpRequest();
  xhr.withCredentials = true;

  xhr.addEventListener('readystatechange', function () {
    if (this.readyState === this.DONE) {
      // Parse the responseText to a JSON object
      const response = JSON.parse(this.responseText);
      // Display the weather information on the page
      displayWeather(response);
    }
  });

  const endpoint = `https://weatherapi-com.p.rapidapi.com/current.json?q=${latitude},${longitude}`;
  xhr.open('GET', endpoint);
  xhr.setRequestHeader('X-RapidAPI-Key', '5a1f892a6fmsh79b914fdd2d4469p1d85fejsnfd6c65fa4b63');
  xhr.setRequestHeader('X-RapidAPI-Host', 'weatherapi-com.p.rapidapi.com');
  xhr.send();
}

function displayWeather(weatherData) {
  // Here you would take the weatherData object and display the desired properties on the page
  // For example:
  const weatherContainer = document.getElementById('weather-container'); // Make sure to add this container to your HTML
  weatherContainer.innerHTML = `
    <p>City: ${weatherData.location.name}</p>
    <p>Temperature: ${weatherData.current.temp_c}°C / ${weatherData.current.temp_f}°F</p>
    <p>Condition: ${weatherData.current.condition.text}</p>
    <img src="https:${weatherData.current.condition.icon}" alt="Weather Icon">
  `;
}


