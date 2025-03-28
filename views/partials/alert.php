
    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php
                    $errors = $_SESSION['errors'];
                    if(!is_array($errors)){
                        $errors = [$errors];
                    }
                $flatErrors = [];
                foreach ($errors as $error) {
                    if (is_array($error)) {
                        foreach ($error as $sub) {
                            if (is_array($sub)) {
                                foreach ($sub as $msg) {
                                    $flatErrors[] = $msg;
                                }
                            } else {
                                $flatErrors[] = $sub;
                            }
                        }
                    } else {
                        $flatErrors[] = $error;
                    }
                }

                foreach ($flatErrors as $msg): ?>
                    <li><?= htmlspecialchars($msg) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
    
    <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <ul class="mb-0">
            <?php
                $successes = $_SESSION['success'];
                if (!is_array($successes)) {
                    $successes = [$successes];
                }
            ?>
            <?php foreach ($successes as $msg): ?>
                <li><?= htmlspecialchars($msg) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>


