import {LocationMap} from "./LocationMap.js";
import {LocationAPI} from "./LocationsAPI.js";

let locNameElement = document.getElementById("loc_name");

let map = new LocationMap("map");
let markers = await new LocationAPI().getAllLocations();
map.placeMarkers(markers);

locNameElement.oninput = async () => {
    let locName = locNameElement.value;
    if (locName == null || locName == "") {
        markers = await new LocationAPI().getAllLocations();
    } else {
        markers = await new LocationAPI().getLocationLike(locName);
    }
    map.placeMarkers(markers);
}