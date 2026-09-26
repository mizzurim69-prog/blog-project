<template>
  <div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">Blog posts</h2>
        <Link
          href="/blogs/create"
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
          New Post
        </Link>
      </div>

      <div v-if="!blogs || blogs.length === 0" class="bg-white p-8 rounded-lg shadow text-center">
        <p class="text-gray-600">No blog posts yet. Create your first post to get started.</p>
        <div class="mt-4">
          <Link href="/blogs/create" class="text-indigo-600 hover:underline">Create a blog post</Link>
        </div>
      </div>

      <div v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mt-6">
        <div v-for="blog in blogs" :key="blog.id" class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-150">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-indigo-600">
              <Link :href="`/blogs/${blog.id}`">{{ blog.title }}</Link>
            </h3>
            <p class="text-sm text-gray-600 mb-4">{{ excerpt(blog.description) }}</p>

            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <Link :href="`/blogs/${blog.id}`" class="text-sm text-gray-500 hover:underline">View</Link>
                <a :href="`/blogs/${blog.id}/edit`" class="text-sm text-indigo-600 hover:underline">Edit</a>
              </div>

              <button
                @click.prevent="deleteBlog(blog)"
                class="text-sm text-red-600 hover:underline"
                type="button"
              >
                Delete
              </button>
            </div>
          </div>
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
    blogs: {
      type: Array,
    },
  },
  methods: {
    deleteBlog(blog) {
      if (!confirm(`Delete "${blog.title}"? This cannot be undone.`)) return;
      this.$inertia.delete(`/blogs/${blog.id}`);
    },
    excerpt(text) {
      if (!text) return '';
      const clean = String(text).replace(/\s+/g, ' ').trim();
      return clean.length > 140 ? clean.slice(0, 137) + '...' : clean;
    }
  }
};
</script>