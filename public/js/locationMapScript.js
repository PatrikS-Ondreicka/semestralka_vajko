import {LocationMap} from "./LocationMap.js";
import {LocationAPI} from "./LocationsAPI.js";

let map = new LocationMap("map");
let markers = await new LocationAPI().getAllLocations();
map.placeMarkers(markers);
