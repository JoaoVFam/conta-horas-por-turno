<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Period from '@/Components/Period.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';

defineProps(['periods']);
 
const form = useForm({
    check_in: '',
    check_out: '',
});
</script>
 
<template>
    <Head title="Periods" />
 
    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('periods.store'), { onSuccess: () => form.reset() })">
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
                    <InputError :message="form.errors.check_in" class="mt-2" />
                    <InputError :message="form.errors.check_out" class="mt-2" />
                    <PrimaryButton>Adicionar</PrimaryButton>
                </div>
            </form>

            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Period
                    v-for="period in periods"
                    :key="period.id"
                    :period="period"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>