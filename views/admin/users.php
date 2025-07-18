<h1 class="text-dark mb-5">Utilisateurs</h1>

<div class="container">
    <?php renderPartial('alert') ?>
</div>

<section class="container">
    <div class="table-responsive">
        <table class="table table-light table-striped">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Email</th>
                <th scope="col" class="text-center">Suspension</th>
                <th scope="col" class="text-center">Suppression</th>
                </tr>
            </thead>
            <?php if(!empty($users)) : ?>
                <?php foreach($users as $user) : ?>
                    <tbody>
                        <tr>
                        <th scope="row"><?= $user->getUserId() ?></th>
                        <td><?= htmlspecialchars($user->getName()) ?></td>
                        <td><?= htmlspecialchars($user->getFirstname()) ?></td>
                        <td><?= htmlspecialchars($user->getEmail()) ?></td>
                        <td class="text-center">
                            <?php if($user->getIsActive() === 1) : ?>
                                <form action="/admin/users/<?= $user->getUserId() ?>/suspend" method="post">
                                <?= csrfField(); ?>
                                    <button class="btn-suspend bg-transparent border-0" title="Suspendre l'utilisateur">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.5C9.21523 1.5 6.54451 2.60625 4.57538 4.57538C2.60625 6.54451 1.5 9.21523 1.5 12C1.5 14.7848 2.60625 17.4555 4.57538 19.4246C6.54451 21.3938 9.21523 22.5 12 22.5C14.7848 22.5 17.4555 21.3938 19.4246 19.4246C21.3938 17.4555 22.5 14.7848 22.5 12C22.5 9.21523 21.3938 6.54451 19.4246 4.57538C17.4555 2.60625 14.7848 1.5 12 1.5ZM9 16.5H10.5V7.5H9V16.5ZM15 7.5H13.5V16.5H15V7.5Z" fill=""/>
                                        </svg>
                                    </button>
                                </form>
                            <?php else : ?>
                                <form action="/admin/users/<?= $user->getUserId() ?>/reactivate" method="post">
                                <?= csrfField(); ?>
                                    <button class="btn-reactivate bg-transparent border-0" title="Réactiver l'utilisateur">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.409 9.35294C21.8893 9.60835 22.291 9.98963 22.5712 10.4559C22.8514 10.9222 22.9994 11.456 22.9994 11.9999C22.9994 12.5439 22.8514 13.0777 22.5712 13.544C22.291 14.0102 21.8893 14.3915 21.409 14.6469L8.597 21.6139C6.534 22.7369 4 21.2769 4 18.9679V5.03294C4 2.72294 6.534 1.26394 8.597 2.38494L21.409 9.35294Z" fill=""/>
                                        </svg>
                                    </button>
                                </form>
                            <?php endif ?>
                        </td>
                        <td class="text-center">
                            <form action="/admin/users/<?= $user->getUserId() ?>/delete" method="post">
                            <?= csrfField(); ?>
                                <button class="btn-delete bg-transparent border-0" title="Supprimer l'utilisateur" onclick="return confirm('Supprimer ce véhicule ?')">
                                    <svg width="18" height="20" viewBox="0 0 18 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.241 1.721L12.534 3.75H16.5C16.6989 3.75 16.8897 3.82902 17.0303 3.96967C17.171 4.11032 17.25 4.30109 17.25 4.5C17.25 4.69891 17.171 4.88968 17.0303 5.03033C16.8897 5.17098 16.6989 5.25 16.5 5.25H15.731L14.858 15.435C14.805 16.055 14.762 16.565 14.693 16.977C14.623 17.406 14.516 17.79 14.307 18.146C13.9788 18.7051 13.4909 19.1533 12.906 19.433C12.534 19.61 12.142 19.683 11.708 19.717C11.291 19.75 10.78 19.75 10.158 19.75H7.842C7.22 19.75 6.709 19.75 6.292 19.717C5.858 19.683 5.466 19.61 5.094 19.433C4.50908 19.1533 4.02118 18.7051 3.693 18.146C3.483 17.79 3.378 17.406 3.307 16.977C3.238 16.564 3.195 16.055 3.142 15.435L2.269 5.25H1.5C1.30109 5.25 1.11032 5.17098 0.96967 5.03033C0.829018 4.88968 0.75 4.69891 0.75 4.5C0.75 4.30109 0.829018 4.11032 0.96967 3.96967C1.11032 3.82902 1.30109 3.75 1.5 3.75H5.466L5.759 1.721L5.77 1.66C5.952 0.87 6.63 0.25 7.48 0.25H10.52C11.37 0.25 12.048 0.87 12.23 1.66L12.241 1.721ZM6.981 3.75H11.018L10.762 1.974C10.714 1.807 10.592 1.75 10.519 1.75H7.481C7.408 1.75 7.286 1.807 7.238 1.974L6.981 3.75ZM8.25 8.5C8.25 8.30109 8.17098 8.11032 8.03033 7.96967C7.88968 7.82902 7.69891 7.75 7.5 7.75C7.30109 7.75 7.11032 7.82902 6.96967 7.96967C6.82902 8.11032 6.75 8.30109 6.75 8.5V13.5C6.75 13.6989 6.82902 13.8897 6.96967 14.0303C7.11032 14.171 7.30109 14.25 7.5 14.25C7.69891 14.25 7.88968 14.171 8.03033 14.0303C8.17098 13.8897 8.25 13.6989 8.25 13.5V8.5ZM11.25 8.5C11.25 8.30109 11.171 8.11032 11.0303 7.96967C10.8897 7.82902 10.6989 7.75 10.5 7.75C10.3011 7.75 10.1103 7.82902 9.96967 7.96967C9.82902 8.11032 9.75 8.30109 9.75 8.5V13.5C9.75 13.6989 9.82902 13.8897 9.96967 14.0303C10.1103 14.171 10.3011 14.25 10.5 14.25C10.6989 14.25 10.8897 14.171 11.0303 14.0303C11.171 13.8897 11.25 13.6989 11.25 13.5V8.5Z" fill=""/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                        </tr>
                    </tbody>
                <?php endforeach ?>
            <?php endif ?>
        </table>
    </div>
</section>