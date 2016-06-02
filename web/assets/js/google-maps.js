export default (function initMap() {
  var a = 'prostir';
  var b = [{featureType: "all", elementType: "all", stylers: [{invert_lightness: true}, {saturation: -100}]}];
  var c = {
    center: new google.maps.LatLng(50.414385, 30.519246),
    zoom: 16,
    panControl: false,
    zoomControl: true,
    scaleControl: true,
    scrollwheel: false,
    mapTypeControl: false,
    mapTypeId: a
  };
  var mapDOM = document.getElementById('map');

  if (mapDOM) {
    var d = new google.maps.Map(mapDOM, c);
    var e = new google.maps.Marker({position: c.center, map: d, title: "", icon: "/assets/img/map-marker.png"});
    var f = {name: "Grayscale"};
    var g = new google.maps.StyledMapType(b, f);
    d.mapTypes.set(a, g);
  }
}())
