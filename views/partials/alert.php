
    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php
                    $errors = $_SESSION['errors'];
                    if(!is_array($errors)){
                        $errors = ['errors'];
                    }
                ?>
                <?php foreach ($_SESSION['errors'] as $field => $error): ?>
                    <?php if (is_array($error)): ?>
                        <?php foreach ($error as $msg): ?>
                            <li><?= htmlspecialchars($msg) ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
    
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

