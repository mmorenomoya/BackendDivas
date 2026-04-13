
const nombre   = document.getElementById('nombre');
const email    = document.getElementById('email');
const password = document.getElementById('password');
const confirm  = document.getElementById('confirm_password');
const btn      = document.getElementById('register-btn');

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
addToggle(confirm);

// ---- Indicador de fuerza de contraseña ----
const strengthBar = document.createElement('div');
strengthBar.style.cssText = 'height:3px; border-radius:2px; margin-top:0.4rem; transition:all 0.3s ease; background:#E0DED8;';
const strengthText = document.createElement('span');
strengthText.style.cssText = 'font-size:0.75rem; color:#888; margin-top:0.2rem; display:block;';
password.parentElement.appendChild(strengthBar);
password.parentElement.appendChild(strengthText);

password.addEventListener('input', () => {
    const val = password.value;
    let strength = 0;
    if (val.length >= 8) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;

    const colors  = ['#E24B4A', '#EF9F27', '#639922', '#1D9E75'];
    const labels  = ['Débil', 'Regular', 'Buena', 'Fuerte'];
    const widths  = ['25%', '50%', '75%', '100%'];

    if (val.length === 0) {
        strengthBar.style.width = '0';
        strengthText.textContent = '';
    } else {
        strengthBar.style.width  = widths[strength - 1] || '25%';
        strengthBar.style.background = colors[strength - 1] || colors[0];
        strengthText.textContent = labels[strength - 1] || labels[0];
        strengthText.style.color = colors[strength - 1] || colors[0];
    }

    checkPasswords();
    updateButton();
});

// ---- Validación coincidéncia de contraseñas ----
const matchMsg = document.createElement('span');
matchMsg.style.cssText = 'font-size:0.75rem; margin-top:0.2rem; display:block;';
confirm.parentElement.appendChild(matchMsg);

function checkPasswords() {
    if (confirm.value.length === 0) {
        matchMsg.textContent = '';
        return;
    }
    if (password.value === confirm.value) {
        matchMsg.textContent = '✓ Las contraseñas coinciden';
        matchMsg.style.color = '#1D9E75';
    } else {
        matchMsg.textContent = '✗ Las contraseñas no coinciden';
        matchMsg.style.color = '#E24B4A';
    }
    updateButton();
}

confirm.addEventListener('input', checkPasswords);

// ---- Validación email en tiempo real ----
const emailMsg = document.createElement('span');
emailMsg.style.cssText = 'font-size:0.75rem; margin-top:0.2rem; display:block;';
email.parentElement.appendChild(emailMsg);

email.addEventListener('input', () => {
    const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
    if (email.value.length === 0) {
        emailMsg.textContent = '';
    } else if (valid) {
        emailMsg.textContent = '✓ Email válido';
        emailMsg.style.color = '#1D9E75';
    } else {
        emailMsg.textContent = '✗ Formato de email no válido';
        emailMsg.style.color = '#E24B4A';
    }
    updateButton();
});

// ---- Deshabilitar botón si campos vacíos ---- 
function updateButton() {
    const emailValid    = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
    const passwordValid = password.value.length >= 8;
    const passwordMatch = password.value === confirm.value;
    const nombreFilled  = nombre.value.trim().length > 0;

    btn.disabled = !(emailValid && passwordValid && passwordMatch && nombreFilled);
    btn.style.opacity  = btn.disabled ? '0.5' : '1';
    btn.style.cursor   = btn.disabled ? 'not-allowed' : 'pointer';
}

nombre.addEventListener('input', updateButton);
updateButton();
