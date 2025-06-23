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
                <div class="chats">
                    <div class="chats__list">
                        <?php if (empty($chats)): ?>
                            <p>Немає доступних чатів.</p>
                        <?php else: ?>
                            <?php foreach ($chats as $chat): ?>
                                <a href="/account/chat?chat_id=<?= htmlspecialchars($chat['id']) ?>" class="chats__item">
                                    <div class="chats__item-user">


                                        <img class="chats__item-icon"
                                            src="/<?= $chat['user_id_1'] == $user_id ? ($chat['user1_avatar'] ?? 'assets/img/placeholder.png') : ($chat['user2_avatar'] ?? 'assets/img/placeholder.png') ?>"
                                            alt="Фото користувача">
                                        <div class="chats__item-info">
                                            <span class="chats__item-name">
                                                <?= htmlspecialchars($chat['user_id_1'] == $user_id ? $chat['user2_name'] : $chat['user1_name']) ?>
                                                <?= htmlspecialchars($chat['user_id_1'] == $user_id ? $chat['user2_lastName'] : $chat['user1_lastName']) ?>
                                            </span>
                                            <span class="chats__item-subtitle">Повідомлення в чаті.</span>
                                        </div>
                                    </div>
                                    <div class="chats__item-right">
                                        <span><?= htmlspecialchars($chat['created_at']) ?></span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($chat_id)): ?>
                        <div class="chats__main">
                            <div class="chats__main-header">
                                <div class="chats__item-user">
                                    <img class="chats__item-icon"
                                        src="/<?= $chat['user_id_1'] == $user_id ? ($chat['user1_avatar'] ?? 'assets/img/placeholder.png') : ($chat['user2_avatar'] ?? 'assets/img/placeholder.png') ?>"
                                        alt="Фото користувача">
                                    <div class="chats__item-info">
                                        <span class="chats__item-name">
                                            <?= htmlspecialchars($chat['user_id_1'] == $user_id ? $chat['user2_name'] : $chat['user1_name']) ?>
                                            <?= htmlspecialchars($chat['user_id_1'] == $user_id ? $chat['user2_lastName'] : $chat['user1_lastName']) ?>
                                        </span>
                                        <span class="chats__item-subtitle">Онлайн</span>
                                    </div>
                                </div>
                            </div>

                            <div class="chats__message">
                                <?php foreach ($messages as $message): ?>
                                    <div class="chats__message-item">
                                        <img src="/<?= $message['avatar'] ?? 'assets/img/placeholder.png'?>" alt="Фото користувача">
                                        <div class="chats__message-content">
                                            <span class="chats__message-name"><?= $message['name'] ?>
                                                <?= $message['lastName'] ?></span>
                                            <p class="chats__message-text"><?= $message['message'] ?></p>
                                            <span class="chats__message-date"><?= $message['created_at'] ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>

                            <form class="chats__form" action="" method="post">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <g opacity="0.5">
                                        <path
                                            d="M12 2C6.486 2 2 6.486 2 12C2 17.514 6.486 22 12 22C17.514 22 22 17.514 22 12C22 6.486 17.514 2 12 2ZM12 20C7.589 20 4 16.411 4 12C4 7.589 7.589 4 12 4C16.411 4 20 7.589 20 12C20 16.411 16.411 20 12 20Z"
                                            fill="#364B58" />
                                        <path
                                            d="M14.8284 14.828C14.4629 15.1924 14.0312 15.4836 13.5564 15.686C12.7017 16.0469 11.7482 16.0995 10.859 15.835C9.96973 15.5705 9.2 15.0053 8.68144 14.236L7.02344 15.355C7.45587 15.9932 8.00603 16.543 8.64444 16.975C9.29409 17.4143 10.024 17.7212 10.7924 17.878C11.5892 18.0405 12.4106 18.0405 13.2074 17.878C13.9758 17.721 14.7057 17.4141 15.3554 16.975C15.6684 16.763 15.9674 16.517 16.2414 16.244C16.5134 15.973 16.7614 15.673 16.9754 15.355L15.3174 14.236C15.1737 14.4485 15.01 14.6468 14.8284 14.828Z"
                                            fill="#364B58" />
                                        <path
                                            d="M15.493 11.986C16.3176 11.986 16.986 11.3176 16.986 10.493C16.986 9.66844 16.3176 9 15.493 9C14.6684 9 14 9.66844 14 10.493C14 11.3176 14.6684 11.986 15.493 11.986Z"
                                            fill="#364B58" />
                                        <path
                                            d="M8.5 12C9.32843 12 10 11.3284 10 10.5C10 9.67157 9.32843 9 8.5 9C7.67157 9 7 9.67157 7 10.5C7 11.3284 7.67157 12 8.5 12Z"
                                            fill="#364B58" />
                                    </g>
                                </svg>
                                <input type="text" placeholder="Напишіть повідомлення..." name="message">
                                <button class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                        fill="none">
                                        <path
                                            d="M15.9642 0.68571C16.0385 0.500001 15.995 0.287892 15.8536 0.146461C15.7121 0.00502989 15.5 -0.0385071 15.3143 0.0357762L0.767199 5.85462L0.765743 5.8552L0.314312 6.03578C0.140137 6.10545 0.0196145 6.26675 0.00217278 6.45353C-0.0152689 6.64031 0.0733055 6.82113 0.231569 6.92185L0.641189 7.18251L0.643086 7.18372L5.63783 10.3622L8.81629 15.3569L8.81781 15.3593L9.07818 15.7685C9.17889 15.9267 9.35972 16.0153 9.5465 15.9978C9.73327 15.9804 9.89458 15.8599 9.96424 15.6857L15.9642 0.68571ZM14.1311 2.57603L6.63717 10.0699L6.42184 9.73158C6.38255 9.66984 6.33019 9.61747 6.26845 9.57818L5.93006 9.36284L13.4239 1.86896L14.6025 1.39754L14.1311 2.57603Z"
                                            fill="white" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </main>
    </div>
</body>

</html>