
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
          window.location.href = 'login.html'; 
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
  