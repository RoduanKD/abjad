<template>
  <v-container>
    <v-card>
      <v-card-title class="text-h4">
        {{ formTitle }}
      </v-card-title>
      <v-form
        :disabled="form.processing"
        @submit.prevent="save"
      >
        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12"
                sm="6"
              >
                <v-text-field
                  v-model="form.name"
                  :label="$t('forms.columns.name')"
                  :error-messages="errors['name']"
                />
              </v-col>
              <v-col
                cols="12"
                sm="6"
              >
                <v-text-field
                  v-model="form.value"
                  :label="$t('forms.columns.value')"
                  :error-messages="errors['value']"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn
            color="primary"
            outlined
            text
            @click="$inertia.get(getUserRoute('letters.index'))"
          >
            {{ $t('forms.buttons.cancel') }}
          </v-btn>
          <v-btn
            type="submit"
            color="primary"
            :loading="form.processing"
          >
            {{ $t('forms.buttons.save') }}
          </v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: 'ProductForm',
  props: {
    item: {
      type: Object,
      default: () => ({}),
    },
  },
  data () {
    return {
      form: this.$inertia.form({
        name: this.item.name || '',
        value: this.item.value || '',
      }),
    }
  },
  computed: {
    formTitle () {
      return this.item.id ? this.$t('forms.titles.edit', [this.$t('comps.letter.s')]) : this.$t('forms.titles.new', [this.$t('comps.letter.s')])
    },
    errors () {
      return this.$page.props.errors
    },
    isEdit () {
      return this.item.id
    },
  },
  methods: {
    save () {
      if (!this.isEdit) {
        this.form.post(this.getUserRoute('letters.store'))
      } else {
        this.form.transform((data) => (
          {
            ...data,
            _method: 'PUT',
          })).post(this.getUserRoute('letters.update', { letter: this.item }))
      }
    },
  },
}
</script>
