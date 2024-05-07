<script setup>
import router from '@/router'
import { useUser } from '@/stores/user'
import axios from 'axios'
import { ref } from 'vue'

const user = useUser()
const attachments = ref(null)
const caption = ref()
const createPost = async () => {
  const formData = new FormData()

  formData.append('caption', caption.value)
  for (const file of attachments.value.files) {
    formData.append('attachments[]', file, file.name)
  }

  await axios
    .post('/posts', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        Authorization: 'Bearer ' + user.token
      }
    })
    .then((res) => {
      alert('Create post success')
      router.push('/profile')
    })
    .catch((res) => {
      console.log(res)
    })
}
</script>
<template>
  <main class="container-fluid">
    <h2>Create new Post</h2>
    <div>
      <form @submit.prevent="createPost()">
        <div class="mb-3">
          <label for="caption" class="form-label">Caption</label>
          <input type="text" name="caption" class="form-control" v-model="caption" required />
        </div>
        <div class="mb-3">
          <label for="attachments" class="form-label">Attachments</label>
          <input
            type="file"
            name="attacments"
            class="form-control"
            ref="attachments"
            multiple
            required
          />
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
      </form>
    </div>
  </main>
</template>
