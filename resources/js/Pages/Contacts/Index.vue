<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contacts</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div>
                            <div class="mb-6 flex justify-between items-center">
                                <a class="btn btn-sm border bg-green-400 hover:bg-green-500 text-white rounded-lg"
                                   :href="route('contacts.create')">
                                    <span>Create</span>
                                </a>
                            </div>

                            <div class="bg-white rounded shadow overflow-x-auto">
                                <table class="w-full whitespace-no-wrap">
                                    <tr class="text-left font-bold">
                                        <th class="px-6 pt-6 pb-2">ID</th>
                                        <th class="px-6 pt-6 pb-2">first_name</th>
                                        <th class="px-6 pt-6 pb-2">surname</th>
                                        <th class="px-6 pt-6 pb-2">last_name</th>
                                        <th class="px-6 pt-6 pb-2">phone</th>
                                        <th class="px-6 pt-6 pb-2">favourite</th>
                                        <th class="px-6 pt-6 pb-2">created_at</th>
                                        <th class="px-6 pt-6 pb-2">actions</th>
                                    </tr>
                                    <tr v-for="contact in contacts.data" :key="contact.id"
                                        class="hover:bg-gray-100">
                                        <td class="border-t">
                                            <a class="px-6 py-4 flex items-center" target="_blank"
                                               :href="route('contacts.show', contact.id)">
                                                {{ contact.id }}
                                            </a>
                                        </td>
                                        <td class="border-t">
                                            <a class="px-6 py-4 flex items-center" target="_blank"
                                               :href="route('contacts.show', contact.id)">
                                                {{ contact.first_name }}
                                            </a>
                                        </td>
                                        <td class="border-t">
                                            <a class="px-6 py-4 flex items-center" target="_blank"
                                               :href="route('contacts.show', contact.id)" tabindex="-1">
                                                {{ contact.surname }}
                                            </a>
                                        </td>
                                        <td class="border-t">
                                            <a class="px-6 py-4 flex items-center" target="_blank"
                                               :href="route('contacts.show', contact.id)" tabindex="-1">
                                                {{ contact.last_name }}
                                            </a>
                                        </td>
                                        <td class="border-t">
                                            <a class="px-6 py-4 flex items-center" target="_blank"
                                               :href="route('contacts.show', contact.id)" tabindex="-1">
                                                {{ contact.phone }}
                                            </a>
                                        </td>
                                        <td class="border-t">
                                            <a class="px-6 py-4 flex items-center" target="_blank"
                                               :href="route('contacts.show', contact.id)" tabindex="-1">
                                                {{ contact.favourite }}
                                            </a>
                                        </td>
                                        <td class="border-t">
                                            <a class="px-6 py-4 flex items-center" target="_blank"
                                               :href="route('contacts.show', contact.id)" tabindex="-1">
                                                {{ contact.created_at }}
                                            </a>
                                        </td>


                                        <td class="border-tx w-px">
                                            <a class="btn btn-sm border bg-red-400 hover:text-white  rounded-lg"
                                               @click="destroy(contact.id)">
                                                <i class="bi-trash"></i>
                                            </a>
                                            <a class="btn btn-sm border bg-blue-400 hover:text-white  rounded-lg"
                                               :href="route('contacts.edit', contact.id)">
                                                <i class="bi-pencil"></i>
                                            </a>
                                            <a class="btn btn-sm border bg-white hover:text-yellow-300 rounded-lg"
                                               @click="update(contact.id, !contact.favourite)">
                                                <i v-if="contact.favourite" class="bi-star-fill text-yellow-300"></i>
                                                <i v-else class="bi-star"></i>
                                            </a>
                                        </td>


                                    </tr>
                                    <tr v-if="contacts.data.length === 0">
                                        <td class="border-t px-6 py-4" colspan="4">No contacts found.</td>
                                    </tr>
                                </table>
                            </div>

                            <pagination :links="contacts.links"/>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
<script>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

export default {
    components: {Pagination, AuthenticatedLayout, Head},
    props: {
        data: Object,
        contacts: Object,
    },
    data() {
        return {
            editMode: false,
            form: {
                name: null,
                phone: null,
            },
        }
    },
    mounted() {

    },
    methods: {
        update: function (id, data) {
            this.$inertia.put('contacts/' + id, {
                favourite: data
            });
        },
        destroy: function (id) {
            this.$inertia.delete('contacts/' + id);
        },
    }
}
</script>