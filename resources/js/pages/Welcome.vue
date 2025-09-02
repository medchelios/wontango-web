<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const email = ref('');
const feedback = ref('');
const isSubmitting = ref(false);
const isSubmitted = ref(false);

const submitForm = async () => {
    isSubmitting.value = true;
    
    // Simuler l'envoi du formulaire
    await new Promise(resolve => setTimeout(resolve, 1000));
    
    isSubmitted.value = true;
    isSubmitting.value = false;
    
    // Reset form
    email.value = '';
    feedback.value = '';
    
    // Reset success message after 5 seconds
    setTimeout(() => {
        isSubmitted.value = false;
    }, 5000);
};
</script>

<template>
    <Head title="WontanGo - Commander pour vos proches en Guinée">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-white">
        <!-- Logo Section -->
        <section class="py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <img src="/images/logo.jpeg" alt="WontanGo" class="mx-auto mb-8 max-w-xs" />
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Commander pour vos proches en Guinée
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    WontanGo est la plateforme qui connecte la diaspora guinéenne avec leurs familles. 
                    Commandez des produits et faites-les livrer directement chez vos proches en Guinée.
                </p>
            </div>
        </section>

        <!-- Concept Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                        Comment ça marche
                    </h2>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-xl font-bold text-white">1</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Commandez en ligne</h3>
                        <p class="text-gray-600">Parcourez notre catalogue et passez votre commande depuis votre pays de résidence</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-xl font-bold text-white">2</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Nous livrons</h3>
                        <p class="text-gray-600">Notre équipe locale s'occupe de la livraison chez vos proches</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-xl font-bold text-white">3</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Vos proches reçoivent</h3>
                        <p class="text-gray-600">Livraison sécurisée avec notification de confirmation</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Form Section -->
        <section class="py-20">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                        Soyez parmi les premiers
                    </h2>
                    <p class="text-lg text-gray-600">
                        Inscrivez-vous pour être informé du lancement
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-8">
                    <form @submit.prevent="submitForm" class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Votre email
                            </label>
                            <input
                                type="email"
                                id="email"
                                v-model="email"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="votre@email.com"
                            />
                        </div>

                        <div>
                            <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">
                                Que souhaiteriez-vous commander pour vos proches en Guinée ?
                            </label>
                            <textarea
                                id="feedback"
                                v-model="feedback"
                                rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="Dites-nous quels types de produits vous aimeriez commander..."
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            :disabled="isSubmitting"
                            class="w-full bg-gray-800 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="isSubmitting">Envoi en cours...</span>
                            <span v-else>M'inscrire pour le lancement</span>
                        </button>

                        <div v-if="isSubmitted" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                            <p class="font-medium">Merci ! Nous vous tiendrons informé du lancement de WontanGo.</p>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-100 py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-gray-600">
                    © 2024 WontanGo. Tous droits réservés.
                </p>
            </div>
        </footer>
    </div>
</template>