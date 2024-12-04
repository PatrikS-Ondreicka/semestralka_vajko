function makeErrorDiv(parent, message) {
    let errorMessage = document.createElement('div');
    errorMessage.innerHTML = message;
    errorMessage.style.color = "red";
    parent.append(errorMessage);
}

function formCheck() {
    let result = true;
    let windDirectionVals = ['N', 'S', 'E', 'W', 'NE', 'NW', 'SE', 'SW'];

    let tempInput = document.getElementById('temperature');
    let humInput = document.getElementById('humidity');
    let windSpeed = document.getElementById('wind_speed');
    let windDirection = document.getElementById('wind_direction');
    let precipInput = document.getElementById('precipitation');

    let errorDiv = document.getElementById('errors');
    errorDiv.innerHTML = "";

    if (tempInput.value < -90.0 || tempInput.value > 57.0) {
        result = false;
        makeErrorDiv(errorDiv, "Value of temperature must be between -90.0 and 57.0");
    }

    if (humInput.value < 0 || humInput.value > 100) {
        result = false;
        makeErrorDiv(errorDiv, "Value of humidity must be between 0 and 100");
    }

    if (windSpeed.value < 0) {
        result = false;
        makeErrorDiv(errorDiv, "Value of wind speed must be greater or equal to 0");
    }

    let selectedIndex = windDirection.selectedIndex;
    let selectedValue = windDirection.options[selectedIndex];
    if (!windDirectionVals.includes(selectedValue.value)) {
        result = false;
        makeErrorDiv(errorDiv, "Unsupported wind direction value");
    }

    if (precipInput.value < 0) {
        result = false;
        makeErrorDiv(errorDiv, "Value of precipitation must be greater or equal to 0");
    }
    return result;
}