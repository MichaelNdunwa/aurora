<div class="profile-section">
    <div class="profile">
        <div class="user" onclick="toggleProfileDialog()">
            <div class="left">
                <img src="assets/images/profile-pics/michael.jpg">
            </div>
            <div class="right">
                <?= $_SESSION['userLoggedIn'] ?? 'Profile'; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add the profile dialog -->
<div id="profileDialog" class="profile-dialog">
    <div class="dialog-content">
        <span class="close-btn" onclick="toggleProfileDialog()">&times;</span>
        <h3>Profile Settings</h3>
        
        <div class="profile-options">
            <div class="option" onclick="document.getElementById('profilePicInput').click()">
                <input type="file" id="profilePicInput" hidden accept="image/*" onchange="changeProfilePic(this)">
                <i class="bx bx-camera"></i> Change Profile Picture
            </div>
            
            <div class="option" onclick="showUsernameForm()">
                <i class="bx bx-user-circle"></i> Change Username
            </div>
            
            <div class="option" onclick="logout()">
                <i class="bx bx-log-out"></i> Logout
            </div>
        </div>
    </div>
</div>

<style>
    .profile-section .user {
    cursor: pointer;
}

.profile-dialog {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.dialog-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #202026;
    padding: 20px;
    border-radius: 8px;
    min-width: 300px;
}

.close-btn {
    float: right;
    cursor: pointer;
    font-size: 24px;
}

.profile-options .option {
    padding: 15px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
    display: flex;  /* Add this */
    align-items: center;  /* Add this */
    gap: 10px;  /* Add this */
}

.profile-options i {
    font-size: 25px;
    display: flex;  /* Add this */
    align-items: center;  /* Add this */
}

.profile-options .option:hover {
    transform: translateY(-5px);
}
</style>

<script>
    function toggleProfileDialog() {
    const dialog = document.getElementById('profileDialog');
    dialog.style.display = dialog.style.display === 'block' ? 'none' : 'block';
}

function changeProfilePic(input) {
    if (input.files && input.files[0]) {
        // Here you would typically upload the file to your server
        // This is just a basic example
        const formData = new FormData();
        formData.append('profilePic', input.files[0]);
        
        fetch('update_profile_pic.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function showUsernameForm() {
    const newUsername = prompt("Enter new username:");
    if (newUsername) {
        // Send to server to update
        fetch('update_username.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username: newUsername })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

// function logout() {
//     window.location.href = 'handlers/ajax/logout.php';
// }
function logout() {
        $.post("includes/handlers/ajax/logoutJson.php", function () {
            location.reload();
        });
    }
</script>
