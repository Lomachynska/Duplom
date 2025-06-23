<!DOCTYPE html>
<html lang="en">

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
                <div class="table">

                    <div class="crm__header">
                        <h5>Users</h5>
                    </div>

                    <table class="table__list">
                        
                            <tr>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Phone</td>
                                <td>Role</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                     
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['name']) ?> <?= htmlspecialchars($user['lastName']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['phone']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                    <td><?= $user['banned'] ? 'Banned' : 'Active' ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm"><?= $user['banned'] ? 'Unban' : 'Ban' ?></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                      
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>