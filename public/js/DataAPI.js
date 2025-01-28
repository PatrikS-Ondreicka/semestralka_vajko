import {DataService} from "./DataService.js";

class DataAPI extends DataService {

    constructor() {
        super("dataApi");
    }

    async getAllData(minDate, maxDate, location) {
        return await this.sendRequest(
            "getAllData" + this.toRequestArg('minDate', minDate) + this.toRequestArg('maxDate', maxDate) + this.toRequestArg('location', location),
            "POST",
            200,
            null,
            []);
    }

    async getUserData(userId) {
        return await this.sendRequest(
            "getUserData" + this.toRequestArg("userId", userId),
            "POST",
            200,
            null,
            []);
    }

    async getOne(id) {
        return await this.sendRequest(
            "getOne" + this.toRequestArg("id", id),
            "POST",
            200,
            null,
            []);
    }

    async getPrecipitation(minDate, maxDate, location){
        return await this.sendRequest(
            "getPrecipitation" + this.toRequestArg('minDate', minDate) + this.toRequestArg('maxDate', maxDate) + this.toRequestArg('location', location),
            "POST",
            200,
            null,
            []);
    }

    async getTemperature(minDate, maxDate, location){
        return await this.sendRequest(
            "getTemperature" + this.toRequestArg('minDate', minDate) + this.toRequestArg('maxDate', maxDate) + this.toRequestArg('location', location),
            "POST",
            200,
            null,
            []);
    }

    async getHumidity(minDate, maxDate, location){
        return await this.sendRequest(
            "getHumidity"+ this.toRequestArg('minDate', minDate) + this.toRequestArg('maxDate', maxDate) + this.toRequestArg('location', location),
            "POST",
            200,
            null,
            []);
    }

    async getWindSpeed(minDate, maxDate, location){
        return await this.sendRequest(
            "getWindSpeed"+ this.toRequestArg('minDate', minDate) + this.toRequestArg('maxDate', maxDate) + this.toRequestArg('location', location),
            "POST",
            200,
            null,
            []);
    }
}

export {DataAPI}