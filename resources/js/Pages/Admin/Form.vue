<template>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
        <h1 class="text-2xl font-bold mb-6">
            {{ id ? "Редактировать товар" : "Добавить новый товар" }}
        </h1>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <label class="block text-gray-700">Название</label>
                <input
                    v-model="form.name"
                    type="text"
                    required
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500"
                />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Категория</label>
                <select
                    v-model="form.category_id"
                    required
                    class="w-full border-gray-300 rounded-md shadow-sm"
                >
                    <option value="">Выберите категорию</option>
                    <option
                        v-for="cat in categories"
                        :key="cat.id"
                        :value="cat.id"
                    >
                        {{ cat.name }}
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Цена (₽)</label>
                <input
                    v-model.number="form.price"
                    type="number"
                    min="1"
                    required
                    class="w-full border-gray-300 rounded-md shadow-sm"
                />
            </div>

            <div class="mb-6">
                <label class="block text-gray-700">Описание</label>
                <textarea
                    v-model="form.description"
                    rows="4"
                    class="w-full border-gray-300 rounded-md shadow-sm"
                ></textarea>
            </div>

            <div class="flex justify-between items-center">
                <Link
                    href="/admin/products"
                    class="text-gray-600 hover:underline"
                    >Отмена</Link
                >
                <button
                    type="submit"
                    :disabled="loading"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 disabled:opacity-50"
                >
                    {{ loading ? "Сохранение..." : "Сохранить" }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({ id: String });
const categories = ref([]);
const loading = ref(false);

const form = reactive({
    name: "",
    category_id: "",
    price: 0,
    description: "",
});

onMounted(async () => {
    const token = localStorage.getItem("admin_token");
    if (!token) return router.visit("/login");


    const catRes = await axios.get("/api/categories");
    categories.value = catRes.data;

    if (props.id) {
        const prodRes = await axios.get(`/api/products/${props.id}`);
        const p = prodRes.data.data;
        form.name = p.name;
        form.category_id = p.category?.id;
        form.price = p.price;
        form.description = p.description;
    }
});

const submit = async () => {
    loading.value = true;
    const token = localStorage.getItem("admin_token");
    const config = { headers: { Authorization: `Bearer ${token}` } };

    try {
        if (props.id) {
            await axios.patch(`/api/products/${props.id}`, form, config);
        } else {
            await axios.post("/api/products", form, config);
        }
        router.visit("/admin/products");
    } catch (error) {
        alert(error.response?.data?.message || "Ошибка при сохранении");
    } finally {
        loading.value = false;
    }
};
</script>
