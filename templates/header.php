<?php
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $info = info_user($id);
}
?>


<header class="header">
    <div class="header__container container-lg">
        <div class="header__main">
            <a href="" class="header__logo">
                <img src="/assets/img/logo.svg" alt="logo" class="header__logo-img">
                <span class="header__logo-text">AeroDrop</span>
            </a>

            <nav class="header__nav">
                <ul>
                    <li><a href="/" class="link-item">Головна</a></li>
                    <li><a href="/about" class="link-item">Про проєкт</a></li>
                    <li><a href="/#advantages" class="link-item">Переваги</a></li>
                    <li><a href="/#reviews" class="link-item">Відгуки</a></li>
                    <li><a href="/#contacts" class="link-item">Контакти</a></li>
                    <li><a href="/maps" class="link-item">Карта БПЛА</a></li>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'customer'): ?>
                        <li><a href="/account/history">Замовлення</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>


        <?php if (isset($_SESSION['user_id'])): ?>

            <div class="header__panel">
                <a href="/account/settings" class="header__panel-icon">
                    <img src="/<?= $info['avatar'] ?? 'assets/img/placeholder.png' ?>" alt="user-icon">
                </a>
                <div class="header__panel-info">
                    <p><?= htmlspecialchars($info['name']) ?></p>
                    <a href="/logout">
                        <span>Вийти</span>
                        <img src="/assets/img/exit.svg" alt="exit">
                    </a>
                </div>
            </div>

        <?php else: ?>

            <div class="header__auth">
                <a href="/sign-in" class="btn btn-border btn-sm">Увійти</a>
                <a href="/sign-up" class="btn btn-primary btn-sm">Реєстрація</a>
            </div>

        <?php endif; ?>

    </div>
</header>