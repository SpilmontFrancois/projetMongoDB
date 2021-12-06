const defaultPoint = { lat: 48.683207, lng: 6.161713 }

function initMap() {
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: defaultPoint,
    })

    const userMarker = new google.maps.Marker({
        position: map.getCenter(),
        map: map,
    })

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                }

                map.setCenter(pos)
                defaultPoint = pos
                userMarker.setPosition(pos)
            },
            () => {
                // Browser has geolocation --> fail
                //handleLocationError(true, infoWindow, map.getCenter())
            }
        )
    } else {
        // Browser doesn't support Geolocation
        //handleLocationError(false, infoWindow, map.getCenter())
    }
}
