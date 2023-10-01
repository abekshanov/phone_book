<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ action }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                        <div class="bg-white rounded shadow">
                            <form @submit.prevent="submit">
                                <div class="p-8 -mr-6 -mb-8">
                                    <div class="mb-3">
                                        <label class="form-label">first_name</label>
                                        <input disabled ref="input"
                                               class="form-control rounded-lg border-gray-300 pr-6 pb-2 w-full lg:w-1/2"
                                               :class="{ error: error }" :type="type"
                                               v-model="form.first_name"
                                               placeholder="First name">
                                        <div v-if="error" class="form-error">{{ error }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">surname</label>
                                        <input disabled ref="input"
                                               class="form-control rounded-lg border-gray-300 pr-6 pb-2 w-full lg:w-1/2"
                                               :class="{ error: error }" :type="type"
                                               v-model="form.surname"
                                               placeholder="Surname">
                                        <div v-if="error" class="form-error">{{ error }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">last_name</label>
                                        <input disabled ref="input"
                                               class="form-control rounded-lg border-gray-300 pr-6 pb-2 w-full lg:w-1/2"
                                               :class="{ error: error }" :type="type"
                                               v-model="form.last_name"
                                               placeholder="Last name">
                                        <div v-if="error" class="form-error">{{ error }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">phone</label>
                                        <input disabled ref="input"
                                               class="form-control rounded-lg border-gray-300 pr-6 pb-2 w-full lg:w-1/2"
                                               :class="{ error: error }" :type="type"
                                               v-model="form.phone"
                                               placeholder="Phone">
                                        <div v-if="error" class="form-error">{{ error }}</div>
                                    </div>

                                    <div class="form-group mb-6">
                                        <label>Is Favourite</label>
                                        <Checkbox disabled :id="form.favourite" v-model="form.favourite"
                                                  :error="errors.favourite"
                                                  class="pr-6 pb-4 w-auto mb-2 ml-2" label="Favourite"/>
                                    </div>

                                </div>
                            </form>
                        </div>


            </div>

        </div>
    </AuthenticatedLayout>


</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import Checkbox from "@/Components/Checkbox.vue";

export default {
    components: {
        Checkbox,
        Head, AuthenticatedLayout,
    },
    props: {
        contact: Object,
        errors: Object,
    },
    remember: 'form',
    data() {
        return {
            sending: false,
            form: {
                first_name: null,
                last_name: null,
                surname: null,
                phone: null,
                favourite: null,
            },
            action: 'View Contact',
        }
    },
    mounted() {
        console.log(this.contact);
        if (this.contact) {
            this.form = {
                first_name: this.contact.first_name,
                last_name: this.contact.last_name,
                surname: this.contact.surname,
                phone: this.contact.phone,
                favourite: this.contact.favourite,
            };

        }
    },
    methods: {

    },
}
</script>
