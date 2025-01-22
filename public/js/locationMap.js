const weatherData = {
    date: "2024-10-27 10:00:00",
    temperature: 20,
    humidity: 60,
    wind_speed: 15,
    wind_direction: "North",
    precipitation: 0,
    user: "John Doe",
    latitude: 52.520008, // Example latitude
    longitude: 13.404954, // Example longitude
};


map = L.map('map');
map.setView([0, 0], 7);