document.getElementById('adminBtn').addEventListener('click', function() {
    Swal.fire({
        title: 'Acceso Administrativo',
        html: `
            <input type="text" id="login" class="swal2-input" placeholder="Usuario">
            <input type="password" id="password" class="swal2-input" placeholder="Contraseña">
        `,
        confirmButtonText: 'Iniciar Sesión',
        focusConfirm: false,
        preConfirm: () => {
            const login = Swal.getPopup().querySelector('#login').value;
            const password = Swal.getPopup().querySelector('#password').value;
            if (!login || !password) {
                Swal.showValidationMessage('Por favor ingrese usuario y contraseña');
            }
            return { login, password }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value.login === "admin" && result.value.password === "admin123") {
                // Store admin data in localStorage
                localStorage.setItem('adminData', JSON.stringify({
                    isLoggedIn: true,
                    username: result.value.login,
                    loginTime: new Date().getTime()
                }));

                Swal.fire({
                    icon: 'success',
                    title: 'Acceso Correcto',
                    text: 'Redirigiendo al panel de administración...',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'dashboard.php';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Usuario o contraseña incorrectos'
                });
            }
        }
    });
});

// Check if admin is already logged in
window.addEventListener('load', function() {
    const adminData = JSON.parse(localStorage.getItem('adminData') || '{}');
    if (adminData.isLoggedIn) {
        const loginTime = adminData.loginTime || 0;
        const currentTime = new Date().getTime();
        const hoursPassed = (currentTime - loginTime) / (1000 * 60 * 60);
        
        // If login is less than 24 hours old, redirect to dashboard
        if (hoursPassed < 24) {
            window.location.href = 'dashboard.php';
        } else {
            // Clear expired login
            localStorage.removeItem('adminData');
        }
    }
});