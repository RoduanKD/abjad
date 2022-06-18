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
              <v-col cols="12">
                <v-select
                  v-model="form.type"
                  :label="$t('forms.columns.type')"
                  :error-messages="errors['type']"
                  :items="types"
                  required
                />
              </v-col>
              <v-col cols="12">
                <v-divider />
              </v-col>
              <v-col
                cols="12"
                sm="4"
              >
                <v-text-field
                  v-model="form.question.text"
                  :label="$t('forms.columns.question.text')"
                  :error-messages="errors['question.text']"
                  required
                />
              </v-col>
              <v-col
                cols="12"
                sm="4"
              >
                <v-file-input
                  v-model="form.question.voice"
                  :label="$t('forms.columns.question.voice')"
                  :error-messages="errors['question.voice']"
                  required
                  accept="audio/mp3,audio/wav"
                />
              </v-col>
              <v-col
                v-if="form.type === 'multiple_choice'"
                cols="12"
                sm="4"
              >
                <v-file-input
                  v-model="form.question.image"
                  :label="$t('forms.columns.question.image')"
                  :error-messages="errors['question.image']"
                />
              </v-col>
              <v-col cols="12">
                <v-divider />
              </v-col>
              <template v-if="form.type === 'video_tutorial'">
                <v-col cols="4">
                  <v-text-field
                    v-model="form.attributes.video_url"
                    :label="$t('forms.columns.video_url')"
                    :error-messages="errors['attributes.video_url']"
                  />
                </v-col>
              </template>
              <template v-if="form.type === 'multiple_choice'">
                <v-card-title>الخيارات</v-card-title>
                <v-col
                  v-for="(choice, i) in form.attributes.choices"
                  :key="i"
                  cols="12"
                >
                  <v-row>
                    <v-col
                      cols="1"
                      class="d-flex align-center"
                    >
                      <v-radio-group v-model="form.attributes.correct_choice_index">
                        <v-radio
                          color="success"
                          class="mx-1"
                          :value="i"
                        />
                      </v-radio-group>
                    </v-col>
                    <v-col cols="5">
                      <v-text-field
                        v-model="choice.text"
                        :label="$t('forms.columns.text')"
                        :error-messages="errors[`attributes.choices.${i}.text`]"
                      />
                    </v-col>
                    <v-col cols="5">
                      <v-file-input
                        v-model="choice.image"
                        :label="$t('forms.columns.image')"
                        :error-messages="errors[`attributes.choices.${i}.image`]"
                      />
                    </v-col>
                  </v-row>
                </v-col>
              </template>
              <template v-if="form.type === 'listen_and_repeat'">
                <v-card-title>التسجيلات</v-card-title>
                <v-col
                  v-for="(recording, i) in form.attributes.recordings"
                  :key="i"
                  cols="12"
                >
                  <v-row>
                    <v-col cols="5">
                      <v-text-field
                        v-model="recording.text"
                        :label="$t('forms.columns.text')"
                        :error-messages="errors[`attributes.recordings.${i}.text`]"
                      />
                    </v-col>
                    <v-col cols="5">
                      <v-file-input
                        v-model="recording.voice"
                        :label="$t('forms.columns.voice')"
                        :error-messages="errors[`attributes.recordings.${i}.voice`]"
                      />
                    </v-col>
                  </v-row>
                </v-col>
              </template>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn
            color="primary"
            outlined
            text
            @click="$inertia.get(getUserRoute('letters.exercises.index'))"
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
    letter: {
      type: Object,
      default: () => ({}),
    },
    types: {
      type: Array,
      default: () => ([]),
    },
  },
  data () {
    return {
      form: this.$inertia.form({
        type: this.item.type || '',
        question: this.item.question || {
          text: '',
          voice: undefined,
          image: undefined,
        },
        attributes: this.item.attributes || {
          video_url: undefined,
          correct_choice_index: undefined,
          choices: [
            {
              text: undefined,
              image: undefined,
            },
            {
              text: undefined,
              image: undefined,
            },
            {
              text: undefined,
              image: undefined,
            },
          ],
          recordings: [
            {
              text: undefined,
              voice: undefined,
            },
            {
              text: undefined,
              voice: undefined,
            },
            {
              text: undefined,
              voice: undefined,
            },
            {
              text: undefined,
              voice: undefined,
            },
          ],
        },
      }),
    }
  },
  computed: {
    formTitle () {
      return this.item.id ? this.$t('forms.titles.edit', [this.$t('comps.exercise.s')]) : this.$t('forms.titles.new', [this.$t('comps.exercise.s')])
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
        this.form.transform(data => {
          const payload = {
            type: data.type,
            question: {
              text: data.question.text,
              voice: data.question.voice,
            },
          }

          if (data.type === 'listen_and_repeat') {
            payload.attributes = { recordings: data.attributes.recordings }
          }

          if (data.type === 'video_tutorial') {
            payload.attributes = { video_url: data.attributes.video_url }
          }

          if (data.type === 'multiple_choice') {
            if (data.question.image) {
              payload.question.image = data.question.image
            }
            payload.attributes = {
              correct_choice_index: data.attributes.correct_choice_index,
              choices: data.attributes.choices,
            }
          }

          return payload
        }).post(this.getUserRoute('letters.exercises.store', { letter: this.letter }))
      } else {
        this.form.transform((data) => (
          {
            ...data,
            _method: 'PUT',
          })).post(this.getUserRoute('letters.exercises.update', { exercise: this.item }))
      }
    },
  },
}
</script>
