// ---- Mostrar/esconder contraseñas ----
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
        toggle.textContent = input.type === 'password' ? '👁' : '🙈';
    });
}

const passwordActual = document.getElementById('password_actual');
const passwordNueva  = document.getElementById('password_nueva');
const confirmPass    = document.getElementById('confirm_password');

addToggle(passwordActual);
addToggle(passwordNueva);
addToggle(confirmPass);

// ---- Validación coincidéncia de contraseñas ----
const matchMsg = document.createElement('span');
matchMsg.style.cssText = 'font-size:0.75rem; margin-top:0.2rem; display:block;';
confirmPass.parentElement.appendChild(matchMsg);

function checkPasswords() {
    if (confirmPass.value.length === 0) {
        matchMsg.textContent = '';
        return;
    }
    if (passwordNueva.value === confirmPass.value) {
        matchMsg.textContent = '✓ Las contraseñas coinciden';
        matchMsg.style.color = '#1D9E75';
    } else {
        matchMsg.textContent = '✗ Las contraseñas no coinciden';
        matchMsg.style.color = '#E24B4A';
    }
    updatePasswordButton();
}

confirmPass.addEventListener('input', checkPasswords);
passwordNueva.addEventListener('input', checkPasswords);

// ---- Indicador de fuerza de contraseña ----
const strengthBar  = document.createElement('div');
strengthBar.style.cssText = 'height:3px; border-radius:2px; margin-top:0.4rem; transition:all 0.3s ease; background:#E0DED8;';
const strengthText = document.createElement('span');
strengthText.style.cssText = 'font-size:0.75rem; color:#888; margin-top:0.2rem; display:block;';
passwordNueva.parentElement.appendChild(strengthBar);
passwordNueva.parentElement.appendChild(strengthText);

passwordNueva.addEventListener('input', () => {
    const val = passwordNueva.value;
    let strength = 0;
    if (val.length >= 8) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;

    const colors = ['#E24B4A', '#EF9F27', '#639922', '#1D9E75'];
    const labels = ['Débil', 'Regular', 'Buena', 'Fuerte'];
    const widths = ['25%', '50%', '75%', '100%'];

    if (val.length === 0) {
        strengthBar.style.width = '0';
        strengthText.textContent = '';
    } else {
        strengthBar.style.width      = widths[strength - 1] || '25%';
        strengthBar.style.background = colors[strength - 1] || colors[0];
        strengthText.textContent     = labels[strength - 1] || labels[0];
        strengthText.style.color     = colors[strength - 1] || colors[0];
    }
});

// ---- Deshabilitar botón de contraseña si campos vacíos ----
const passwordBtn = document.querySelector('form[action$="/password"] .btn-primary');

function updatePasswordButton() {
    const allFilled = passwordActual.value.length > 0
                   && passwordNueva.value.length >= 8
                   && passwordNueva.value === confirmPass.value;

    passwordBtn.disabled      = !allFilled;
    passwordBtn.style.opacity = allFilled ? '1' : '0.5';
    passwordBtn.style.cursor  = allFilled ? 'pointer' : 'not-allowed';
}

passwordActual.addEventListener('input', updatePasswordButton);
passwordNueva.addEventListener('input', updatePasswordButton);
confirmPass.addEventListener('input', updatePasswordButton);
updatePasswordButton();

// ---- Deshabilitar botón de datos personales si campos obligatorios vacíos ----
const nombre     = document.getElementById('nombre');
const email      = document.getElementById('email');
const profileBtn = document.querySelector('form[action$="/profile"] .btn-primary');

function updateProfileButton() {
    const emailValid   = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
    const nombreFilled = nombre.value.trim().length > 0;

    profileBtn.disabled      = !(emailValid && nombreFilled);
    profileBtn.style.opacity = profileBtn.disabled ? '0.5' : '1';
    profileBtn.style.cursor  = profileBtn.disabled ? 'not-allowed' : 'pointer';
}

nombre.addEventListener('input', updateProfileButton);
email.addEventListener('input', updateProfileButton);
updateProfileButton();

// ---- Desplegable de cambio de contraseña ----
const passwordCard    = document.querySelector('form[action$="/password"]').closest('.profile-card');
const passwordForm    = document.querySelector('form[action$="/password"]');
const passwordTitle   = passwordCard.querySelector('h2');

// Escondemos el formulario inicialmente
passwordForm.style.display = 'none';

// Creamos el botón toggle
const toggleBtn = document.createElement('button');
toggleBtn.type        = 'button';
toggleBtn.textContent = 'Cambiar contraseña';
toggleBtn.className   = 'btn-secondary';
toggleBtn.style.marginTop = '0';
passwordCard.appendChild(toggleBtn);

// Añadimos flecha al título
passwordTitle.style.cursor = 'pointer';
passwordTitle.style.display = 'flex';
passwordTitle.style.alignItems = 'center';
passwordTitle.style.justifyContent = 'space-between';

const arrow = document.createElement('span');
arrow.textContent  = '▸';
arrow.style.cssText = 'font-size:0.9rem; color:#888; transition: transform 0.2s ease;';
passwordTitle.appendChild(arrow);

// Toggle
let open = false;

function togglePassword() {
    open = !open;
    passwordForm.style.display  = open ? 'block' : 'none';
    toggleBtn.style.display     = open ? 'none' : 'inline-block';
    arrow.style.transform       = open ? 'rotate(90deg)' : 'rotate(0deg)';
}

toggleBtn.addEventListener('click', togglePassword);
passwordTitle.addEventListener('click', togglePassword);

// Si hay errores de contraseña, abrimos el desplegable automáticamente
const passwordErrors = document.querySelector('.alert-error');
if (passwordErrors && passwordCard.contains(passwordErrors)) {
    togglePassword();
}
