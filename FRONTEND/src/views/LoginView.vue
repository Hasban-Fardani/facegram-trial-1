<script setup>
import { ref } from 'vue'
import { useUser } from '@/stores/user.js'

const user = useUser()
const form = ref({
  username: '',
  password: ''
})

const error = ref({
  username: '',
  password: ''
})

const login = async () => {
  let { username, password } = form.value
  await user.login(username, password).catch(({ response }) => {
    let data = response.data
    let msg = data.message
    alert(msg)
  })
}
</script>
<template>
  <div class="container-fluid">
    <h2 class="text-center">Login</h2>
    <div class="container">
      <form @submit.prevent="login()" class="card">
        <div class="card-body">
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
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </div>
</template>
