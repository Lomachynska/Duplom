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

        <main class="crm">
            <?php require_once './templates/sidebar.php'; ?>

            <div class="crm__content">

                <form class="form form--setttings" action="" method="post" enctype="multipart/form-data">

                    <div class="change__avatar">
                        <input type="file" name="photo" id="user_photo" accept="image/*" onchange="previewImage(event)">
                        <div class="change__avatar-wrapper">
                            <img id="avatar_preview" src="/<?= $info['avatar'] ?? 'assets/img/placeholder.png' ?>"
                                alt="user-icon">

                        </div>
                        <label for="user_photo">Змінити аватар</label>
                    </div>


                    <div class="form__inner">
                        <h5>Особиста інформація</h5>
                        <div class="form__list">
                            <div class="form__col-2">
                                <div class="form__item">
                                    <label for="name">Ім'я</label>
                                    <input type="text" name="name" value="<?= $info['name'] ?>" placeholder="Іван">
                                </div>
                                <div class="form__item">
                                    <label for="last-name">Прізвище</label>
                                    <input type="text" name="last-name" value="<?= $info['lastName'] ?>"
                                        placeholder="ivan@gmail.com">
                                </div>
                            </div>

                            <div class="form__col-2">
                                <div class="form__item">
                                    <label for="email">Електронна пошта</label>
                                    <input type="email" name="email" value="<?= $info['email'] ?>"
                                        placeholder="ivan@gmail.com">
                                </div>
                                <div class="form__item">
                                    <label for="phone">Телефон</label>
                                    <input type="tel" name="phone" value="<?= $info['phone'] ?>" placeholder="Іван">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form__inner">
                        <h5>Зміна паролю</h5>
                        <div class="form__list">
                            <div class="form__item">
                                <label for="password">Пароль</label>
                                <input type="password" name="password" placeholder="Пароль">
                            </div>
                        </div>
                    </div>

                    <div class="form__inner">
                        <h5>Додаткова інформація</h5>
                        <div class="form__list">
                            <div class="form__item">
                                <label for="info">Додаткова інформація</label>
                                <textarea name="information" id=""><?= $info['information'] ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form__btns">
                        <button class="btn btn-secondary btn-bg" type="reset">Скинути</button>
                        <button class="btn btn-primary btn-bg" type="submit">Оновити</button>
                    </div>

                </form>
            </div>

        </main>

    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('avatar_preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>