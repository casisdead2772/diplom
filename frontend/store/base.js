export const state = () => ({
  countryItems: [],
  subjectItems: [],
  languageItems: [],
  languageGradeItems: [],
  reservedLessonsCount: 0
})

export const mutations = {
  SET_COUNTRIES (state, payload) {
    state.countryItems = payload
  },
  SET_SUBJECTS (state, payload) {
    state.subjectItems = payload
  },
  SET_LANGUAGES (state, payload) {
    state.languageItems = payload
  },
  SET_LANGUAGE_GRADES (state, payload) {
    state.languageGradeItems = payload
  },
  SET_RESERVED_COUNT (state, payload) {
    state.reservedLessonsCount = payload
  }
}

export const actions = {
  async fetchCountries ({ commit }) {
    const { data } = await this.$axios.$get('countries')
    commit('SET_COUNTRIES', data)
  },
  async fetchSubjects ({ commit }) {
    const { data } = await this.$axios.$get('subjects')
    commit('SET_SUBJECTS', data)
  },
  async fetchLanguages ({ commit }) {
    const { data } = await this.$axios.$get('languages')
    commit('SET_LANGUAGES', data)
  },
  async fetchLanguageGrades ({ commit }) {
    const { data } = await this.$axios.$get('language-grades')
    commit('SET_LANGUAGE_GRADES', data)
  },
  async fetchReservedLessonsCount ({ commit }) {
    const { data } = await this.$axios.$get('reserved-count')
    commit('SET_RESERVED_COUNT', data.reserved_count)
  }
}
