<script setup>
defineProps({
    modelValue: String,
    placeholder: String,
    hasError: Boolean
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <div class="input-wrapper">
        <input type="text" :value="modelValue" @input="emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder" :class="{ 'error': hasError }">
    </div>
</template>

<style scoped>
.input-wrapper {
    position: relative;
}

input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 0.75rem;
    font-size: 1rem;
    background: var(--input-background);
    transition: border-color 0.2s;
}

input:focus {
    outline: none;
    border-color: var(--color-primary);
}

input.error {
    border-color: #ff4d4f;
}

input::placeholder {
    color: #999;
}
</style>