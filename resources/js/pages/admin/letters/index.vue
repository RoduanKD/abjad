<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title class="text-h4">
            {{ $t('comps.letter.p') }}
            <v-spacer />
            <v-btn
              color="primary"
              dark
              @click="$inertia.get(getUserRoute('letters.create'))"
            >
              {{ $t('forms.titles.new', [$t('comps.letter.s')]) }}
            </v-btn>
          </v-card-title>
        </v-card>
      </v-col>
      <v-col
        v-for="letter in letters"
        :key="letter.id"
        md="6"
        lg="4"
        xl="3"
      >
        <v-card @click="$inertia.get(getUserRoute('letters.exercises.index', letter))">
          <v-card-title>
            {{ letter.name }}
          </v-card-title>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'LettersIndex',

  props: {
    letters: {
      type: Array,
      default: () => ([]),
    },
  },
}
</script>

<style>

</style>
