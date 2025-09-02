<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps<{
    flash?: {
        success?: string;
        error?: string;
    };
}>();

const isSubmitted = ref(false);

const form = useForm({
    email: '',
    feedback: '',
});

const submitForm = () => {
    if (!form.email || !form.email.includes('@')) {
        form.setError('email', 'Veuillez entrer une adresse email valide.');
        return;
    }

    form.email = form.email.toLowerCase().trim();
    if (form.feedback) {
        form.feedback = form.feedback.trim();
    }

    form.post('/leads', {
        onSuccess: () => {
            isSubmitted.value = true;
            form.reset();

            setTimeout(() => {
                isSubmitted.value = false;
            }, 5000);
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};

const showSuccess = computed(() => {
    return isSubmitted.value || props.flash?.success;
});
</script>

<template>
    <div class="flex flex-col rounded-2xl border border-gray-100 bg-white p-6 shadow-lg">
        <div class="mb-6 text-center">
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100">
                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </div>
            <h2 class="mb-2 text-2xl font-bold text-gray-900">Rejoignez la liste d'attente</h2>
            <p class="text-gray-600">Soyez informé dès le lancement officiel</p>
        </div>

        <form @submit.prevent="submitForm" class="flex flex-1 flex-col space-y-4">
            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-gray-700"> Adresse email </label>
                <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    required
                    class="w-full rounded-2xl border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-transparent focus:ring-2 focus:ring-gray-500"
                    placeholder="votre@email.com"
                />
                <div v-if="form.errors.email" class="mt-2 text-sm font-medium text-red-600">
                    {{ form.errors.email }}
                </div>
            </div>

            <div>
                <label for="feedback" class="mb-2 block text-sm font-semibold text-gray-700"> Que souhaiteriez-vous commander ? </label>
                <textarea
                    id="feedback"
                    v-model="form.feedback"
                    rows="3"
                    class="w-full resize-none rounded-2xl border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-500 transition-all duration-300 focus:border-transparent focus:ring-2 focus:ring-gray-500"
                    placeholder="Partagez vos idées de produits pour vos proches en Guinée..."
                ></textarea>
                <div v-if="form.errors.feedback" class="mt-2 text-sm font-medium text-red-600">
                    {{ form.errors.feedback }}
                </div>
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="w-full transform rounded-2xl bg-gray-900 px-5 py-3 font-semibold text-white shadow-lg transition-all duration-300 hover:scale-[1.02] hover:bg-gray-800 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:outline-none active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50"
            >
                <span v-if="form.processing" class="flex items-center justify-center">
                    <svg class="mr-3 -ml-1 h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                    Envoi en cours...
                </span>
                <span v-else class="flex items-center justify-center">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Rejoindre la liste d'attente
                </span>
            </button>

            <div v-if="showSuccess" class="rounded-2xl border border-green-200 bg-green-50 px-6 py-4 text-green-800">
                <div class="flex items-center">
                    <svg class="mr-3 h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="font-semibold">{{ props.flash?.success || 'Merci ! Nous vous tiendrons informé du lancement.' }}</p>
                </div>
            </div>

            <div v-if="props.flash?.error" class="rounded-2xl border border-red-200 bg-red-50 px-6 py-4 text-red-800">
                <div class="flex items-center">
                    <svg class="mr-3 h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                    </svg>
                    <p class="font-semibold">{{ props.flash.error }}</p>
                </div>
            </div>
        </form>
    </div>
</template>
