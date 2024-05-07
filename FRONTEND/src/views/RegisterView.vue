<script setup>
import { ref } from 'vue'
import { useUser } from '@/stores/user.js'

const user = useUser()
const form = ref({
  full_name: '',
  bio: '',
  username: '',
  password: '',
  is_private: false
})

const error = ref({
  username: '',
  password: ''
})

const register = async () => {
  let { full_name, bio, username, password } = form.value
  await user.register(full_name, bio, username, password).catch(({ response }) => {
    let data = response.data
    let msg = data.message
    alert(msg)
  })
}
</script>
<template>
  <div class="container-fluid">
    <h2 class="text-center">Register</h2>
    <div class="container">
      <form @submit.prevent="register()" class="card">
        <div class="card-body">
          <div class="mb-2">
            <label for="full_name">Fullname</label>
            <input
              type="text"
              name="full_name"
              v-model="form.full_name"
              class="form-control"
              required
            />
            <div class="invalid-feedback">{{ error }}</div>
          </div>
          <div class="mb-2">
            <label for="bio">Bio</label>
            <input type="text" name="bio" v-model="form.bio" class="form-control" required />
            <div class="invalid-feedback">{{ error }}</div>
          </div>
          <div class="mb-2">
            <label for="username">Username</label>
            <input
              type="text"
              name="username"
              v-model="form.username"
              class="form-control"
              required
            />
            <div class="invalid-feedback">{{ error }}</div>
          </div>

          <div class="mb-2">
            <label for="password">Password</label>
            <input
              type="password"
              name="password"
              v-model="form.password"
              class="form-control"
              required
            />
          </div>
          <div class="mb-2 d-flex gap-1 align-items-center">
            <label for="is_private">
              <input type="checkbox" name="is_private" v-model="form.is_private" />
              is private
            </label>
          </div>
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </form>
    </div>
  </div>
</template>
