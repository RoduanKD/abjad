<template>
  <authentication-card>
    <template #logo>
      <authentication-card-logo />
    </template>

    <v-form @submit.prevent="submit">
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="form.email"
            name="email"
            label="Email"
            type="email"
            hide-details="auto"
            autocomplete="email"
            :error-messages="errors['email']"
            outlined
            required
            autofocus
          />
        </v-col>
        <v-col cols="12">
          <v-text-field
            v-model="form.password"
            name="password"
            type="password"
            label="Password"
            hide-details="auto"
            autocomplete="new-password"
            :error-messages="errors['password']"
            outlined
            required
            autofocus
          />
        </v-col>
        <v-col cols="12">
          <v-text-field
            v-model="form.password_confirmation"
            name="password"
            type="password"
            label="Confirm Password"
            hide-details="auto"
            autocomplete="new-password"
            outlined
            required
            autofocus
          />
        </v-col>
        <v-col
          cols="12"
          class="d-flex align-center"
        >
          <v-btn
            color="primary"
            :disabled="form.processing"
            :loading="form.processing"
            @click="submit"
          >
            Reset Password
          </v-btn>
        </v-col>
      </v-row>
    </v-form>
  </authentication-card>
</template>

<script>
import AuthenticationCard from '@/components/Auth/AuthenticationCard'
import AuthenticationCardLogo from '@/components/Auth/AuthenticationCardLogo'
import AppLayout from '../../layouts/AppLayout'

export default {
  components: {
    AuthenticationCard,
    AuthenticationCardLogo,
  },

  layout: AppLayout,

  props: {
    email: {
      type: String,
      default: '',
    },
    token: {
      type: String,
      default: '',
    },
  },

  data () {
    return {
      form: this.$inertia.form({
        token: this.token,
        email: this.email,
        password: '',
        password_confirmation: '',
      }),
    }
  },

  methods: {
    submit () {
      this.form.post(this.route('password.update'), {
        onFinish: () => this.form.reset('password', 'password_confirmation'),
      })
    },
  },
}
</script>
