<script setup>
defineProps(['period']);
</script>
 
<template>
    <div class="p-6 flex space-x-2">
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <span class="text-gray-800">{{ period.user.name }}</span>
            </div>
            <div class="flex justify-evenly items-center">
                <p class="mt-4 text-lg text-gray-900">Inicio: {{ period.time_start }}</p>
                <p class="mt-4 text-lg text-gray-900">Fim: {{ period.time_end }}</p>
                <p class="mt-4 text-lg text-gray-900">Diurno: {{ period.day_time }}</p>
                <p class="mt-4 text-lg text-gray-900">Noturno: {{ period.night_time }}</p>
            </div>   
        </div>
    </div>
</template>