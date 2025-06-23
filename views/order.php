<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
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
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
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
            height: 400px;
            width: 100%;
            margin: 20px 0;
        }
    </style>
    <script>
        let map;
        let routingControl;
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
            addOrderRoute();
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
        async function snapToRoad(lat, lng) {
            try {
                // Note: OSRM expects [lng, lat] order
                const response = await fetch(`https://routing.openstreetmap.de/routed-car/nearest/v1/driving/${lng},${lat}`);
                const data = await response.json();
                console.log('Snap response:', data);
                if (data.code === 'Ok' && data.waypoints && data.waypoints.length > 0) {
                    const snapped = data.waypoints[0].location;
                    return [snapped[1], snapped[0]]; // Convert back to [lat, lng]
                }
            } catch (error) {
                console.error('Error snapping to road:', error);
            }
            return [lat, lng]; // Return original coordinates if snapping fails
        }
        async function addOrderRoute() {
            const startStr = "<?= htmlspecialchars($order['start_point']) ?>";
            const endStr = "<?= htmlspecialchars($order['end_point']) ?>";
            
            console.log('Raw coordinates:', { start: startStr, end: endStr });
            
            const start = startStr.split(',').map(s => parseFloat(s.trim()));
            const end = endStr.split(',').map(s => parseFloat(s.trim()));
            
            console.log('Parsed coordinates:', { start, end });
            
            const startLat = start[0];
            const startLng = start[1];
            const endLat = end[0];
            const endLng = end[1];

            console.log('Final coordinates:', {
                start: [startLat, startLng],
                end: [endLat, endLng]
            });

            if (
                isNaN(startLat) || isNaN(startLng) ||
                isNaN(endLat) || isNaN(endLng) ||
                (startLat === endLat && startLng === endLng)
            ) {
                console.error('Invalid coordinates:', {
                    start: [startLat, startLng],
                    end: [endLat, endLng]
                });
                // alert('Некоректні координати для маршруту!');
                return;
            }

            const startIcon = L.divIcon({
                className: 'custom-marker start-marker',
                html: '<i class="fas fa-flag marker-icon"></i>',
                iconSize: [32, 32],
                iconAnchor: [16, 16]
            });
            const endIcon = L.divIcon({
                className: 'custom-marker end-marker',
                html: '<i class="fas fa-flag-checkered marker-icon"></i>',
                iconSize: [32, 32],
                iconAnchor: [16, 16]
            });

            // Add markers first (Leaflet uses [lat, lng] order)
            const startMarker = L.marker([startLat, startLng], { icon: startIcon }).addTo(map).bindPopup('Початкова точка');
            const endMarker = L.marker([endLat, endLng], { icon: endIcon }).addTo(map).bindPopup('Кінцева точка');

            // Remove any existing routing control and its event listeners
            if (window.routingControl) {
                window.routingControl.off('routesfound');
                window.routingControl.off('routingerror');
                map.removeControl(window.routingControl);
                window.routingControl = null;
            }

            // Create new routing control with coordinates
            window.routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(startLat, startLng),
                    L.latLng(endLat, endLng)
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

            // Add event listeners
            window.routingControl.on('routesfound', function(e) {
                console.log('Route found:', e.routes[0]);
                const route = e.routes[0];
                if (route) {
                    if (route.bounds && typeof route.bounds.isValid === 'function' && !route.bounds.isEmpty()) {
                        map.fitBounds(route.bounds, { padding: [50, 50] });
                    } else {
                        map.setView([startLat, startLng], 15);
                    }
                }
            });

            window.routingControl.on('routingerror', function(e) {
                console.error('Routing error:', e);
                // Try to draw a straight line if routing fails
                const line = L.polyline([
                    [startLat, startLng],
                    [endLat, endLng]
                ], {
                    color: '#007bff',
                    weight: 5,
                    dashArray: '5, 10'
                }).addTo(map);
                
                map.fitBounds(line.getBounds(), { padding: [50, 50] });
                // alert('Не вдалося побудувати маршрут по дорогах. Показано пряму лінію.');
            });
        }
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
</head>

<body>
    <div class="wrapper">
        <?php require_once './templates/header.php'; ?>

        <main class="crm">
            <?php require_once './templates/sidebar.php'; ?>
            <div class="crm__content crm__content--order">
                <?php if ($order['banned']): ?>
                    <div class="banned-message">
                        Проект заблоковано адміністрацією сервісу.
                    </div>
                <?php else: ?>
                    <div class="order">
                        <h5 class="order__title">Доставка ID: <?= htmlspecialchars($order['id']) ?></h5>

                        <div class="order__inner">
                            <ul class="order__filter">
                                <li class="order__filter-item">
                                    <span class="order-subtitle">Тип доставки</span>
                                    <span class="order-title"><?= htmlspecialchars($order['truck_type']) ?></span>
                                </li>
                                <li class="order__filter-item">
                                    <span class="order-subtitle">Вага</span>
                                    <span class="order-title"><?= htmlspecialchars($order['weight']) ?> kg.</span>
                                </li>
                                <li class="order__filter-item">
                                    <span class="order-subtitle">Розмір</span>
                                    <span class="order-title">
                                        <?php if ($order['size'] == 'sm'): ?>
                                            20
                                        <?php elseif ($order['size'] == 'lg'): ?>
                                            80
                                        <?php else: ?>
                                            160
                                        <?php endif; ?>
                                        sm.
                                </li>
                            </ul>
                            <ul class="order__description">
                                <li class="order__filter-item">
                                    <span class="order-subtitle">Опис</span>
                                    <span class="order-text"><?= htmlspecialchars($order['description']) ?></span>
                                </li>
                                <li class="order__filter-item">
                                    <span class="order-subtitle">Як мене впізнати</span>
                                    <span class="order-text"><?= htmlspecialchars($order['recognition']) ?></span>
                                </li>
                                <li class="order__filter-item">
                                    <span class="order-subtitle">Як передати</span>
                                    <span class="order-text"><?= htmlspecialchars($order['delivery_instructions']) ?></span>
                                </li>

                            </ul>
                            <div class="order__shipping">
                                <h5>Інформація про доставку / ціна</h5>
                                <ul class="order__filter">
                                    <li class="order__filter-item">
                                        <span class="order-subtitle">Ціна</span>
                                        <span class="order-title"><?= htmlspecialchars($order['price']) ?> грн.</span>
                                    </li>
                                    <li class="order__filter-item">
                                        <span class="order-subtitle">Відстань</span>
                                        <span class="order-title"><?= htmlspecialchars($order['distance']) ?> км.</span>
                                    </li>
                                    <li class="order__filter-item">
                                        <span class="order-subtitle">Час доставки</span>
                                        <span class="order-title">
                                            <?php
                                            $formattedTime = (new DateTime($order['time']))->format('H:i Y-m-d');
                                            echo htmlspecialchars($formattedTime);
                                            ?>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="order__maps">
                                <div id="map" style="height: 400px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="application">
                        <?php if ($order['executor_id'] && $_SESSION['user_id'] == $order['user_id'] && $order['status'] == 'in_progress'): ?>
                            <form class="horizontal-form" action="" method="post">
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">

                                <div class="form__item">

                                    <select name="complete_order" id="">
                                        <option value="completed">Завершити проект</option>
                                        <option value="cancelled">Скасувати проект</option>
                                    </select>
                                </div>
                                <button class="btn btn-success btn-bg" type="submit">Підтвердити</button>
                            </form>
                        <?php endif; ?>

                        <?php if (!$user_reviewed && $_SESSION['user_role'] == 'executor'): ?>
                            <form class="form" action="/order?order_id=<?= htmlspecialchars($order['id']) ?>" method="post">
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">
                                <div class="form__list">
                                    <div class="form__inner">
                                        <!-- <h5>Зробіть ставку</h5> -->
                                        <div class="form__list">
                                            <div class="form__item">
                                                <label for="info">Інформація</label>
                                                <textarea name="information" id="info"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-bg" type="submit">Прийняти замовлення</button>
                            </form>
                        <?php endif; ?>
                        <div class="application__list">
                            <?php if (empty($reviews)): ?>
                                <!-- <p>Немає ставок.</p> -->
                            <?php else: ?>
                                <div class="table__list">
                                    <?php foreach ($reviews as $review): ?>
                                        <div class="table__item">
                                            <div class="table__main">
                                                <div class="table__main-info">
                                                    <p>
                                                        <?= htmlspecialchars($review['name']) ?>
                                                        <?= htmlspecialchars($review['lastName']) ?>
                                                        <!-- <?php if ($order['executor_id'] == $review['user_id']): ?>
                                                            <span class="winner">Переможець</span>
                                                        <?php endif; ?> -->
                                                    </p>
                                                    <span><?= htmlspecialchars($review['information']) ?></span>

                                                </div>
                                                <?php if ($_SESSION['user_id'] == $order['user_id'] && $order['status'] == 'pending'): ?>
                                                    <form action="/order?order_id=<?= htmlspecialchars($order['id']) ?>" method="post">
                                                        <input type="hidden" name="order_id"
                                                            value="<?= htmlspecialchars($order['id']) ?>">
                                                        <input type="hidden" name="executor_id"
                                                            value="<?= htmlspecialchars($review['user_id']) ?>">
                                                        <button class="btn btn-primary btn-bg" type="submit">Вибрати виконавцем</button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                            <div class="table__date">
                                                <span><?= htmlspecialchars($review['created_at']) ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>