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
    <div class="auth">
        <div class="auth__form">
            <div class="auth__form-wrapper">
                <form class="form" action="" method="post">
                    <h3>Реєстрація</h3>

                    <div class="form__list">
                        <div class="form__col-2">
                            <div class="form__item">
                                <label for="name">Ім'я</label>
                                <input type="text" name="name" placeholder="Іван">
                            </div>
                            <div class="form__item">
                                <label for="last-name">Прізвище</label>
                                <input type="text" name="last-name" placeholder="Петренко">
                            </div>
                        </div>
                        <div class="form__item">
                            <label for="Phone">Телефон</label>
                            <input type="tel" name="phone" placeholder="+38 096 943 3422">
                        </div>
                        <div class="form__item">
                            <label for="login">Електронна пошта</label>
                            <input type="email" name="email" placeholder="ivan@gmail.com">
                        </div>
                        <div class="form__item">
                            <label for="login">Пароль</label>
                            <input type="password" name="password" placeholder="**********">
                        </div>
                        <div class="form__item">
                            <label for="account_type">Тип облікового запису</label>
                            <select name="account_type" id="account_type">
                                <option value="customer">Клієнт</option>
                                <option value="executor">Виконавець</option>
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-bg">Зареєструватися</button>
                </form>

                <div class="auth__bottom">
                    <a href="/sign-in">Увійти</a>
                </div>
            </div>
        </div>
        <div class="auth__photo">
            <img src="./assets/img/auth/sign-in.png" alt="Зображення реєстрації">
        </div>
    </div>
</body>

</html>