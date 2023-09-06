

var id;

var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
  };

if(navigator.geolocation){
   id = navigator.geolocation.watchPosition(mostrarGPS, erroGps, options)
   console.log(id);
}
else
{
    console.log("Erro no gps")
}

function mostrarGPS(pos)
{
    //long.value = pos.coords.longitude
    //lati.value = pos.coords.latitude
    //teste.innerHTML = "lon="+pos.coords.longitude+"&lat="+pos.coords.latitude
    //accuracy.innerHTML = pos.coords.accuracy
    //console.log(pos.timestamp)

      window.navigator.geolocation.clearWatch(id);
      window.livewire.emit('set:latitude-longitude', pos.coords.latitude, pos.coords.longitude, pos.coords.accuracy);
}

function erroGps()
{
    console.log("erro no gps")
}

