<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroDrop</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="icon" href="./assets/img/logo.svg">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <style>
        #map {
            z-index: 1;
        }

        .custom-marker {
            background: white;
            border: 2px solid;
            border-radius: 50%;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .start-marker {
            border-color: #28a745;
            color: #28a745;
        }
        .end-marker {
            border-color: #dc3545;
            color: #dc3545;
        }
        .marker-icon {
            font-size: 16px;
        }
        .icon{
            background-image: url('/assets/img/post.svg');
            min-width: 16px;
            min-height: 16px;
        }
        .postomat-marker {
            cursor: pointer;
            background: rgb(200, 255, 186);
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .postomat-marker i {
            color: #007bff;
            font-size: 16px;
        }
        .restricted-area-label {
            background: transparent;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 14px;
            color: #dc3545;
            font-weight: 600;
            box-shadow: none;
            text-align: center;
            min-width: 160px;
            pointer-events: none;
        }
        #map {
            height: 600px;
            width: 100%;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php require_once './templates/header.php'; ?>

        <main class="main main--no-margin">
            <div class="container">
                <h2 style="margin: 48px 0">Карта поштоматів</h2>

                <div id="map"></div>
            </div>
        </main>

        <?php require_once './templates/footer.php'; ?>
        <script>
            let map;
            let postomats = [
                { lat: 50.94875023652429, lng: 30.87463603722265, name: "Поштомат #1" },
                { lat: 50.94775023652429, lng: 30.87563603722265, name: "Поштомат #2" },
                { lat: 50.95275024652439, lng: 30.88663603722265, name: "Поштомат #3" }
            ];

            function initMap() {
                map = L.map('map').setView([50.95275023652429, 30.87663603722265], 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                addRestrictedArea();
                addPostomats();
            }

            function addRestrictedArea() {
                const restrictedZones = [
                    {
                        type: "polygon",
                        name: "Обмежена зона для польотів",
                        coords: [
                            [50.955, 30.87],
                            [50.956, 30.872],
                            [50.957, 30.875],
                            [50.956, 30.878],
                            [50.954, 30.879],
                            [50.953, 30.876],
                            [50.954, 30.872]
                        ]
                    },
                    {
                        type: "circle",
                        name: "Обмежена зона для польотів",
                        center: [50.945, 30.87],
                        radius: 350
                    },
                    {
                        type: "polygon",
                        name: "Обмежена зона для польотів",
                        coords: [
                            [50.96, 30.88],
                            [50.961, 30.885],
                            [50.962, 30.889],
                            [50.96, 30.89],
                            [50.958, 30.888],
                            [50.958, 30.883]
                        ]
                    }
                ];
                restrictedZones.forEach(zone => {
                    let area, center;
                    if (zone.type === "polygon") {
                        area = L.polygon(zone.coords, {
                            color: '#dc3545',
                            weight: 2,
                            opacity: 0.8,
                            fillColor: '#dc3545',
                            fillOpacity: 0.2
                        }).addTo(map);
                        center = area.getBounds().getCenter();
                    } else if (zone.type === "circle") {
                        area = L.circle(zone.center, {
                            color: '#dc3545',
                            weight: 2,
                            opacity: 0.8,
                            fillColor: '#dc3545',
                            fillOpacity: 0.2,
                            radius: zone.radius
                        }).addTo(map);
                        center = area.getLatLng();
                    }
                    L.marker(center, {
                        icon: L.divIcon({
                            className: 'restricted-area-label',
                            html: zone.name,
                            iconSize: [160, 24]
                        }),
                        interactive: false
                    }).addTo(map);
                    area.on('click', function(e) {
                        e.originalEvent.preventDefault();
                        e.originalEvent.stopPropagation();
                    });
                });
            }

            function addPostomats() {
                postomats.forEach((postomat, index) => {
                    const icon = L.divIcon({
                        className: 'postomat-marker',
                        html: '<i class="icon"></i>',
                        iconSize: [32, 32],
                        iconAnchor: [16, 16]
                    });
                    L.marker([postomat.lat, postomat.lng], {
                        icon: icon
                    }).addTo(map)
                    .bindPopup(postomat.name);
                });
            }
            document.addEventListener('DOMContentLoaded', initMap);
        </script>
    </div>
</body>

</html>