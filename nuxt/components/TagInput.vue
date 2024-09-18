<script setup>
const props = defineProps({
  dataFetch: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits(['update:selectedTags'])

const selectedTags = ref([])
const inputValue = ref('')
const filteredSuggestions = ref([])
const showSuggestions = ref(false)
const selectedIndex = ref(-1)
const isFocused = ref(false)

const items = ref(props.dataFetch)

const clearTags = () => {
  selectedTags.value = []
  emit('update:selectedTags', selectedTags.value)
  emit('tags-cleared')
}

defineExpose({ clearTags })

const filterSuggestions = () => {
  if (inputValue.value.trim()) {
    filteredSuggestions.value = items.value.filter(actor =>
        actor.name.toLowerCase().includes(inputValue.value.toLowerCase()) &&
        !selectedTags.value.some(tag => tag.id === actor.id)
    )
    showSuggestions.value = filteredSuggestions.value.length > 0
  } else {
    showSuggestions.value = false
    filteredSuggestions.value = []
  }
  selectedIndex.value = -1
}

const addTag = () => {
  if (selectedIndex.value !== -1) {
    selectSuggestion(filteredSuggestions.value[selectedIndex.value])
  } else if (filteredSuggestions.value.length === 1) {
    selectSuggestion(filteredSuggestions.value[0])
  }
}

const removeTag = (tagToRemove) => {
  selectedTags.value = selectedTags.value.filter(tag => tag.id !== tagToRemove.id)
  emit('update:selectedTags', selectedTags.value)
}

const selectSuggestion = (suggestion) => {
  if (!selectedTags.value.some(tag => tag.id === suggestion.id)) {
    selectedTags.value.push(suggestion)
    inputValue.value = ''
    showSuggestions.value = false
    emit('update:selectedTags', selectedTags.value)
  }
}

const navigateSuggestions = (direction) => {
  if (showSuggestions.value) {
    selectedIndex.value = (selectedIndex.value + direction + filteredSuggestions.value.length) % filteredSuggestions.value.length
  }
}

</script>

<template>
  <div class="relative flex flex-col w-64">
    <label for="tagInput">Actors</label>
    <div class="min-h-[96px] flex flex-wrap gap-2 p-2 bg-slate-700 rounded relative">
      <div v-for="tag in selectedTags" :key="tag.id" class="bg-slate-600 text-white px-2 py-1 rounded flex items-center text-sm">
        {{ tag.name }}
        <button @click="removeTag(tag)" class="ml-2 text-slate-300 hover:text-white">&times;</button>
      </div>
      <div class="flex-grow min-w-[80px] relative">
        <input
            id="tagInput"
            v-model="inputValue"
            @input="filterSuggestions"
            @keydown.enter.prevent="addTag"
            @keydown.down.prevent="navigateSuggestions(1)"
            @keydown.up.prevent="navigateSuggestions(-1)"
            @focus="isFocused = true"
            @blur="() => { isFocused = false; showSuggestions = false; }"
            type="text"
            autocomplete="off"
            class="bg-transparent outline-none w-full text-white cursor-text pt-3"
        />
        <span
            v-if="!inputValue && selectedTags.length === 0 && !isFocused"
            class="absolute top-0 left-0 text-slate-400 pointer-events-none text-sm"
        >
          Add actor...
        </span>
      </div>
    </div>
    <ul v-if="showSuggestions && inputValue.trim()" class="absolute z-10 w-full bg-slate-700 border border-slate-600 rounded mt-1 max-h-60 overflow-y-auto top-full">
      <li
          v-for="(suggestion, index) in filteredSuggestions"
          :key="suggestion.id"
          @mousedown.prevent="selectSuggestion(suggestion)"
          :class="['px-3 py-2 cursor-pointer hover:bg-slate-600 text-white', { 'bg-slate-600': index === selectedIndex }]"
      >
        {{ suggestion.name }}
      </li>
    </ul>
  </div>
</template>