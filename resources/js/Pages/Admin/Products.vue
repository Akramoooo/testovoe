<template>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Управление товарами</h1>
            <div class="space-x-4">
                <Link href="/admin/products/create" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    + Добавить товар
                </Link>
                <button @click="logout" class="text-red-600 hover:underline">Выйти</button>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase">
                        <th class="px-5 py-3">Название</th>
                        <th class="px-5 py-3">Категория</th>
                        <th class="px-5 py-3">Цена</th>
                        <th class="px-5 py-3 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products" :key="product.id" class="border-b h-16 border-gray-100 hover:bg-gray-50 transition">
                        <td class="px-5 py-2 text-sm font-medium text-gray-900">{{ product.name }}</td>
                        <td class="px-5 py-2 text-sm text-gray-600">{{ product.category?.name }}</td>
                        <td class="px-5 py-2 text-sm font-semibold text-gray-900">{{ product.price }} ₽</td>
                        <td class="px-5 py-2 text-sm text-right space-x-3">
                            <Link :href="`/admin/products/${product.id}/edit`" class="text-blue-600 hover:text-blue-900">Редактировать</Link>
                            <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900">Удалить</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="pagination.last_page > 1" class="mt-6 flex justify-center items-center space-x-1">
            <button 
                v-for="(link, index) in pagination.links" 
                :key="index"
                @click="changePage(link.url)"
                v-html="link.label"
                :disabled="!link.url || link.active"
                class="px-3 py-1 border rounded transition-colors duration-200"
                :class="{
                    'bg-blue-600 text-white border-blue-600': link.active,
                    'text-gray-500 hover:bg-gray-100': link.url && !link.active,
                    'text-gray-300 cursor-not-allowed': !link.url
                }"
            ></button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";

const products = ref([]);
const pagination = ref({});

const fetchProducts = async (url = "/api/products") => {
    const token = localStorage.getItem("admin_token");
    try {
        const response = await axios.get(url, {
            headers: { Authorization: `Bearer ${token}` },
        });

        products.value = response.data.data;
        pagination.value = response.data; 
    } catch (error) {
        if (error.response?.status === 401) {
            router.visit('/login'); 
        }
    }
};

const changePage = (url) => {
    if (url) fetchProducts(url);
};

const deleteProduct = async (id) => {
    if (confirm("Вы уверены, что хотите удалить этот товар?")) {
        try {
            const token = localStorage.getItem("admin_token");
            await axios.delete(`/api/products/${id}`, {
                headers: { Authorization: `Bearer ${token}` },
            });
            
            if (products.value.length === 1 && pagination.value.current_page > 1) {
                fetchProducts(`${pagination.value.path}?page=${pagination.value.current_page - 1}`);
            } else {
                fetchProducts();
            }
        } catch (error) {
            alert("Ошибка при удалении.");
        }
    }
};

const logout = () => {
    localStorage.removeItem("admin_token");
    router.visit("/");
};

onMounted(fetchProducts);
</script>