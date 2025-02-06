import {DataService} from "./DataService.js";

class LocationAPI extends DataService {

    constructor() {
        super("locationApi");
    }

    async getAllLocations() {
        return await this.sendRequest(
            "getAllLocations",
            "POST",
            200,
            null,
            []);
    }

    async getLocation(name) {
        return await this.sendRequest(
            "getLocation" + this.toRequestArg("locName", name),
            "POST",
            200,
            null,
            []);
    }

    async getLocationLike(name) {
        return await this.sendRequest(
            "getLocationLike" + this.toRequestArg("locName", name),
            "POST",
            200,
            null,
            []);
    }
}

export {LocationAPI};