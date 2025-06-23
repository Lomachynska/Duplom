<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroDrop</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="icon" href="./assets/img/logo.svg">
</head>

<body>
    
    <div class="wrapper">
        <?php require_once './templates/header.php'; ?>

        <main class="main main--no-margin">

            <div class="about__photo">
                <img src="./assets/img/about/images.png" alt="Про компанію">
            </div>

            <section class="info-block" id="contacts">
                <div class="info-block__container container">
                    <div class="info-block__content">
                        <span class="info-block__tag">Про нас</span>

                        <h2>Наша компанія</h2>

                        <p>
                            Ми - провідна логістична компанія, яка спеціалізується на міжнародній доставці вантажів. Наша місія - забезпечити швидку, надійну та ефективну доставку для наших клієнтів.
                        </p>
                    </div>
                </div>
            </section>

            <section class="info-cards info-cards--about">
                <div class="info-cards__container container">

                    <div class="info-cards__list">
                        <div class="info-cards__item">
                            <div class="info-cards__inner">
                                <img src="./assets/img/bug-fill.svg" alt="Іконка досвіду">
                                <h4>Досвід роботи</h4>
                                <p>
                                    Більше 10 років успішної роботи на ринку логістичних послуг. Ми знаємо всі нюанси міжнародних перевезень та забезпечуємо якісний сервіс.
                                </p>
                            </div>
                        </div>
                        <div class="info-cards__item">
                            <div class="info-cards__inner">
                                <img src="./assets/img/bug-fill.svg" alt="Іконка технологій">
                                <h4>Сучасні технології</h4>
                                <p>
                                    Використовуємо передові технології для відстеження вантажів та оптимізації логістичних процесів. Ваш вантаж завжди під контролем.
                                </p>
                            </div>
                        </div>
                        <div class="info-cards__item">
                            <div class="info-cards__inner">
                                <img src="./assets/img/bug-fill.svg" alt="Іконка клієнтів">
                                <h4>Клієнтоорієнтованість</h4>
                                <p>
                                    Кожен клієнт отримує персональний підхід та професійну підтримку. Ми працюємо для вашого комфорту та задоволення.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="info-block__btns">
                        <a href="#" class="btn btn-primary btn-lg">Реєстрація</a>
                        <a href="#" class="btn-arrow">Детальніше</a>
                    </div>
                </div>
            </section>

            <section class="info-block">
                <div class="info-block__container container">
                    <div class="info-block__photo">
                        <img src="./assets/img/about/images-2.png" alt="Наші послуги">
                    </div>

                    <div class="info-block__content">
                        <span class="info-block__tag">Послуги</span>

                        <h2>Наші можливості</h2>

                        <p>
                            Пропонуємо повний спектр логістичних послуг: від міжнародних перевезень до зберігання та обробки вантажів. Ми знаходимо оптимальні рішення для кожного клієнта.
                        </p>

                        <div class="info-block__btns">
                            <a href="#" class="btn btn-primary btn-lg">Реєстрація</a>
                            <a href="#" class="btn-arrow">Детальніше</a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <?php require_once './templates/footer.php'; ?>
        <script src="/assets/js/index.js"></script>

    </div>
</body>

</html>