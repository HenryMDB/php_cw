<h1 class="page-title">Manage Users</h1>

<div class="manage-users-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Join Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td class="fw-bold text-white"><?= htmlspecialchars($user['firstname'] . " " . $user['lastname']) ?></td>
                    
                    <td class="text-highlight"><?= htmlspecialchars($user['username']) ?></td>
                    
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    
                    <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                    
                    <td class="admin-table-actions">

                        <form action="" method="POST" class="form-admin-delete">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" name="btn_delete_id" class="btn-admin btn-admin-delete" onclick="return confirm('WARNING: Are you sure you want to delete this account?\n\nAll reviews of this user will be permanently deleted!');" title="Delete account">🗑️ Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>