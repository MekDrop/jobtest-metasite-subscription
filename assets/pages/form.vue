<template>
    <validation-observer ref="form" v-slot="{ handleSubmit }">
        <form novalidate class="md-layout" @submit.prevent="handleSubmit(onSubmit)">
            <div class="md-layout ">
                <div class="md-layout-item md-xsmall-size-100 md-size-30">
                    <validation-provider rules="required" v-slot="{ errors }" name="name">
                        <md-field :class="{'md-invalid': errors[0] }">
                            <label for="name">Name</label>
                            <md-input name="name" autocomplete="given-name" v-model="name" id="name"
                                      :disabled="isLoading"/>
                            <span class="md-error">{{ errors[0] }}</span>
                        </md-field>
                    </validation-provider>
                    <validation-provider rules="required|email" v-slot="{ errors }" name="email">
                        <md-field :class="{'md-invalid': errors[0] }">
                            <label for="email">Email</label>
                            <md-input name="email" id="email" type="email" autocomplete="given-email" v-model="email"
                                      :disabled="isLoading"/>
                            <span class="md-error">{{ errors[0] }}</span>
                        </md-field>
                    </validation-provider>
                    <validation-provider rules="required" v-slot="{ errors }" name="categories">
                        <md-field :class="{'md-invalid': errors[0] }">
                            <label for="categories">Categories</label>
                            <md-select v-model="categories" name="categories" id="categories" multiple
                                       :disabled="isLoading">
                                <md-option v-for="(cat, index) in possibleCategories" :value="cat" :key="index">
                                    {{cat}}
                                </md-option>
                            </md-select>
                            <span class="md-error">{{ errors[0] }}</span>
                        </md-field>
                    </validation-provider>
                    <md-button type="submit" class="md-primary" :disabled="isLoading">Subscribe</md-button>
                </div>
            </div>
        </form>
        <md-snackbar md-position="center" :md-duration="4000" :md-active.sync="showMessage" md-persistent>
            <span>Thank you for subscription!</span>
        </md-snackbar>
    </validation-observer>
</template>

<script>
    import {extend, ValidationObserver, ValidationProvider, localize, ErrorBag } from 'vee-validate';
    import {mapGetters, mapState} from 'vuex';
    import {email, required} from 'vee-validate/dist/rules';
    import en from 'vee-validate/dist/locale/en.json';
    import axios from 'axios';

    localize('en', en);

    extend('email', email);
    extend('required', required);

    export default {
        name: 'RegistrationForm',
        components: {
            ValidationProvider,
            ValidationObserver,
        },
        data: () => ({
            name: '',
            email: '',
            categories: [],
            showMessage: false,
        }),
        computed: {
            ...mapGetters([
                'possibleCategories',
            ]),
            ...mapState([
                'isLoading'
            ])
        },
        methods: {
            onSubmit() {
                this.$store.commit('startLoading');
                let self = this;
                let form = new FormData();
                form.set('name', this.name);
                form.set('email', this.email);
                form.set('categories', this.categories.join(','));
                axios
                    .post(
                         '/api/subscribe',
                         form
                    )
                    .then( (response) => {
                        if (response.data.errors) {
                            self.$refs.form.setErrors(response.data.errors);
                            return;
                        }
                        self.showMessage = true;
                        self.email = '';
                        self.categories = [];
                        self.name = '';
                        self.$refs.form.reset();
                    })
                    .finally(() => {
                        self.$store.commit('stopLoading');
                    });
            },
        },
        mounted() {

        }
    }
</script>