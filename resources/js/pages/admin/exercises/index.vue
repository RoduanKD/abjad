<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title class="text-h4">
            {{ $t('comps.exercise.p') }}: {{ letter.name }}
            <v-spacer />
            <v-btn
              color="primary"
              dark
              @click="$inertia.get(getUserRoute('letters.exercises.create', letter))"
            >
              {{ $t('forms.titles.new', [$t('comps.exercise.s')]) }}
            </v-btn>
          </v-card-title>
        </v-card>
      </v-col>
      <v-col
        v-for="exercise in exercises"
        :key="exercise.id"
        md="6"
        lg="4"
        xl="3"
      >
        <v-card>
          <v-card-title>
            {{ exercise.question }}
          </v-card-title>
          <v-card-text>
            {{ $t('forms.columns.type') }}: {{ exercise.type }}
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import AdminLayout from '@/layouts/AdminLayout'

export default {
  name: 'ExercisesIndex',

  layout: AdminLayout,

  props: {
    exercises: {
      type: Array,
      default: () => ([]),
    },
    letter: {
      type: Object,
      default: () => ({}),
    },
  },
}
</script>

<style>

</style>
