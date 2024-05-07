import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import router from '@/router'

export const useUser = defineStore('user', () => {
  const token = computed(() => localStorage.getItem('token'))
  const name = computed(() => localStorage.getItem('name'))
  const isPrivate = computed(() => localStorage.getItem('is_private'))
  const isLogin = token && name

  const login = async (username, password) => {
    return axios
      .post('/auth/login', {
        username: username,
        password: password
      })
      .then(({ data }) => {
        localStorage.setItem('token', data.token)
        localStorage.setItem('name', data.user.username)
        localStorage.setItem('is_private', data.user.is_private)
        location.reload()
        alert('Login success')
      })
  }

  const logout = async () => {
    return axios
      .post('/auth/logout', null, {
        headers: {
          Authorization: 'Bearer ' + token.value
        }
      })
      .catch(() => {
        console.log(token)
      })
      .then(() => {
        alert('Logout success')
      })
      .finally(() => {
        clear()
        location.reload()
        router.push('/login')
      })
  }

  const register = async (full_name, bio, username, password) => {
    return axios
      .post('/auth/register', {
        full_name: full_name,
        bio: bio,
        username: username,
        password: password
      })
      .then(() => {
        alert('Register success')
      })
      .finally(() => {
        location.reload()
        router.push('/login')
      })
  }

  const clear = () => {
    localStorage.clear()
  }

  return { token, name, isLogin, isPrivate, clear, login, logout, register }
})
