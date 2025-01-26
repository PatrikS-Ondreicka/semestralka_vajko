import {DataService} from "./DataService.js";

class DataAPI extends DataService {

    constructor() {
        super("dataApi");
    }

    async getAllData() {
        return await this.sendRequest(
            "getAllData",
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

    async getPrecipitation(){
        return await this.sendRequest(
            "getPrecipitation",
            "POST",
            200,
            null,
            []);
    }

    async getTemperature(){
        return await this.sendRequest(
            "getTemperature",
            "POST",
            200,
            null,
            []);
    }

    async getHumidity(){
        return await this.sendRequest(
            "getHumidity",
            "POST",
            200,
            null,
            []);
    }

    async getWindSpeed(){
        return await this.sendRequest(
            "getWindSpeed",
            "POST",
            200,
            null,
            []);
    }
}

export {DataAPI}