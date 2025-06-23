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
                    <h3>Ласкаво просимо!</h3>

                    <?php if (isset($error_message)): ?>
                        <div class="form__error">
                            <p><?= htmlspecialchars($error_message) ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="form__list">

                        <div class="form__item">
                            <label for="Phone">Телефон</label>
                            <input type="tel" name="phone" placeholder="+38 096 943 3422">
                        </div>

                        <div class="form__item">
                            <label for="login">Пароль</label>
                            <input type="password" name="password" placeholder="**********">
                        </div>

                    </div>

                    <button class="btn btn-primary btn-bg">Увійти</button>
                </form>

                <div class="auth__bottom">
                    <a href="/sign-up">Реєстрація</a>
                    <a href="#">Забули пароль?</a>
                </div>
            </div>
        </div>
        <div class="auth__photo">
            <img src="./assets/img/auth/sign-in.png" alt="Зображення входу">
        </div>
    </div>
</body>

</html>