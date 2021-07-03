<template>
  <div class="section-container" style="height: 100%; width: 100%">
    <v-row class="signin">
      <v-col cols="8" class="left d-none d-sm-none d-md-flex">
        <h1></h1>
      </v-col>
      <v-col cols="12" sm="12" md="4" class="right">
        <h2>LOGIN</h2>
        <div>{{ message }}</div>
        <validation-observer ref="observer">
          <v-form @submit.prevent="submit">
            <validation-provider v-slot="{ errors }" name="Name" rules="required|email">
              <v-text-field
                v-model="email"
                :error-messages="errors"
                label="Email"
                :loading="loading"
                required
                outlined
                dark
                filled
                dense
              ></v-text-field>
            </validation-provider>
            <validation-provider v-slot="{ errors }" name="email" rules="required">
              <v-text-field
                v-model="password"
                :error-messages="errors"
                label="Password"
                :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPass = !showPass"
                required
                :loading="loading"
                outlined
                dense
                dark
                filled
                :type="showPass ? 'text' : 'password'"
              ></v-text-field>
            </validation-provider>
            <div class="text-center">
              <v-btn class="signin-btn" type="submit" :loading="loading" rounded color="white" dark>
                Sign In
              </v-btn>
            </div>
          </v-form>
        </validation-observer>
      </v-col>
    </v-row>
  </div>
</template>
<script>
import { required, email } from 'vee-validate/dist/rules'
import { extend, ValidationProvider, setInteractionMode, ValidationObserver } from 'vee-validate'
import { AUTH_REQUEST } from '@/constants.js'

setInteractionMode('eager')

extend('required', {
  ...required,
  message: '{_field_} can not be empty'
})

extend('email', {
  ...email,
  message: 'Email must be valid'
})

export default {
  components: {
    ValidationProvider,
    ValidationObserver
  },
  data: () => ({
    email: '',
    password: null,
    showPass: false,
    loading: false,
    message: ''
  }),
  computed: {
    params() {
      return {
        email: this.email,
        password: this.password
      }
    }
  },
  methods: {
    async submit() {
      const valid = await this.$refs.observer.validate()
      if (valid) {
        this.loading = true
        this.$store.dispatch('auth/'+ AUTH_REQUEST, {username: this.email, password: this.password }).then(resp => {
            console.log(resp)
            this.loading = false
            let icnt = 3;
            var url = '/user/'
            if (resp.isadmin) {
              url = '/admin/'
            }
            window.setTimeout(function() {
                icnt--
                this.message = 'Login success, wait '+ icnt + ' to redirect'
                if (icnt === 0) {
                    window.location.href = url
                }
            }, 1000)
        }).catch(err => {
            this.message = err
            this.loading = false
        })
      }
    },
    clear() {
      this.email = ''
      this.password = null
      this.$refs.observer.reset()
    }
  }
}
</script>
<style lang="scss">
html, body {
  height: 100%;
}
  .signin {
    padding: 0;
    width: 90%;
    height: 90%;
    margin: 0 auto;
    position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
    box-shadow: 0 0 1px 1px rgba($color: #000000, $alpha: 0.1);
    .left {
      padding: 30px;
      justify-content: center;
      align-items: center;
      box-sizing: border-box;
      display: flex;
      color: #05305a;
      background-color: #f9f9f9;
    }
    .right {
      padding: 30px;
      box-sizing: border-box;
      background: #05305a;
      color: #fff;
      h2 {
        text-align: center;
        margin: 30px 0;
      }
      .signin-btn {
        width: 100%;
        color: #05305a;
      }
    }
  }
</style>