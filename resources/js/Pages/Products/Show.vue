<template>
    <div class="max-w-2xl mx-auto p-6">
        <Link href="/" class="text-blue-600 hover:underline mb-4 inline-block"
            >← Назад к списку</Link
        >

        <div v-if="loading" class="text-center py-10">Загрузка...</div>

        <div
            v-else-if="product"
            class="bg-white shadow-lg rounded-2xl p-8 border border-gray-100"
        >
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">
                        {{ product.name }}
                    </h1>
                    <span
                        class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold"
                    >
                        {{ product.category?.name }}
                    </span>
                </div>
                <div class="text-3xl font-bold text-green-600">
                    {{ product.price }} ₽
                </div>
            </div>

            <div class="prose max-w-none text-gray-700 text-lg leading-relaxed">
                <h3 class="text-gray-900 font-semibold mb-2">
                    Описание товара:
                </h3>
                {{ product.description }}
            </div>

            <div
                class="mt-10 pt-6 border-t border-gray-100 text-sm text-gray-500"
            >
                Добавлено:
                {{ new Date(product.created_at).toLocaleDateString() }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    id: String,
});

const product = ref(null);
const loading = ref(true);

const fetchProduct = async () => {
    try {
        const response = await axios.get(`/api/products/${props.id}`);
        product.value = response.data.data;
    } catch (error) {
        console.error("Товар не найден", error);
    } finally {
        loading.value = false;
    }
};

onMounted(fetchProduct);
</script>
