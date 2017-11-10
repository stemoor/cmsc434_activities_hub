class Marker{
  constructor(latitude, longitude){
    this.position = new google.maps.LatLng(latitude, longitude);
    this.id = id;
  }

  get position() {
    return this.position;
  }

  get type () {
    return this.type;
  }
}

class Location {
    constructor(address, number, latitude, longitude){
        this.address = address;
        this.number = number;
        this.latitude = latitude;
        this.longitute = longitude;
    }

    get address(){
        return this.address;
    }

    get addressNumber() {
        return this.number;
    }

    get latitude(){
        return this.latitude;
    }

    get longitute () {
        return this.longitute;
    }
}

class DateTime{

    constructor(day, month, year, hour, min){
        this.day = day;
        this.month = month;
        this.year = year;
        this.hour = hour;
        this.min = min;
    }

    get dateString() {
        return this.month + "/" + this.day + "/" + this.year;
    }

    get timeString(){
        return this.hour + ":" + this.min;
    }
}

class Event {
    constructor(title, startDateTime, endDateTime, location){
        this.title = title;
        this.startDateTime = startDateTime;
        this.endDateTime = endDateTime;
        this.location = location;
        this.marker = new Marker(location.latitude, location.longitute);

    }

    get title(){
        return this.title;
    }

    get location(){
        return this.location;
    }

    get startDateTime(){
        return this.startDateTime;
    }

    get endDateTime() {
        return this.endDateTime;
    }

    get marker() {
        return this.marker;
    }
}


