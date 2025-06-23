<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroDrop</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="icon" href="/assets/img/logo.svg">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <style>
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
            background: rgb(200, 255, 186);;
            /* border: 2px solidrgb(170, 255, 148); */
            /* border-radius: 50%; */
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
            /* border: 1px solid #dc3545; */
            text-align: center;
            min-width: 160px;
            pointer-events: none;
        }
    </style>
    <script>
        let map;
        let markers = [];
        let distanceDisplay;
        let route;
        let restrictedArea;
        let postomats = [
        
            { lat: 50.94875023652429, lng: 30.87463603722265, name: "Поштомат #1" },
            { lat: 50.94775023652429, lng: 30.87563603722265, name: "Поштомат #2" },
            { lat: 50.95275024652439, lng: 30.88663603722265, name: "Поштомат #3" }
        ];
        let postomatMarkers = [];
        let routingControl;

        function initMap() {
            map = L.map('map').setView([50.95275023652429, 30.87663603722265], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            addRestrictedArea();
            addPostomats();

            distanceDisplay = document.getElementById("distance");
        }

        function addRestrictedArea() {
            // Масив зон різної форми
            const restrictedZones = [
                // Полігон-пляма
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
                // Коло
                {
                    type: "circle",
                    name: "Обмежена зона для польотів",
                    center: [50.945, 30.87],
                    radius: 350 // у метрах
                },
                // Ще одна пляма
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

            window.restrictedAreas = [];

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

                // Додаємо підпис з назвою зони (завжди видно)
                L.marker(center, {
                    icon: L.divIcon({
                        className: 'restricted-area-label',
                        html: zone.name,
                        iconSize: [160, 24]
                    }),
                    interactive: false
                }).addTo(map);

                // Вимикаємо popups/клік
                area.on('click', function(e) {
                    e.originalEvent.preventDefault();
                    e.originalEvent.stopPropagation();
                });

                window.restrictedAreas.push(area);
            });

            // Центруємо карту на Остері
            map.setView([50.95275023652429, 30.87663603722265], 14);
        }

        function isLocationRestricted(latlng) {
            if (!restrictedArea) return false;

            const polygon = restrictedArea.getLatLngs()[0];
            let inside = false;

            for (let i = 0, j = polygon.length - 1; i < polygon.length; j = i++) {
                const xi = polygon[i].lat, yi = polygon[i].lng;
                const xj = polygon[j].lat, yj = polygon[j].lng;

                if (((yi > latlng.lng) !== (yj > latlng.lng)) &&
                    (latlng.lat < (xj - xi) * (latlng.lng - yi) / (yj - yi) + xi)) {
                    inside = !inside;
                }
            }

            return inside;
        }

        function doLinesIntersect(line1Start, line1End, line2Start, line2End) {
            function orientation(p, q, r) {
                const val = (q.lng - p.lng) * (r.lat - p.lat) -
                    (q.lat - p.lat) * (r.lng - p.lng);
                if (val === 0) return 0;
                return (val > 0) ? 1 : 2;
            }

            const o1 = orientation(line1Start, line1End, line2Start);
            const o2 = orientation(line1Start, line1End, line2End);
            const o3 = orientation(line2Start, line2End, line1Start);
            const o4 = orientation(line2Start, line2End, line1End);

            return (o1 !== o2 && o3 !== o4);
        }

        function doesRouteCrossRestrictedArea(start, end) {
            if (!restrictedArea) return false;

            const polygon = restrictedArea.getLatLngs()[0];

            // Перевіряємо перетин з кожною стороною полігону
            for (let i = 0; i < polygon.length; i++) {
                const j = (i + 1) % polygon.length;
                if (doLinesIntersect(start, end, polygon[i], polygon[j])) {
                    return true;
                }
            }

            // Перевіряємо точки маршруту
            if (isLocationRestricted(start) || isLocationRestricted(end)) {
                return true;
            }

            // Перевіряємо проміжні точки
            const steps = 10;
            for (let i = 1; i < steps; i++) {
                const point = {
                    lat: start.lat + (end.lat - start.lat) * (i / steps),
                    lng: start.lng + (end.lng - start.lng) * (i / steps)
                };
                if (isLocationRestricted(point)) {
                    return true;
                }
            }

            return false;
        }

        function findRouteAroundObstacle(start, end) {
            if (!restrictedArea) return [start, end];

            const polygon = restrictedArea.getLatLngs()[0];
            const bounds = {
                minLat: Math.min(...polygon.map(p => p.lat)),
                maxLat: Math.max(...polygon.map(p => p.lat)),
                minLng: Math.min(...polygon.map(p => p.lng)),
                maxLng: Math.max(...polygon.map(p => p.lng))
            };

            const offset = 0.002; // ~200 метрів від обмеженої зони
            let routePoints = [];

            // Додаємо початкову точку
            routePoints.push(start);

            // Визначаємо оптимальний шлях обходу
            const startToEnd = {
                lat: end.lat - start.lat,
                lng: end.lng - start.lng
            };

            // Визначаємо, з якого боку краще обійти зону
            const centerLat = (bounds.minLat + bounds.maxLat) / 2;
            const centerLng = (bounds.minLng + bounds.maxLng) / 2;

            if (Math.abs(startToEnd.lat) > Math.abs(startToEnd.lng)) {
                // Обхід з півночі або півдня
                const goNorth = start.lat + end.lat > 2 * centerLat;
                const lat = goNorth ? bounds.maxLat + offset : bounds.minLat - offset;
                routePoints.push(L.latLng(lat, start.lng));
                routePoints.push(L.latLng(lat, end.lng));
            } else {
                // Обхід зі сходу або заходу
                const goEast = start.lng + end.lng > 2 * centerLng;
                const lng = goEast ? bounds.maxLng + offset : bounds.minLng - offset;
                routePoints.push(L.latLng(start.lat, lng));
                routePoints.push(L.latLng(end.lat, lng));
            }

            // Додаємо кінцеву точку
            routePoints.push(end);

            return routePoints;
        }

        function addPostomats() {
            postomats.forEach((postomat, index) => {
                const icon = L.divIcon({
                    className: 'postomat-marker',
                    html: '<i class="icon"></i>',
                    iconSize: [32, 32],
                    iconAnchor: [16, 16]
                });

                const marker = L.marker([postomat.lat, postomat.lng], {
                    icon: icon
                }).addTo(map);

                marker.bindPopup(postomat.name);
                postomatMarkers.push(marker);

                marker.on('click', () => {
                    if (markers.length < 2) {
                        addMarker(L.latLng(postomat.lat, postomat.lng), true);
                    } else {
                        alert("Ви вже вибрали обидві точки. Щоб змінити, видаліть одну з точок (правий клік)");
                    }
                });
            });
        }

        async function getAddressFromCoordinates(lat, lng) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                const data = await response.json();
                if (data.display_name) {
                    // Повертаємо повну адресу
                    return data.display_name;
                }
                return 'Адресу не знайдено';
            } catch (error) {
                console.error('Помилка отримання адреси:', error);
                return 'Помилка отримання адреси';
            }
        }

        function addMarker(location, isPostomat = false) {
            const icon = L.divIcon({
                className: markers.length === 0 ? 'custom-marker start-marker' : 'custom-marker end-marker',
                html: markers.length === 0 ? '<i class="fas fa-flag marker-icon"></i>' : '<i class="fas fa-flag-checkered marker-icon"></i>',
                iconSize: [32, 32],
                iconAnchor: [16, 16]
            });

            const marker = L.marker(location, {
                icon: icon,
                draggable: false
            }).addTo(map);

            markers.push(marker);

            // Оновлюємо відображення адреси
            if (markers.length === 1) {
                getAddressFromCoordinates(location.lat, location.lng).then(address => {
                    document.getElementById('start-address').textContent = address;
                });
                document.getElementById('start_point').value = `${location.lat},${location.lng}`;
            } else if (markers.length === 2) {
                getAddressFromCoordinates(location.lat, location.lng).then(address => {
                    document.getElementById('end-address').textContent = address;
                });
                document.getElementById('end_point').value = `${location.lat},${location.lng}`;
            }

            marker.on('contextmenu', () => {
                removeMarker(marker);
            });

            if (markers.length === 2) {
                calculateDistance();
            }
        }

        function removeMarker(marker) {
            map.removeLayer(marker);
            const index = markers.indexOf(marker);
            markers = markers.filter(m => m !== marker);
            // Очищаємо відповідну адресу та координати
            if (index === 0) {
                document.getElementById('start-address').textContent = 'Оберіть точку на карті';
                document.getElementById('start_point').value = '';
            } else {
                document.getElementById('end-address').textContent = 'Оберіть точку на карті';
                document.getElementById('end_point').value = '';
            }
            if (route) {
                map.removeLayer(route);
            }
            distanceDisplay.textContent = "0 км";
            document.querySelector("[name='price']").value = "";
        }

        function calculateDistance() {
            if (markers.length === 2) {
                const start = markers[0].getLatLng();
                const end = markers[1].getLatLng();

                // Видаляємо попередній маршрут, якщо він є
                if (routingControl) {
                    map.removeControl(routingControl);
                }

                routingControl = L.Routing.control({
                    waypoints: [
                        L.latLng(start.lat, start.lng),
                        L.latLng(end.lat, end.lng)
                    ],
                    routeWhileDragging: false,
                    draggableWaypoints: false,
                    addWaypoints: false,
                    show: false,
                    lineOptions: {
                        styles: [{ color: '#007bff', weight: 5 }]
                    },
                    createMarker: function() { return null; }
                }).addTo(map);

                routingControl.on('routesfound', function(e) {
                    const route = e.routes[0];
                    const distanceKm = (route.summary.totalDistance / 1000).toFixed(2);
                    distanceDisplay.textContent = distanceKm + ' км';
                    document.querySelector('.price__value').innerHTML = (100 * distanceKm).toFixed(2) + ' грн';
                    document.querySelector('[name="price"]').value = (100 * distanceKm).toFixed(2);
                    document.querySelector('[name="distance"]').value = distanceKm;
                });
            }
        }
    </script>
</head>

<body onload="initMap()">
    <div class="wrapper">
        <?php require_once './templates/header.php'; ?>

        <main class="crm">
            <?php require_once './templates/sidebar.php'; ?>

            <div class="crm__content">

                <form class="form form--setttings" action="" method="post">

                    <div class="form__inner">
                        <h5>Створити замовлення</h5>
                        <div class="form__list">
                            <div class="form__item">
                                <label for="truck_type">Тип вантажу (обов'язково)</label>
                                <!-- <input type="text" name="truck_type" placeholder="Truck type"> -->
                                <select name="truck_type" id="" required>
                                    <option value="clothing">Одяг</option>
                                    <option value="food">Їжа</option>
                                    <option value="electronics">Електроніка</option>
                                    <option value="furniture">Меблі</option>
                                    <option value="books">Книги</option>
                                </select>
                            </div>

                            <div class="form__col-2">
                                <div class="form__item">
                                    <label for="weight">Вага кг. (обов'язково)</label>
                                    <input type="number" name="weight" placeholder="Вага " required>
                                </div>
                                <div class="form__item">
                                    <label for="size">Розмір (обов'язково)</label>
                                    <!-- <input type="text" name="size" placeholder="Size"> -->
                                    <select name="size" id="" required>
                                        <option value="sm">до 20см.</option>
                                        <option value="lg">до 80см.</option>
                                        <option value="xl">до 160 см.</option>
                                    </select>
                                </div>
                            </div>



                            <div class="form__item">
                                <label for="description">Опис</label>
                                <textarea placeholder="Введіть опис замовлення" name="description"
                                    id="description"></textarea>
                            </div>

                            <div class="form__item">
                                <label for="time">Розрахунковий час доставки (обов'язково)</label>
                                <input type="datetime-local" name="time" id="time" required>
                            </div>

                            <div style="display: flex; align-items: center; gap: 6px;">
                                <input type="checkbox" name="delivery_in_hands" id="delivery_in_hands">
                                <label for="">Доставка в руки</label>
                            </div>

                            <script>
                                const deliveryInHandsCheckbox = document.getElementById('delivery_in_hands');
                                deliveryInHandsCheckbox.addEventListener('change', function () {
                                    const formList = deliveryInHandsCheckbox.closest('.form__list');
                                    const additionalFields = document.querySelectorAll('.form__item[data-delivery-in-hands]');

                                    if (this.checked) {
                                        if (additionalFields.length === 0) {
                                            const recognitionField = document.createElement('div');
                                            recognitionField.className = 'form__item';
                                            recognitionField.setAttribute('data-delivery-in-hands', '');
                                            recognitionField.innerHTML = `
                                                <label for="recognition">Як тебе впізнати</label>
                                                <textarea placeholder="Наприклад, у червоній куртці" name="recognition" id="recognition"></textarea>
                                            `;

                                            const instructionsField = document.createElement('div');
                                            instructionsField.className = 'form__item';
                                            instructionsField.setAttribute('data-delivery-in-hands', '');
                                            instructionsField.innerHTML = `
                                                <label for="delivery_instructions">Як передати</label>
                                                <textarea placeholder="Наприклад, залишити біля дверей" name="delivery_instructions" id="delivery_instructions"></textarea>
                                            `;

                                            formList.appendChild(recognitionField);
                                            formList.appendChild(instructionsField);
                                        }
                                    } else {
                                        additionalFields.forEach(field => field.remove());
                                    }
                                });
                            </script>

                        </div>
                    </div>

                    <div class="form__inner">
                        <h5>Інформація про доставку / ціна</h5>
                        <div class="form__list">

                            <div class="form__col-2">
                                <div class="form__item">
                                    <input type="hidden" id="start_point" name="start_point"
                                        placeholder="Точка відправлення" readonly required>
                                </div>
                                <div class="form__item">
                                    <input type="hidden" id="end_point" name="end_point" placeholder="Точка доставки"
                                        readonly required>
                                </div>
                            </div>

                            <div id="map" style="height: 400px; width: 100%;"></div>
                            <div class="form__item">
                                <!-- <label for="distance">Distance</label> -->
                                <span id="distance">0 км</span>
                                <input type="hidden" name="distance">
                            </div>
                        </div>
                    </div>

                        <div class="address-info" style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; width: 100%;">
                            <div style="display: flex; justify-content: space-between; gap: 20px;">
                                <div style="flex: 1;">
                                    <h5 style="color: #666; margin-bottom: 10px; font-size: 1.1em;">Місце відправки:</h5>
                                    <p id="start-address" style="color: #333; font-weight: 500; margin: 0;">Оберіть точку на карті</p>
                                </div>
                                <div style="flex: 1;">
                                    <h5 style="color: #666; margin-bottom: 10px; font-size: 1.1em;">Місце отримання:</h5>
                                    <p id="end-address" style="color: #333; font-weight: 500; margin: 0;">Оберіть точку на карті</p>
                                </div>
                            </div>
                        </div>
                        
                    <div class="form__btns">
                        <div class="price">
                            <span>100 грн за кілометр</span>
                            <h4 class="price__value"></h4>
                            <input type="hidden" name="price" readonly>
                        </div>


                        <button class="btn btn-primary btn-bg" type="submit">Створити</button>
                    </div>

                </form>
            </div>

        </main>

    </div>
</body>

</html>