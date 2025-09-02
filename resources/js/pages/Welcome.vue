<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const email = ref('');
const feedback = ref('');
const isSubmitting = ref(false);
const isSubmitted = ref(false);

const submitForm = async () => {
    isSubmitting.value = true;
    
    try {
        const response = await fetch('/leads', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            body: JSON.stringify({
                email: email.value,
                feedback: feedback.value,
            }),
        });

        const data = await response.json();

        if (data.success) {
            isSubmitted.value = true;
            // Reset form
            email.value = '';
            feedback.value = '';
            
            // Reset success message after 5 seconds
            setTimeout(() => {
                isSubmitted.value = false;
            }, 5000);
        } else {
            alert(data.message || 'Une erreur est survenue');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Une erreur est survenue. Veuillez réessayer.');
    } finally {
        isSubmitting.value = false;
    }
};
</script>

<template>
    <Head title="WontanGo - Commander pour vos proches en Guinée">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-white">
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center items-center py-4">
                    <img src="/images/logo.jpeg" alt="WontanGo" class="h-24 sm:h-28 lg:h-20 w-auto" />
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-16">
            <!-- Hero Section -->
            <div class="text-center mb-12 lg:mb-16">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    Commander pour vos 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600">
                        proches en Guinée
                    </span>
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    WontanGo connecte la diaspora guinéenne avec leurs familles. 
                    Commandez des produits et faites-les livrer directement chez vos proches.
                </p>
            </div>

            <!-- Content Grid -->
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-start">
                <!-- Form Section -->
                <div class="order-1 lg:order-1">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">
                                Soyez parmi les premiers
                            </h2>
                            <p class="text-gray-600">
                                Inscrivez-vous pour être informé du lancement
                            </p>
                        </div>

                        <form @submit.prevent="submitForm" class="space-y-6">
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Votre adresse email
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    v-model="email"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200 text-gray-900 placeholder-gray-500"
                                    placeholder="votre@email.com"
                                />
                            </div>

                            <div>
                                <label for="feedback" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Que souhaiteriez-vous commander ?
                                </label>
                                <textarea
                                    id="feedback"
                                    v-model="feedback"
                                    rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200 text-gray-900 placeholder-gray-500 resize-none"
                                    placeholder="Dites-nous quels types de produits vous aimeriez commander pour vos proches en Guinée..."
                                ></textarea>
                            </div>

                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="w-full bg-gray-900 text-white py-4 px-6 rounded-xl font-semibold hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-[1.02] active:scale-[0.98]"
                            >
                                <span v-if="isSubmitting" class="flex items-center justify-center">
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
                                    M'inscrire pour le lancement
                                </span>
                            </button>

                            <div v-if="isSubmitted" class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <p class="font-medium">Merci ! Nous vous tiendrons informé du lancement.</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- How it works Section -->
                <div class="order-2 lg:order-2">
                    <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 sm:p-8 border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">
                            Comment ça marche
                        </h2>

                        <div class="space-y-8">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gray-900 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-lg font-bold text-white">1</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Commandez en ligne</h3>
                                    <p class="text-gray-600 leading-relaxed">
                                        Parcourez notre catalogue de produits disponibles en Guinée et passez votre commande depuis votre pays de résidence.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gray-900 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-lg font-bold text-white">2</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Nous livrons</h3>
                                    <p class="text-gray-600 leading-relaxed">
                                        Notre équipe locale en Guinée s'occupe de la livraison directement chez vos proches avec suivi en temps réel.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gray-900 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-lg font-bold text-white">3</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Vos proches reçoivent</h3>
                                    <p class="text-gray-600 leading-relaxed">
                                        Livraison sécurisée avec notification de confirmation. Vous êtes informé dès que vos proches reçoivent leurs commandes.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Trust indicators -->
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">100%</div>
                                    <div class="text-sm text-gray-600">Sécurisé</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">24/7</div>
                                    <div class="text-sm text-gray-600">Support</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <div class="flex justify-center items-center mb-4">
                        <img src="/images/logo.jpeg" alt="WontanGo" class="h-8 w-auto opacity-60" />
                    </div>
                    <p class="text-gray-500 text-sm">
                        © 2024 WontanGo. Tous droits réservés.
                    </p>
                    <p class="text-gray-400 text-xs mt-2">
                        Connecter la diaspora guinéenne avec leurs familles
                    </p>
                </div>
        </div>
        </footer>
    </div>
</template>