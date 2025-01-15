<script setup>
import { googleAuthCodeLogin } from "vue3-google-login";
import { useRouter } from 'vue-router';
import { ref } from 'vue';

const router = useRouter();
const userData = ref(null);

const gestioGoogleLogin = async () => {
    try {
        const response = await googleAuthCodeLogin();
        // console.log('Login amb Google correctament!', response);
        
        // Get user info from Google using the code
        const tokenResponse = await fetch('https://oauth2.googleapis.com/token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                code: response.code,
                client_id: import.meta.env.VITE_GOOGLE_CLIENT_ID,
                client_secret: import.meta.env.VITE_GOOGLE_CLIENT_SECRET,
                redirect_uri: window.location.origin,
                grant_type: 'authorization_code',
            }),
        });

        const { access_token } = await tokenResponse.json();
        
        // Get user information
        const userInfo = await fetch('https://www.googleapis.com/oauth2/v3/userinfo', {
            headers: { Authorization: `Bearer ${access_token}` },
        });
        
        userData.value = await userInfo.json();
        
        // Check if email domain is @inspedralbes.cat
        if (!userData.value.email?.endsWith('@inspedralbes.cat')) {
            throw new Error('Només es permet l\'accés amb comptes @inspedralbes.cat');
        }
        
        // Store user data
        localStorage.setItem('user', JSON.stringify(userData.value));
        
        // Redirect to dashboard
        router.push('/dashboard');
    } catch (error) {
        console.error('Error al iniciar sessio amb Google:', error);
        alert(error.message || 'Error al iniciar sessió amb Google');
    }
};
</script>

<template>
    <div class="social-login">
        <button class="social-button" @click="gestioGoogleLogin" aria-label="Entra amb Google">
            <img src="../icons/google.svg" alt="Google icon">
            <span>Google / @inspedralbes.cat</span>
        </button>
    </div>
</template>

<style scoped>
.social-login {
    display: flex;
    justify-content: center;
    width: 100%;
}

.social-button {
    width: 100%;
    height: 2.75rem;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 0.75rem;
    background: var(--input-background);
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    color: var(--text-primary);
    font-weight: 500;
}

.social-button:hover {
    border-color: var(--color-primary);
    transform: translateY(-2px);
}

.social-button img {
    width: 1.25rem;
    height: 1.25rem;
    opacity: 0.8;
}
</style>