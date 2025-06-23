<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика дрону</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="icon" href="/assets/img/logo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .drone-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .drone-stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .drone-stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .drone-stat-title {
            font-size: 1.1em;
            color: #666;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .drone-stat-value {
            font-size: 1.8em;
            font-weight: bold;
            margin: 10px 0;
        }

        .drone-stat-details {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }

        .battery-icon { color: #4CAF50; }
        .distance-icon { color: #2196F3; }
        .speed-icon { color: #FF9800; }
        .altitude-icon { color: #9C27B0; }
        .signal-icon { color: #E91E63; }
        .temperature-icon { color: #F44336; }

        .battery-progress {
            width: 100%;
            height: 8px;
            background: #eee;
            border-radius: 4px;
            margin-top: 10px;
            overflow: hidden;
        }

        .battery-progress-bar {
            height: 100%;
            background: #4CAF50;
            transition: width 0.3s ease;
        }

        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .status-active {
            background: #4CAF50;
        }

        .status-warning {
            background: #FFC107;
        }

        .status-danger {
            background: #F44336;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php require_once './templates/header.php'; ?>

        <main class="crm">
            <?php require_once './templates/sidebar.php' ?>

            <div class="crm__content">
                <div class="crm__header">
                    <h5>Статистика дрону</h5>
                </div>

                <div class="drone-stats-grid">
                    <!-- Батарея -->
                    <div class="drone-stat-card">
                        <div class="drone-stat-header">
                            <div class="drone-stat-title">
                                <i class="fas fa-battery-three-quarters battery-icon"></i>
                                <span>Заряд батареї</span>
                            </div>
                            <span class="status-indicator status-active"></span>
                        </div>
                        <div class="drone-stat-value">85%</div>
                        <div class="battery-progress">
                            <div class="battery-progress-bar" style="width: 85%"></div>
                        </div>
                        <div class="drone-stat-details">
                            Залишилось польоту: ~25 хв
                        </div>
                    </div>

                    <!-- Відстань -->
                    <div class="drone-stat-card">
                        <div class="drone-stat-header">
                            <div class="drone-stat-title">
                                <i class="fas fa-route distance-icon"></i>
                                <span>Відстань</span>
                            </div>
                        </div>
                        <div class="drone-stat-value">2.5 км</div>
                        <div class="drone-stat-details">
                            Пролетіло: 1.2 км<br>
                            Залишилось: 1.3 км
                        </div>
                    </div>

                    <!-- Швидкість -->
                    <div class="drone-stat-card">
                        <div class="drone-stat-header">
                            <div class="drone-stat-title">
                                <i class="fas fa-tachometer-alt speed-icon"></i>
                                <span>Швидкість</span>
                            </div>
                        </div>
                        <div class="drone-stat-value">35 км/год</div>
                        <div class="drone-stat-details">
                            Максимальна: 50 км/год<br>
                            Середня: 30 км/год
                        </div>
                    </div>

                    <!-- Висота -->
                    <div class="drone-stat-card">
                        <div class="drone-stat-header">
                            <div class="drone-stat-title">
                                <i class="fas fa-arrow-up altitude-icon"></i>
                                <span>Висота</span>
                            </div>
                        </div>
                        <div class="drone-stat-value">120 м</div>
                        <div class="drone-stat-details">
                            Максимальна: 150 м<br>
                            Мінімальна: 50 м
                        </div>
                    </div>

                    <!-- Сигнал -->
                    <div class="drone-stat-card">
                        <div class="drone-stat-header">
                            <div class="drone-stat-title">
                                <i class="fas fa-signal signal-icon"></i>
                                <span>Сигнал</span>
                            </div>
                            <span class="status-indicator status-active"></span>
                        </div>
                        <div class="drone-stat-value">Сильний</div>
                        <div class="drone-stat-details">
                            Відстань від контролера: 0.8 км<br>
                            Затримка: 50 мс
                        </div>
                    </div>

                    <!-- Температура -->
                    <div class="drone-stat-card">
                        <div class="drone-stat-header">
                            <div class="drone-stat-title">
                                <i class="fas fa-thermometer-half temperature-icon"></i>
                                <span>Температура</span>
                            </div>
                            <span class="status-indicator status-warning"></span>
                        </div>
                        <div class="drone-stat-value">45°C</div>
                        <div class="drone-stat-details">
                            Моторів: 42°C<br>
                            Батареї: 38°C
                        </div>
                    </div>

                    <!-- Заробіток -->
                    <div class="drone-stat-card">
                        <div class="drone-stat-header">
                            <div class="drone-stat-title">
                                <i class="fas fa-money-bill-wave earnings-icon"></i>
                                <span>Заробіток</span>
                            </div>
                            <span class="status-indicator status-active"></span>
                        </div>
                        <div class="drone-stat-value">1,250 ₴</div>
                        <div class="drone-stat-details">
                            Сьогодні: 450 ₴<br>
                            За тиждень: 3,500 ₴
                        </div>
                    </div>

                    <!-- Посилки -->
                    <div class="drone-stat-card">
                        <div class="drone-stat-header">
                            <div class="drone-stat-title">
                                <i class="fas fa-box delivery-icon"></i>
                                <span>Посилки</span>
                            </div>
                            <span class="status-indicator status-active"></span>
                        </div>
                        <div class="drone-stat-value">15</div>
                        <div class="drone-stat-details">
                            Сьогодні: 5 посилок<br>
                            Успішних: 14 (93%)
                        </div>
                    </div>

                    <!-- Час польоту -->
                    <div class="drone-stat-card">
                        <div class="drone-stat-header">
                            <div class="drone-stat-title">
                                <i class="fas fa-clock flight-time-icon"></i>
                                <span>Час польоту</span>
                            </div>
                        </div>
                        <div class="drone-stat-value">4.5 год</div>
                        <div class="drone-stat-details">
                            Сьогодні: 1.2 год<br>
                            За тиждень: 12.5 год
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Функція для оновлення даних дрону
        function updateDroneStats() {
            // Тут буде логіка оновлення даних з API дрону
            // Наразі просто симулюємо зміни
            const batteryLevel = document.querySelector('.battery-progress-bar');
            const currentBattery = parseInt(batteryLevel.style.width);
            if (currentBattery > 0) {
                batteryLevel.style.width = (currentBattery - 1) + '%';
            }
        }

        // Оновлюємо дані кожні 30 секунд
        setInterval(updateDroneStats, 30000);
    </script>
</body>

</html> 