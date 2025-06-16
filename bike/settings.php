<?php
session_start();
include('init.php');
if (!(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true)) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Настройки профиля</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="main/header.css">
    <link rel="stylesheet" href="main/footer.css">
    <style>
        .container {
            margin-top: 40px;
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>
<div class="container">
    <h2 class="mb-4">⚙️ Настройки профиля</h2>
    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button" role="tab">Редактировать профиль</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#change-password" type="button" role="tab">Сменить пароль</button>
        </li>
    </ul>
    <div class="tab-content border p-4 rounded-bottom bg-light" id="settingsTabsContent">
        <div class="tab-pane fade show active" id="edit-profile" role="tabpanel">
            <form>
                <div class="mb-3">
                    <label class="form-label">Имя пользователя</label>
                    <input type="text" class="form-control" value="<?php echo $_SESSION['login']; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?php echo $_SESSION['email']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
        <div class="tab-pane fade" id="change-password" role="tabpanel">
            <form>
                <div class="mb-3">
                    <label class="form-label">Старый пароль</label>
                    <input type="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Новый пароль</label>
                    <input type="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-warning">Сменить пароль</button>
            </form>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
