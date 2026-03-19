<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up — YearOne</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Fraunces:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-body">

<div class="card">
    <div class="brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
        </div>
        <span class="brand-name">YearOne</span>
    </div>

    
    <h1>Sign up</h1>
    <p class="subtitle">Fill in the details below to get started</p>

    <form action="create.php" method="POST">
        <div class="row">
            <div class="field">
                <label for="firstname">First name</label>
                <input type="text" id="firstname" name="firstname" placeholder="Kayiranga" required>
            </div>
            <div class="field">
                <label for="lastname">Last name</label>
                <input type="text" id="lastname" name="lastname" placeholder="Jesus" required>
            </div>
        </div>

        <div class="field">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" placeholder="kayiranga@example.com" required>
        </div>

        <div class="field">
            <label for="gender">Gender</label>
            <div class="select-wrapper">
                <select id="gender" name="gender" required>
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>

        <div class="divider"></div>

        <div class="field">
            <label for="password">Password</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Create a strong password" required>
                <button type="button" class="toggle-pw" onclick="togglePassword()" title="Show/hide password">
                    <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="submit-btn" name="submit">Create account</button>
    </form>

    <p class="bottom-link">Already have an account? <a href="login.php">Sign in</a></p>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
    }
}
</script>
</body>
</html>