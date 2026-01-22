<template>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-8">Каталог товаров</h1>

        <div class="mb-8 flex items-center space-x-4">
            <label for="category" class="text-gray-700"
                >Фильтр по категории:</label
            >
            <select
                id="category"
                v-model="selectedCategory"
                @change="fetchProducts"
                class="border-gray-300"
            >
                <option value="">Все категории</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                    {{ cat.name }}
                </option>
            </select>
        </div>

        <div v-if="loading" class="text-center py-10">Загрузка товаров...</div>

        <div
            v-else
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
        >
            <ProductCard
                v-for="product in products"
                :key="product.id"
                :card="product"
            />
        </div>

        <div
            v-if="pagination.last_page > 1"
            class="mt-8 flex justify-center space-x-2"
        >
            <button
                v-for="page in pagination.links"
                :key="page.label"
                @click="changePage(page.url)"
                :disabled="!page.url || page.active"
                v-html="page.label"
                class="px-4 py-2 border rounded-md"
            ></button>
        </div>

        <div
            v-if="!loading && products.length === 0"
            class="text-center py-10 text-gray-500"
        >
            Товары не найдены.
        </div>
    </div>
</template>

<script setup>
import ProductCard from "@/Components/ProductCard.vue";
import { onMounted, ref } from "vue";
import axios from "axios";

const products = ref([]);
const categories = ref([]);
const selectedCategory = ref("");
const loading = ref(true);
const pagination = ref({});
const currentPage = ref(1);

const fetchCategories = async () => {
    const response = await axios.get("/api/categories");
    categories.value = response.data;
};

const fetchProducts = async () => {
    try {
        loading.value = true;

        const response = await axios.get("/api/products", {
            params: {
                category_id: selectedCategory.value,
                page: currentPage.value,
            },
        });

        products.value = response.data.data;
        pagination.value = response.data;
    } catch (error) {
        console.error("Ошибка при загрузке товаров:", error);
    } finally {
        loading.value = false;
    }
};

const changePage = (url) => {
    if (!url) return;
    const urlParams = new URL(url, window.location.origin).searchParams;
    currentPage.value = urlParams.get("page") || 1;

    fetchProducts();
};


onMounted(() => {
    fetchCategories();
    fetchProducts();
});
</script>
