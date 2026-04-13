const email    = document.getElementById('email');
const password = document.getElementById('password');
const btn      = document.getElementById('login-btn');
const form     = document.querySelector('form');

// ---- Mostrar/esconder contraseña ----
function addToggle(input) {
    const wrapper = input.parentElement;
    wrapper.style.position = 'relative';

    const toggle = document.createElement('button');
    toggle.type = 'button';
    toggle.textContent = '👁';
    toggle.style.cssText = 'position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; font-size:1rem; padding:0; color:#888;';

    wrapper.appendChild(toggle);
    input.style.paddingRight = '2.5rem';

    toggle.addEventListener('click', () => {
        input.type = input.type === 'password' ? 'text' : 'password';
        toggle.textContent = input.type === 'password' ? '👁' : '⌣';
    });
}

addToggle(password);

// ---- Deshabilitar botón si campos vacíos ----
function updateButton() {
    const emailValid = email.value.trim().length > 0;
    const passValid  = password.value.length > 0;

    btn.disabled      = !(emailValid && passValid);
    btn.style.opacity = btn.disabled ? '0.5' : '1';
    btn.style.cursor  = btn.disabled ? 'not-allowed' : 'pointer';
}

email.addEventListener('input', updateButton);
password.addEventListener('input', updateButton);
updateButton();

// ---- Bloquejar botó després d'un intent fallit ----
const hasErrors = document.querySelector('.auth-errors');

if (hasErrors) {
    let seconds = 5;
    btn.disabled      = true;
    btn.style.opacity = '0.5';
    btn.style.cursor  = 'not-allowed';
    btn.textContent   = `Espera ${seconds}s...`;

    const interval = setInterval(() => {
        seconds--;
        btn.textContent = `Espera ${seconds}s...`;

        if (seconds <= 0) {
            clearInterval(interval);
            btn.textContent   = 'Entrar';
            updateButton();
        }
    }, 1000);
}