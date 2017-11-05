var map;

function initMap() {
map = new google.maps.Map(document.getElementById('map'), {
  zoom: 16,
  center: new google.maps.LatLng(38.987694, -76.940045),
  mapTypeId: 'roadmap'
});

var iconBase = 'https://maps.google.com/mapfiles/kml/paddle/';
var icons = {
  workshop: {
    icon: iconBase + 'grn-blank.png'
  },
  club: {
    icon: iconBase + 'purple-blank.png'
  },
  recruiting: {
    icon: iconBase + 'ltblu-blank.png'
  },
  techtalks: {
    icon: iconBase + 'pink-blank.png'
  }
};

var features = [
  {
    position: new google.maps.LatLng(38.986426, -76.945022),
    type: 'workshop',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.987827, -76.944936),
    type: 'workshop',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.988603, -76.941599),
    type: 'workshop',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.984892, -76.940762),
    type: 'workshop',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.985785, -76.947790),
    type: 'club',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.983508, -76.947350),
    type: 'club',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.985143, -76.941846),
    type: 'club',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.983171, -76.935344),
    type: 'club',
    title: "Event Title"

  }, {
    position: new google.maps.LatLng(38.986268, -76.937263),
    type: 'recruiting',
    title: "Event Title"

  }, {
    position: new google.maps.LatLng(38.987152, -76.940675),
    type: 'recruiting',
    title: "Event Title"

  }, {
    position: new google.maps.LatLng(38.990021, -76.935965),
    type: 'recruiting',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.986760, -76.944612),
    type: 'recruiting',
    title: "Event Title"

  }, {
    position: new google.maps.LatLng(38.984129, -76.940732),
    type: 'recruiting',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.982861, -76.946976),
    type: 'techtalks',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.983220, -76.944873),
    type: 'techtalks',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.990715, -76.936037),
    type: 'techtalks',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.990365, -76.936520),
    type: 'techtalks',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.990849, -76.938245),
    type: 'techtalks',
    title: "Event Title"
  }, {
    position: new google.maps.LatLng(38.988397, -76.944425),
    type: 'techtalks',
    title: "Event Title"
  }
];


// Create markers.
features.forEach(function(feature) {
  var marker = new google.maps.Marker({
    position: feature.position,
    icon: icons[feature.type].icon,
    title: feature.title,
    map: map
  });

  marker.addListener('click', function(){
    $("#event-modal").modal();
  });
});
}