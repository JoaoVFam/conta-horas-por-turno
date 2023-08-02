<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps(['period']);
 
const form = useForm({
    check_in: props.period.check_in,
    check_out: props.period.check_out
});
 
const editing = ref(false);
</script>
 
<template>
    <div class="p-6 flex space-x-2">
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <span class="text-gray-800">{{ period.user.name }}</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex flex-grow justify-between items-center">
                    <p class="mt-4 text-lg text-gray-900">Inicio: {{ period.check_in }}</p>
                    <p class="mt-4 text-lg text-gray-900">Fim: {{ period.check_out }}</p>
                    <p class="mt-4 text-lg text-gray-900">Diurno: {{ period.day_time }}</p>
                    <p class="mt-4 text-lg text-gray-900">Noturno: {{ period.night_time }}</p>
                    <small v-if="period.created_at !== period.updated_at" class="text-sm text-gray-600"> &middot; editado</small>
                </div>
                <Dropdown class="" v-if="period.user.id === $page.props.auth.user.id">
                    <template #trigger>
                        <button style="margin-left: 20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Editar
                        </button>
                        <DropdownLink as="button" :href="route('periods.destroy', period.id)" method="delete">
                            Remover
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <form v-if="editing" @submit.prevent="form.put(route('periods.update', period.id), { onSuccess: () => editing = false })">
                <div class="flex justify-between items-center">
                    <label for="check_in">Início expediente: </label>
                    <input 
                        v-model="form.check_in" 
                        type="time" 
                        class="border-gray-300 rounded-md shadow-sm"    
                    />

                    <label for="check_out">Fim expediente: </label>
                    <input 
                        v-model="form.check_out" 
                        type="time" 
                        class="border-gray-300 rounded-md shadow-sm"
                    />
                </div>
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Salvar</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</template>