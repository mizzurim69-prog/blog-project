<template>
  <div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4">
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-5 border-b">
          <div class="flex items-start justify-between">
            <div class="pr-6">
              <h1 class="text-2xl font-extrabold text-gray-900 leading-tight">{{ blog.title }}</h1>
              <div class="mt-2 text-sm text-gray-500">
                <span v-if="blog.author">By {{ blog.author }}</span>
                <span v-if="blog.author && formattedDate"> · </span>
                <span v-if="formattedDate">{{ formattedDate }}</span>
              </div>
            </div>

            <div class="flex items-center space-x-3">
              <Link href="/blogs" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                Back
              </Link>

              <Link v-if="blog && blog.id" :href="`/blogs/${blog.id}/edit`" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Edit
              </Link>

              <button
                v-if="blog && blog.id"
                @click="destroy"
                class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                aria-label="Delete blog"
              >
                Delete
              </button>
            </div>
          </div>
        </div>

        <div class="px-6 py-8">
          <article class="prose prose-lg max-w-none text-gray-800">
            <p v-if="blog.description" class="whitespace-pre-wrap">{{ blog.description }}</p>
            <p v-else class="text-gray-500">No content available.</p>
          </article>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
  components: { Link },
  props: {
    blog: {
      type: Object,
      default: () => ({})
    }
  },
  computed: {
    formattedDate() {
      if (!this.blog || !this.blog.created_at) return '';
      try {
        return new Date(this.blog.created_at).toLocaleDateString();
      } catch (e) {
        return this.blog.created_at;
      }
    }
  },
  methods: {
    destroy() {
      if (!confirm(`Delete "${this.blog.title}"? This cannot be undone.`)) return;
      this.$inertia.delete(`/blogs/${this.blog.id}`, {
        onSuccess: () => {
          // Server may redirect; on success ensure we are on the index
          // Inertia will usually follow server redirects.
        }
      });
    }
  }
}
</script>