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
                        <h5>Projects</h5>
                    </div>

                    <table class="table__list">

                        <tr>
                            <td>Id</td>
                            <td>Truck type</td>
                            <td>Description</td>
                            <td>Weight</td>
                            <td>Size</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>

                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><?= htmlspecialchars($project['id']) ?></td>
                                <td><?= htmlspecialchars($project['truck_type']) ?></td>
                                <td><?= htmlspecialchars($project['description']) ?></td>
                                <td><?= htmlspecialchars($project['weight']) ?></td>
                                <td><?= htmlspecialchars($project['size']) ?></td>
                                <td><?= htmlspecialchars($project['status']) ?></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm"><?= $project['banned'] ? 'Unban' : 'Ban' ?></button>
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