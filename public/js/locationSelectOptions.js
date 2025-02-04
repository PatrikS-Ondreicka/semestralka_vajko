import {SelectMap} from "./SelectMap.js"
import {LocationAPI} from "./LocationsAPI.js"

let locationAPI = new LocationAPI()

let manualRadio = document.querySelectorAll('input[name="selection_mode"][value="manual"]')[0];
let mapRadio = document.querySelectorAll('input[name="selection_mode"][value="map"]')[0];
let nameBox = document.getElementById('loc_name');
let latBox = document.getElementById('lat');
let lonBox = document.getElementById('lon');
let map;

let selectionContentDiv = document.getElementById('location_selection_content');

function mapInit() {
    console.log(document.getElementById("map"));
    map = new SelectMap("map");
    map.setLatElement("lat");
    map.setLonElement("lon");
}

function setContentVisible (content, content_class_name)
{
    let contentArray = document.querySelectorAll("." + content_class_name);
    Array.from(contentArray).forEach((item) => {item.style.display = "none";});
    content.style.display = "flex";
}

async function fetchByName() {
    let name = nameBox.value;
    let selectedRadio = document.querySelector('input[name="selection_mode"]:checked');
    let fetched_location = await locationAPI.getLocation(name);
    if (fetched_location.length == 0) {
        map.removeMarker();
        latBox.value = ""
        lonBox.value = ""
        return;
    }
    let latlng = L.latLng(fetched_location[0].lat, fetched_location[0].lon);
    map.placeMarker(latlng);
    map.setView(latlng);
    latBox.value = fetched_location[0].lat;
    lonBox.value = fetched_location[0].lon;
}

manualRadio.onchange = () => {
    let content = document.getElementById('man_selection_content');
    setContentVisible(content, "selection_content");
}

mapRadio.onchange =  () => {
    let content = document.getElementById('map_selection_content');
    setContentVisible(content, "selection_content");
}

nameBox.onchange = () => fetchByName();

mapInit();