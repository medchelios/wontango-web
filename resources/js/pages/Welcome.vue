<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

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

    if (form.feedback && form.feedback.length > 1000) {
        form.setError('feedback', 'Le feedback ne peut pas dépasser 1000 caractères.');
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
        }
    });
};

const showSuccess = computed(() => {
    return isSubmitted.value || props.flash?.success;
});
</script>

<template>
    <Head>
        <title>WontanGo - Commander pour vos proches en Guinée</title>
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-white">
        <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-8">
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <img src="/images/logo.jpeg" alt="WontanGo" class="h-16 w-auto mr-4 rounded-xl shadow-lg" />
                    <div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-2">
                            WontanGo
                        </h1>
                        <p class="text-xl text-yellow-600 font-bold">
                            Commander pour vos proches en Guinée
                        </p>
                    </div>
                </div>
                <p class="text-lg text-gray-600 max-w-4xl leading-relaxed">
                    Connectez-vous avec vos familles. Commandez des produits et faites-les livrer directement chez vos proches en toute simplicité.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 items-stretch">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex flex-col">
                    <div class="text-center mb-6">
                        <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            Rejoignez la liste d'attente
                        </h2>
                        <p class="text-gray-600">
                            Soyez informé dès le lancement officiel
                        </p>
                    </div>

                    <form @submit.prevent="submitForm" class="space-y-4 flex-1 flex flex-col">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Adresse email
                            </label>
                            <input
                                type="email"
                                id="email"
                                v-model="form.email"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300 text-gray-900 placeholder-gray-500"
                                placeholder="votre@email.com"
                            />
                            <div v-if="form.errors.email" class="text-red-600 text-sm mt-2 font-medium">
                                {{ form.errors.email }}
                            </div>
                        </div>

                        <div>
                            <label for="feedback" class="block text-sm font-semibold text-gray-700 mb-2">
                                Que souhaiteriez-vous commander ?
                            </label>
                            <textarea
                                id="feedback"
                                v-model="form.feedback"
                                rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-300 text-gray-900 placeholder-gray-500 resize-none"
                                placeholder="Partagez vos idées de produits pour vos proches en Guinée..."
                            ></textarea>
                            <div v-if="form.errors.feedback" class="text-red-600 text-sm mt-2 font-medium">
                                {{ form.errors.feedback }}
                            </div>
                        </div>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full bg-gray-900 text-white py-3 px-5 rounded-2xl font-semibold hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-[1.02] active:scale-[0.98] shadow-lg"
                        >
                            <span v-if="form.processing" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Envoi en cours...
                            </span>
                            <span v-else class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Rejoindre la liste d'attente
                            </span>
                        </button>

                        <div v-if="showSuccess" class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <p class="font-semibold">{{ props.flash?.success || 'Merci ! Nous vous tiendrons informé du lancement.' }}</p>
                            </div>
                        </div>
                        
                        <div v-if="props.flash?.error" class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="font-semibold">{{ props.flash.error }}</p>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="space-y-6 flex flex-col">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                            Comment ça fonctionne
                        </h2>

                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center shadow-lg">
                                        <span class="text-lg font-bold text-gray-700">1</span>
                                    </div>
                                </div>
                                <div class="flex-1 flex flex-col justify-center">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Commandez facilement</h3>
                                    <p class="text-sm text-gray-600 leading-relaxed flex-1">
                                        Parcourez notre catalogue et sélectionnez les produits que vous souhaitez envoyer à vos proches en Guinée.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center shadow-lg">
                                        <span class="text-lg font-bold text-gray-700">2</span>
                                    </div>
                                </div>
                                <div class="flex-1 flex flex-col justify-center">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Livraison rapide</h3>
                                    <p class="text-sm text-gray-600 leading-relaxed flex-1">
                                        Notre équipe locale s'occupe de la livraison avec suivi en temps réel jusqu'à destination en Guinée.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center shadow-lg">
                                        <span class="text-lg font-bold text-gray-700">3</span>
                                    </div>
                                </div>
                                <div class="flex-1 flex flex-col justify-center">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Confirmation garantie</h3>
                                    <p class="text-sm text-gray-600 leading-relaxed flex-1">
                                        Recevez une confirmation avec photo dès que vos proches ont reçu leur commande en Guinée.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <footer class="border-t border-gray-200 mt-8 pt-6">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid md:grid-cols-2 gap-6 text-center md:text-left">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Service disponible</h3>
                        <p class="text-sm text-gray-600 mb-3">
                            <strong>ColisMartGo</strong> - Service de livraison déjà actif en Guinée
                        </p>
                        <a 
                            href="https://colismartgo.com/" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="inline-flex items-center text-gray-700 font-medium border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Découvrir ColisMartGo
                        </a>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Garanties</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <div class="flex flex-col items-center text-center p-3 bg-green-50 rounded-lg border border-green-200">
                                <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span class="text-xs font-semibold text-green-800">Sécurisé SSL</span>
                            </div>
                            
                            <div class="flex flex-col items-center text-center p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                                </svg>
                                <span class="text-xs font-semibold text-blue-800">Support 24/7</span>
                            </div>
                            
                            <div class="flex flex-col items-center text-center p-3 bg-purple-50 rounded-lg border border-purple-200">
                                <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <span class="text-xs font-semibold text-purple-800">Paiement sécurisé</span>
                            </div>
                            
                            <div class="flex flex-col items-center text-center p-3 bg-orange-50 rounded-lg border border-orange-200">
                                <svg class="w-8 h-8 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                <span class="text-xs font-semibold text-orange-800">Suivi commande</span>
                            </div>
                            
                            <div class="flex flex-col items-center text-center p-3 bg-red-50 rounded-lg border border-red-200">
                                <svg class="w-8 h-8 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m5 14v-5a2 2 0 00-2-2H6a2 2 0 00-2 2v5a2 2 0 002 2h12a2 2 0 002-2z"></path>
                                </svg>
                                <span class="text-xs font-semibold text-red-800">Retour gratuit</span>
                            </div>
                            
                            <div class="flex flex-col items-center text-center p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <svg class="w-8 h-8 text-yellow-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                <span class="text-xs font-semibold text-yellow-800">Garantie qualité</span>
                            </div>
                            
                            <div class="flex flex-col items-center text-center p-3 bg-indigo-50 rounded-lg border border-indigo-200">
                                <svg class="w-8 h-8 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span class="text-xs font-semibold text-indigo-800">Livraison express</span>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </footer>
        </main>
    </div>
</template>