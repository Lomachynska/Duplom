<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroDrop</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="icon" href="/assets/img/logo.svg">
    <style>
        .filter-controls {
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .filter-controls select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .drone-group {
            margin-bottom: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }
        .drone-group h6 {
            margin: 0 0 15px 0;
            color: #666;
            font-size: 1.1em;
        }
        .drone-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: 500;
        }
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        .status-maintenance {
            background: #fff3cd;
            color: #856404;
        }
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php require_once './templates/header.php'; ?>

        <main class="crm">
            <?php require_once './templates/sidebar.php' ?>

            <div class="crm__content">
                <?php
                // Тестові дані для БПЛА
                $drones = [
                    [
                        'id' => 1,
                        'name' => 'DJI Mavic 3',
                        'model' => 'Mavic 3 Pro',
                        'status' => 'active',
                        'created_at' => '2024-03-15 10:30:00'
                    ],
                    [
                        'id' => 2,
                        'name' => 'DJI Phantom 4',
                        'model' => 'Phantom 4 Pro V2.0',
                        'status' => 'maintenance',
                        'created_at' => '2024-03-14 15:45:00'
                    ],
                    [
                        'id' => 3,
                        'name' => 'DJI Mini 3',
                        'model' => 'Mini 3 Pro',
                        'status' => 'active',
                        'created_at' => '2024-03-13 09:15:00'
                    ],
                    [
                        'id' => 4,
                        'name' => 'DJI Air 2S',
                        'model' => 'Air 2S',
                        'status' => 'inactive',
                        'created_at' => '2024-03-12 14:20:00'
                    ],
                    [
                        'id' => 5,
                        'name' => 'DJI Inspire 2',
                        'model' => 'Inspire 2',
                        'status' => 'active',
                        'created_at' => '2024-03-11 11:00:00'
                    ]
                ];

                // Групування БПЛА за статусом
                $groupedDrones = [];
                foreach ($drones as $drone) {
                    $groupedDrones[$drone['status']][] = $drone;
                }

                // Сортування БПЛА за датою створення
                foreach ($groupedDrones as &$group) {
                    usort($group, function($a, $b) {
                        return strtotime($b['created_at']) - strtotime($a['created_at']);
                    });
                }

                // Статуси для відображення
                $statusLabels = [
                    'active' => 'Активні',
                    'maintenance' => 'На обслуговуванні',
                    'inactive' => 'Неактивні'
                ];
                ?>
                <div class="table">
                    <div class="crm__header">
                        <h5>Мої БПЛА</h5>
                    </div>

                    <div class="filter-controls">
                        <select id="sortBy" onchange="sortDrones()">
                            <option value="date_desc">За датою (нові → старі)</option>
                            <option value="date_asc">За датою (старі → нові)</option>
                            <option value="name_asc">За назвою (А-Я)</option>
                            <option value="name_desc">За назвою (Я-А)</option>
                        </select>
                    </div>

                    <div class="table__list">
                        <?php if (!empty($groupedDrones)): ?>
                            <?php foreach ($statusLabels as $status => $label): ?>
                                <?php if (isset($groupedDrones[$status]) && !empty($groupedDrones[$status])): ?>
                                    <div class="drone-group">
                                        <h6><?= $label ?></h6>
                                        <?php foreach ($groupedDrones[$status] as $index => $drone): ?>
                                            <a href="/account/drone-statistic?id=<?= $drone['id'] ?>" style="text-decoration: none; color: inherit;">
                                                <div class="table__item">
                                                    <div class="table__main">
                                                        <div class="table__main-info">
                                                            <p>№<?= $index + 1 ?> | <?= htmlspecialchars($drone['name']) ?></p>
                                                            <span><?= htmlspecialchars($drone['model']) ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="table__date">
                                                        <span><?= htmlspecialchars($drone['created_at']) ?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="table__empty">
                                <p>У вас ще немає доданих БПЛА</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function sortDrones() {
            const sortBy = document.getElementById('sortBy').value;
            const droneGroups = document.querySelectorAll('.drone-group');
            
            droneGroups.forEach(group => {
                const items = Array.from(group.querySelectorAll('.table__item'));
                
                items.sort((a, b) => {
                    const aText = a.querySelector('.table__main-info p').textContent;
                    const bText = b.querySelector('.table__main-info p').textContent;
                    const aDate = a.querySelector('.table__date span').textContent;
                    const bDate = b.querySelector('.table__date span').textContent;
                    
                    switch(sortBy) {
                        case 'date_desc':
                            return new Date(bDate) - new Date(aDate);
                        case 'date_asc':
                            return new Date(aDate) - new Date(bDate);
                        case 'name_asc':
                            return aText.localeCompare(bText);
                        case 'name_desc':
                            return bText.localeCompare(aText);
                        default:
                            return 0;
                    }
                });
                
                items.forEach((item, index) => {
                    const numberElement = item.querySelector('.table__main-info p');
                    numberElement.textContent = numberElement.textContent.replace(/№\d+/, `№${index + 1}`);
                    group.appendChild(item);
                });
            });
        }
    </script>
</body>

</html>