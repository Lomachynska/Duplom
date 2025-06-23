<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroDrop</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="icon" href="/assets/img/logo.svg">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAon25T5M-acfNx0zsg1_i-i9B8XiXaqrQ&libraries=geometry,drawing"></script>
    <script>
        let map;
        let directionsService;
        let directionsRenderer;
        let restrictedAreas = [];
        let drawingManager;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 50.4501, lng: 30.5234 }, // Центр карти (Київ)
                zoom: 12,
            });

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            // Додаємо заборонену зону у вигляді червоного квадрата на Київ
            addRestrictedArea([
                { lat: 50.445, lng: 30.515 },
                { lat: 50.445, lng: 30.535 },
                { lat: 50.455, lng: 30.535 },
                { lat: 50.455, lng: 30.515 }
            ]);

            // Ініціалізація Drawing Manager для малювання заборонених зон
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: ['polygon']
                },
                polygonOptions: {
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    editable: true,
                    draggable: true
                }
            });
            drawingManager.setMap(map);

            google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
                restrictedAreas.push(polygon);
            });

            map.addListener("click", (event) => {
                addMarker(event.latLng);
            });
        }

        function addRestrictedArea(paths) {
            const restrictedArea = new google.maps.Polygon({
                paths: paths,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
                map: map,
            });
            restrictedAreas.push(restrictedArea);
        }

        function addMarker(location) {
            const marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true,
            });

            marker.addListener('dragend', () => {
                if (isLocationRestricted(marker.getPosition())) {
                    alert("This location is restricted!");
                    marker.setMap(null);
                }
            });

            if (isLocationRestricted(location)) {
                alert("This location is restricted!");
                marker.setMap(null);
            }
        }

        function isLocationRestricted(location) {
            for (const area of restrictedAreas) {
                if (google.maps.geometry.poly.containsLocation(location, area)) {
                    return true;
                }
            }
            return false;
        }

        function calculateAndDisplayRoute() {
            const start = { lat: 50.4501, lng: 30.5234 }; // Початкова точка
            const end = { lat: 50.4547, lng: 30.5238 }; // Кінцева точка

            directionsService.route(
                {
                    origin: start,
                    destination: end,
                    travelMode: google.maps.TravelMode.DRIVING,
                    avoidPolygons: restrictedAreas.map(area => area.getPath().getArray()),
                },
                (response, status) => {
                    if (status === "OK") {
                        directionsRenderer.setDirections(response);
                    } else {
                        alert("Directions request failed due to " + status);
                    }
                }
            );
        }
    </script>
</head>

<body onload="initMap()">
    <div class="wrapper">
        <?php require_once './templates/header.php'; ?>

        <main class="crm">
            <?php require_once './templates/sidebar.php'; ?>

            <div class="crm__content">
                <div id="map" style="height: 500px; width: 100%;"></div>
                <button onclick="calculateAndDisplayRoute()">Calculate Route</button>
            </div>
        </main>
    </div>
</body>

</html>