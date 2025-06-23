<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroDrop</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="icon" href="/assets/img/logo.svg">
</head>

<body>
    <div class="wrapper">
        <?php require_once './templates/header.php'; ?>

        <main class="main main--small-margin">
            <section class="info-block info-block--hero">
                <div class="info-block__container container">
                    <div class="info-block__content">

                        <h1>Швидка доставка вантажів по всьому світу</h1>

                        <p>
                            Наш сервіс забезпечує надійну та швидку доставку ваших вантажів. Ми працюємо з різними
                            видами транспорту та забезпечуємо повний цикл логістичних послуг.
                        </p>

                        <div class="info-block__btns">
                            <a href="#" class="btn btn-primary btn-lg">Детальніше</a>
                        </div>
                    </div>

                    <div class="info-block__photo">
                        <img src="./assets/img/home/images-1.png" alt="Зображення доставки">
                    </div>
                </div>
            </section>

            <section class="info-cards" id="advantages">
                <div class="info-cards__container container">
                    <h3 class="info-cards__title">Наші переваги</h3>

                    <div class="info-cards__list">
                        <div class="info-cards__item">
                            <div class="info-cards__inner">
                                <img src="./assets/img/bug-fill.svg" alt="Іконка швидкості">
                                <h4>Швидка доставка</h4>
                                <p>
                                    Ми гарантуємо швидку доставку вашого вантажу в будь-яку точку світу. Наші логістичні
                                    рішення оптимізовані для максимальної ефективності.
                                </p>
                            </div>

                            <a class="btn-arrow" href="#">Детальніше</a>
                        </div>
                        <div class="info-cards__item">
                            <div class="info-cards__inner">
                                <img src="./assets/img/bug-fill.svg" alt="Іконка надійності">
                                <h4>Надійність</h4>
                                <p>
                                    Ваш вантаж завжди під надійним контролем. Ми використовуємо сучасні системи
                                    відстеження та забезпечуємо повну прозорість процесу доставки.
                                </p>
                            </div>
                            <a class="btn-arrow" href="#">Детальніше</a>
                        </div>
                        <div class="info-cards__item">
                            <div class="info-cards__inner">
                                <img src="./assets/img/bug-fill.svg" alt="Іконка якості">
                                <h4>Якість обслуговування</h4>
                                <p>
                                    Наші клієнти отримують персональний підхід та професійну підтримку на кожному етапі
                                    доставки. Ми працюємо для вашого комфорту.
                                </p>
                            </div>
                            <a class="btn-arrow" href="#">Детальніше</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="info-block">
                <div class="info-block__container container">
                    <div class="info-block__photo">
                        <img src="./assets/img/home/images-2.png" alt="Зображення логістики">
                    </div>

                    <div class="info-block__content">
                        <span class="info-block__tag">Старт</span>

                        <h2>Почати користуватися нашим сервісом</h2>

                        <p>
                            Приєднуйтесь до нашої платформи для ефективної доставки вантажів. Ми пропонуємо прості
                            рішення для складних логістичних завдань.
                        </p>

                        <div class="info-block__btns">
                            <a href="#" class="btn btn-primary btn-lg">Реєстрація</a>
                            <a href="#" class="btn-arrow">Детальніше</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="info-cards info-cards--about info-cards--reviews" id="reviews">
                <div class="container">
                    <h2>Відгуки</h2>
                    <div class="info-cards__container">
                        <div class="info-cards__list">
                            <div class="info-cards__item">
                                <div class="info-cards__inner">
                                    <img src="./assets/img/placeholder.png" alt="Іконка досвіду">
                                    <h4>Іван Іваненко</h4>
                                    <p>
                                        "Користуюся сервісом AeroDrop вже кілька років. Завжди задоволений швидкістю та
                                        якістю доставки. Рекомендую всім!"
                                    </p>
                                </div>
                            </div>
                            <div class="info-cards__item">
                                <div class="info-cards__inner">
                                    <img src="./assets/img/placeholder.png" alt="Іконка досвіду">
                                    <h4>Олена Петрівна</h4>
                                    <p>
                                        "Дуже зручно працювати з AeroDrop. Сучасні технології та прозорість процесу
                                        доставки – це те, що мені потрібно."
                                    </p>
                                </div>
                            </div>
                            <div class="info-cards__item">
                                <div class="info-cards__inner">
                                    <img src="./assets/img/placeholder.png" alt="Іконка досвіду">
                                    <h4>Андрій Коваленко</h4>
                                    <p>
                                        "Персональний підхід та професійна підтримка на кожному етапі. AeroDrop – це
                                        найкращий вибір для логістики."
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="info-block info-block--contact" id="contacts">
                <div class="info-block__container container">

                    <div class="info-block__content">


                        <h2>Контакти</h2>

                        <ul class="contact-list">
                            <li class="contact-item">
                                <span><strong>Адреса офісу:</strong> м. Київ, вул. Хрещатик, 1</span>
                            </li>
                            <li class="contact-item">
                                <span><strong>Мобільний телефон:</strong> +380 67 123 4567</span>
                            </li>
                            <li class="contact-item">
                                <span><strong>Електронна пошта:</strong> info@aerodrop.com</span>
                            </li>
                            <li class="contact-item">
                                <span><strong>Години роботи:</strong> Пн-Пт: 9:00 - 18:00</span>
                            </li>
                        </ul>

                        <div class="info-block__btns">
                            <a href="tel: +123456789" class="btn btn-primary btn-lg">Зателефонувати</a>
                            <a href="mailto: test@gmail.com" class="btn-arrow">Написати e-mail</a>
                        </div>
                    </div>

                    <div class="info-block__photo">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2528.269026686725!2d30.87887857726274!3d50.95230917165374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTDCsDU3JzA4LjMiTiAzMMKwNTInNDMuOCJF!5e0!3m2!1suk!2sua!4v1682597234567!5m2!1suk!2sua"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                </div>
            </section>
        </main>

        <?php require_once './templates/footer.php'; ?>

        <script src="/assets/js/index.js"></script>
    </div>
</body>

</html>