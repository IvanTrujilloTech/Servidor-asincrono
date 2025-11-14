/**
 * Fichero JS principal para la práctica
 * Gestiona el login y el panel de administración (CRUD)
 */
document.addEventListener('DOMContentLoaded', () => {
    
    // Comprobamos en qué página estamos
    if (document.getElementById('login-form')) {
        initLoginPage();
    }
    
    if (document.getElementById('crud-app')) {
        initAdminDashboard();
    }
});

/**
 * Lógica para la página de Login (login.php)
 */
function initLoginPage() {
    const loginForm = document.getElementById('login-form');
    const errorMessage = document.getElementById('error-message');

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorMessage.classList.add('hidden'); // Ocultar error previo
        
        const email = loginForm.email.value;
        const password = loginForm.password.value;

        try {
            // Llamada a la API de autenticación
            const response = await fetch('auth.php?action=login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });

            const result = await response.json();

            if (result.ok) {
                // Login exitoso. Redirigir según el rol.
                if (result.user.rol === 'admin') {
                    window.location.href = 'index_ajax.html';
                } else {
                    window.location.href = 'sociograma.php';
                }
            } else {
                // Mostrar error de credenciales
                showError(errorMessage, result.error || 'Credenciales incorrectas.');
            }
        } catch (error) {
            // Mostrar error de red
            showError(errorMessage, 'Error de conexión. Inténtelo de nuevo.');
        }
    });
}


/**
 * Lógica para el Panel de Admin (index_ajax.html)
 */
async function initAdminDashboard() {
    // Referencias a elementos del DOM
    const appElement = document.getElementById('crud-app');
    const userNameElement = document.getElementById('user-name');
    const userTableBody = document.getElementById('user-table-body');
    const crudForm = document.getElementById('crud-form');
    const formTitle = document.getElementById('form-title');
    const userIdInput = document.getElementById('user-id');
    const passwordInput = document.getElementById('password');
    const cancelEditBtn = document.getElementById('cancel-edit');
    const apiMessage = document.getElementById('api-message');

    // Estado local para guardar los usuarios
    let allUsers = [];

    // --- 1. Verificación de Sesión ---
    // (Comprobar si somos admin antes de mostrar nada)
    try {
        const response = await fetch('auth.php?action=me');
        const result = await response.json();

        if (!result.ok || result.user.rol !== 'admin') {
            // Si no está autenticado o no es admin, fuera.
            window.location.href = 'login.php';
            return;
        }

        // Si es admin, mostramos la app y cargamos datos
        userNameElement.textContent = result.user.nombre;
        appElement.classList.remove('hidden');
        await loadUsers(); // Cargar la lista de usuarios

    } catch (error) {
        // Error de red, redirigir al login
        window.location.href = 'login.php';
        return;
    }

    // --- 2. Función para cargar y pintar usuarios ---
    async function loadUsers() {
        try {
            const response = await fetch('api.php?action=list');
            const result = await response.json();

            if (result.ok) {
                allUsers = result.data; // Guardar en estado local
                renderTable(allUsers);
            } else {
                showError(apiMessage, `Error al cargar usuarios: ${result.error}`);
            }
        } catch (error) {
            showError(apiMessage, 'Error de conexión con la API.');
        }
    }

    // --- 3. Función para pintar la tabla ---
    function renderTable(users) {
        userTableBody.innerHTML = ''; // Limpiar tabla
        if (users.length === 0) {
            userTableBody.innerHTML = '<tr><td colspan="5">No hay usuarios registrados.</td></tr>';
            return;
        }

        users.forEach(user => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${user.id}</td>
                <td>${user.nombre}</td>
                <td>${user.email}</td>
                <td><span class="role ${user.rol}">${user.rol}</span></td>
                <td>
                    <button class="btn btn-edit" data-id="${user.id}">Editar</button>
                    <button class="btn btn-delete" data-id="${user.id}">Eliminar</button>
                </td>
            `;
            userTableBody.appendChild(tr);
        });
    }

    // --- 4. Manejador del formulario (Crear y Actualizar) ---
    crudForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(crudForm);
        const data = Object.fromEntries(formData.entries());
        
        const isUpdate = data.id !== ''; // Si hay ID, es un UPDATE
        const action = isUpdate ? 'update' : 'create';
        
        // Si es update y la pass está vacía, no la enviamos para no sobreescribirla
        if (isUpdate && data.password === '') {
            delete data.password;
        }

        try {
            const response = await fetch(`api.php?action=${action}`, {
                method: 'POST', // Usamos POST para todo (create, update, delete)
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.ok) {
                allUsers = result.data; // La API devuelve la lista actualizada
                renderTable(allUsers);
                showSuccess(apiMessage, `Usuario ${isUpdate ? 'actualizado' : 'creado'} correctamente.`);
                resetForm(); // Limpiar formulario
            } else {
                showError(apiMessage, `Error: ${result.error}`);
            }
        } catch (error) {
            showError(apiMessage, 'Error de conexión al guardar.');
        }
    });

    // --- 5. Manejador de clics en la tabla (Editar y Eliminar) ---
    userTableBody.addEventListener('click', (e) => {
        const target = e.target;
        const id = target.dataset.id;

        if (!id) return; // Clic en un lugar no válido

        if (target.classList.contains('btn-delete')) {
            handleDelete(id);
        }

        if (target.classList.contains('btn-edit')) {
            handleEdit(id);
        }
    });

    // --- 6. Funciones de Acciones (Editar, Eliminar, Cancelar) ---
    
    function handleDelete(id) {
        if (!confirm(`¿Está seguro de que desea eliminar al usuario con ID ${id}?`)) {
            return;
        }
        
        fetch('api.php?action=delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id }) // Enviamos el ID a borrar
        })
        .then(res => res.json())
        .then(result => {
            if (result.ok) {
                allUsers = result.data; // API devuelve lista actualizada
                renderTable(allUsers);
                showSuccess(apiMessage, 'Usuario eliminado correctamente.');
                resetForm(); // Por si estaba editando este usuario
            } else {
                showError(apiMessage, `Error al eliminar: ${result.error}`);
            }
        })
        .catch(err => showError(apiMessage, 'Error de conexión al eliminar.'));
    }

    function handleEdit(id) {
        // Encontrar el usuario en nuestro estado local
        const user = allUsers.find(u => u.id == id);
        if (!user) return;

        // Rellenar el formulario
        formTitle.textContent = 'Editar Usuario';
        userIdInput.value = user.id; // Poner el ID en el campo oculto
        crudForm.nombre.value = user.nombre;
        crudForm.email.value = user.email;
        crudForm.rol.value = user.rol;
        passwordInput.value = ""; // Limpiar campo de contraseña
        passwordInput.placeholder = "Dejar en blanco para no cambiar";
        
        cancelEditBtn.classList.remove('hidden'); // Mostrar botón de cancelar
        window.scrollTo(0, 0); // Subir al formulario
    }

    function resetForm() {
        crudForm.reset();
        formTitle.textContent = 'Crear Nuevo Usuario';
        userIdInput.value = '';
        passwordInput.placeholder = "";
        cancelEditBtn.classList.add('hidden');
    }

    // Listener para el botón de cancelar edición
    cancelEditBtn.addEventListener('click', resetForm);
}


// --- Funciones de Utilidad (Mensajes) ---

function showMessage(element, message, type) {
    element.textContent = message;
    element.className = `message ${type}`; // Quita 'hidden' y añade tipo
    
    // Ocultar mensaje después de 4 segundos
    setTimeout(() => {
        element.classList.add('hidden');
    }, 4000);
}

function showError(element, message) {
    showMessage(element, message, 'error');
}

function showSuccess(element, message) {
    showMessage(element, message, 'success');
}
