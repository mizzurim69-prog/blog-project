<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 p-4">
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-md p-6">
      <h1 class="text-2xl font-semibold mb-4">Create a Blog Post</h1>

      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
          <input
            id="title"
            v-model="form.title"
            placeholder="Enter blog title"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
          />
        </div>
        <div class="text-red-500 text-sm">{{ $page.props.errors.title }}</div>

        <div>
          <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
          <textarea
            id="content"
            v-model="form.content"
            placeholder="Enter blog content"
            rows="8"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
          ></textarea>
        </div>
        <div class="text-red-500 text-sm">{{ $page.props.errors.content }}</div>

        <div class="flex items-center justify-between">
          <button
            type="submit"
            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400"
          >
            Create
          </button>

          <a href="/blogs" class="text-sm text-gray-600 hover:underline">Back to list</a>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        title: '',
        content: '',
      },
    }
  },
  methods: {
    submit() {
      // post the form to the store endpoint
      this.$inertia.post('/blogs/store', this.form);
    }
  }
}

</script>

