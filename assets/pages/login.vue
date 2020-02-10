<template>
    <validation-observer v-slot="{ handleSubmit }">
        <form novalidate class="md-layout" @submit.prevent="handleSubmit(onSubmit)">
            <div class="md-layout ">
                <div class="md-layout-item md-xsmall-size-100 md-size-30">
                    <validation-provider rules="required" v-slot="{ errors }" name="Username">
                        <md-field :class="{'md-invalid': errors[0] }">
                            <label for="username">Username</label>
                            <md-input name="username" v-model="username" id="username"
                                      :disabled="isLoading"/>
                            <span class="md-error">{{ errors[0] }}</span>
                        </md-field>
                    </validation-provider>
                    <validation-provider rules="required" v-slot="{ errors }" name="Password">
                        <md-field :class="{'md-invalid': errors[0] }">
                            <label for="password">Password</label>
                            <md-input name="password" type="password" id="password" v-model="password"
                                      :disabled="isLoading"/>
                            <span class="md-error">{{ errors[0] }}</span>
                        </md-field>
                    </validation-provider>
                    <md-button type="submit" class="md-primary" :disabled="isLoading">Login</md-button>
                    <md-button type="button" :disabled="isLoading" to="/">Go back</md-button>
                </div>
            </div>
        </form>
    </validation-observer>
</template>

<script>
    import {extend, ValidationObserver, ValidationProvider, localize} from 'vee-validate';
    import { mapState} from 'vuex';
    import {required} from 'vee-validate/dist/rules';
    import en from 'vee-validate/dist/locale/en.json';
    import axios from "axios";

    localize('en', en);
    extend('required', required);

    export default {
        name: 'LoginForm',
        components: {
            ValidationProvider,
            ValidationObserver,
        },
        data: () => ({
            username: '',
            password: '',
        }),
        computed: {
            ...mapState([
                'isLoading'
            ])
        },
        methods: {
            onSubmit() {
                let self = this;
                try {
                    axios
                        .post(
                            '/api/login',
                            {
                                username: this.username,
                                password: this.password
                            }
                        )
                        .then( (response) => {
                            alert('OK');
                            self.$store.commit('stopLoading');
                        });
                } catch (error) {
                    if (error.response.data.error) {
                        self.$refs.form.setErrors({username: [error.response.data.error]});
                        return;
                    }
                    self.$store.commit('stopLoading');
                }
            },
        },
    }
</script>