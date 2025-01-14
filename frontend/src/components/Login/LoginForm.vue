<script setup>
import { ref, onMounted } from 'vue'; // Añade onMounted
import { useRouter, useRoute } from 'vue-router'; // Importa useRouter y useRoute
import SocialLogin from './SocialLogin.vue';
import PasswordInput from './PasswordInput.vue';
import TextInput from './TextInput.vue';

const router = useRouter();
const route = useRoute();

const email = ref('');
const password = ref('');
const isLoading = ref(false);
const msgError = ref('');
const successMessage = ref('');

// Comprueba si hay un mensaje de registro exitoso
onMounted(() => {
    if (route.query.registered === 'true') {
        successMessage.value = 'Usuari registrat correctament. Inicia sessió.';
    }
});

// Valida el formulario
const validateForm = () => {
    if (!email.value) {
        msgError.value = "El email és obligatori";
        return false;
    }
    if (!password.value) {
        msgError.value = 'La contrasenya és obligatoria';
        return false;
    }
    return true;
};

// Enviar el formulario de login
const gestioSubmit = async (e) => {
    e.preventDefault();
    msgError.value = '';
    successMessage.value = '';

    if (!validateForm()) return;

    isLoading.value = true;

    try {
        const response = await fetch('http://pruebag10.daw.inspedralbes.cat/backend/public/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email.value,
                password: password.value,
            }),
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error('No s\'ha pogut iniciar la sessió. Si us plau, torna-ho a provar.');
        }

        // Guardar el token, rol y usuario en localStorage
        localStorage.setItem('auth_token', data.token);
        localStorage.setItem('role', data.role);
        localStorage.setItem('user', JSON.stringify(data.user));

        // Redirigir a la vista correspondiente según el rol
        if (data.role === 'admin') {
            router.push('/dashboard');
        } else if (data.role === 'profesor') {
            router.push('/dashboard');
        } else if (data.role === 'alumno') {
            router.push('/student/dashboard');
        }

    } catch (err) {
        msgError.value = err.message || "No s'ha pogut iniciar la sessió. Si us plau, torna-ho a provar.";
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <div class="login-container">
        <div class="login-content">
            <div class="login-header">
                <h1>Benvingut!</h1>
                <p>Gestió d'informació académica</p>
            </div>

            <form @submit="gestioSubmit" class="login-form">
                <!-- Añade un mensaje de éxito cuando se registra un usuario -->
                <div v-if="successMessage" class="success-message">
                    {{ successMessage }}
                </div>

                <TextInput v-model="email" placeholder="Email" :has-msgError="msgError && !email" />

                <PasswordInput v-model="password" :has-msgError="msgError && !password" />

                <div class="forgot-password">
                    <a href="#">Heu oblidat la contrasenya?</a>
                </div>

                <button type="submit" class="sign-in-button" :disabled="isLoading">
                    {{ isLoading ? 'Iniciant sessió...' : 'Iniciar sessió' }}
                </button>

                <div v-if="msgError" class="msgError-message">
                    {{ msgError }}
                </div>

                <div class="divider"></div>
                <div class="register-link">
                    <p>No tens un compte? <a @click.prevent="router.push('/register')"> <b class="cursor-pointer">Registrar-se</b></a></p>
                </div>

                <SocialLogin />
            </form>
        </div>
    </div>
</template>

<style scoped>
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.login-content {
    width: 100%;
    max-width: 380px;
    background: var(--card-background);
    padding: 2rem 1.5rem;
    border-radius: 1.25rem;
    backdrop-filter: blur(10px);
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

h1 {
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

p {
    color: var(--text-secondary);
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.forgot-password {
    text-align: right;
    margin-top: -0.5rem;
}

.forgot-password a {
    color: var(--text-secondary);
    font-size: 0.875rem;
    text-decoration: none;
}

.sign-in-button {
    background: var(--color-primary);
    color: white;
    border: none;
    padding: 0.875rem;
    border-radius: 0.75rem;
    font-weight: 500;
    font-size: 1rem;
    cursor: pointer;
    transition: opacity 0.2s;
    margin-top: 0.5rem;
}

.sign-in-button:hover {
    opacity: 0.9;
}

.sign-in-button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.error-message {
    color: #ff4d4f;
    font-size: 0.875rem;
    text-align: center;
}



.divider {
    position: relative;
    margin: 1.5rem 0;
    height: 1px;
    background: rgba(0, 0, 0, 0.1);
}

@media (min-width: 768px) {
    .login-content {
        padding: 2.5rem;
    }
}
</style>
