<script setup lang="ts">
import WelcomeFooter from '@/components/WelcomeFooter.vue';
import WelcomeForm from '@/components/WelcomeForm.vue';
import WelcomeHeader from '@/components/WelcomeHeader.vue';
import WelcomeSteps from '@/components/WelcomeSteps.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{
    flash?: {
        success?: string;
        error?: string;
    };
}>();
</script>

<template>
    <Head>
        <title>WontanGo - Commander pour vos proches en Guinée</title>
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-white">
        <main class="mx-auto max-w-6xl px-4 pt-4 pb-8 sm:px-6 lg:px-8">
            <WelcomeHeader />

            <div class="grid items-stretch gap-8 lg:grid-cols-2">
                <WelcomeForm :flash="props.flash" />
                <WelcomeSteps />
            </div>

            <WelcomeFooter />
        </main>
    </div>
</template>
