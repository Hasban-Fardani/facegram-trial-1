<script setup>
import { RouterLink } from 'vue-router'
import { useUser } from '@/stores/user.js'

const user = useUser()
</script>
<template>
  <header>
    <nav class="navbar navbar-expand-md">
      <div class="container-fluid">
        <RouterLink to="/" class="navbar-brand fw-bold"> Facegram </RouterLink>

        <div class="d-flex align-items-center" v-if="user.isLogin">
          <RouterLink class="btn" :to="'/profile/' + user.name">{{ user.name }}</RouterLink>
          <button class="btn" @click="user.logout()">Logout</button>
        </div>

        <div class="d-flex align-items-center" v-else>
          <RouterLink to="/login" class="btn">Login</RouterLink>
        </div>
      </div>
    </nav>
  </header>
</template>
