<script setup>
import axios from 'axios'
import { useUser } from '@/stores/user'
import { ref, onMounted } from 'vue'

const posts = ref([])
const users = ref(null)
const requestedFollowers = ref(null)
const user = useUser()

let currentPage = 0
let size = 10

const loadPosts = async (page, size) => {
  console.log('Load posts')
  let url = '/posts?page=' + String(page) + '&size=' + String(size)
  return await axios
    .get(url, {
      headers: {
        Authorization: 'Bearer ' + user.token
      }
    })
    .then(({ data }) => {
      const newPosts = data.posts

      const uniqueNewPosts = newPosts.filter(
        (newPost) => !posts.value.some((existingPost) => existingPost.id === newPost.id)
      )

      posts.value = posts.value.concat(uniqueNewPosts)
    })
}

const loadPeople = async () => {
  console.log('Load People not following')
  let tmpUSer = []
  let following = []
  await axios
    .get('/users', {
      headers: {
        Authorization: 'Bearer ' + user.token
      }
    })
    .then(({ data }) => {
      tmpUSer = data.users
    })

  await axios
    .get('/following', {
      headers: {
        Authorization: 'Bearer ' + user.token
      }
    })
    .then(({ data }) => {
      following = data.following
      users.value = tmpUSer.filter((usr) => {
        return !following.some((follow) => follow.id === usr.id)
      })
    })
}

const loadRequested = async () => {
  console.log('Load requested follow')
  axios
    .get('/followers', {
      headers: {
        Authorization: 'Bearer ' + user.token
      }
    })
    .then(({ data }) => {
      requestedFollowers.value = data.followers.filter((usr) => usr.is_requested)
    })
}

onMounted(async () => {
  await loadPeople()
  await loadPosts(currentPage, size)
  await loadRequested()
})

const onScrollFeed = async (e) => {
  const element = e.target
  if (element.scrollHeight - element.scrollTop <= element.clientHeight + 2) {
    currentPage += 1
    size = 7
    await loadPosts(currentPage, size)
  }
}

const acceptFollow = async (username) => {
  axios
    .put(`/users/${username}/accept`, null, {
      headers: {
        Authorization: 'Bearer ' + user.token
      }
    })
    .then((res) => {
      console.log(res)
    })
}
</script>
<template>
  <main class="container-fluid">
    <div class="explore-section">
      <h2>users</h2>
      <div class="d-flex overflow-x-auto" v-if="users">
        <div v-for="people in users">
          <RouterLink :to="`/profile/${people.username}`" class="btn">
            {{ people.username }}
          </RouterLink>
        </div>
      </div>
      <div v-else>
        <p>No users not following</p>
      </div>
    </div>

    <div class="requested-section">
      <h2>Requested follow</h2>
      <div class="d-flex overflow-x-auto" v-if="requestedFollowers">
        <div v-for="userRequested in requestedFollowers">
          <p class="btn">
            {{ userRequested.username }}
          </p>
          <button @click="acceptFollow(userRequested.username)">Accept</button>
        </div>
      </div>
      <div v-else>
        <p>No requested followers</p>
      </div>
    </div>

    <div @scroll="onScrollFeed" class="scrollable">
      <h2>Newest Post</h2>
      <div class="d-flex flex-column gap-2">
        <div class="card" v-for="post in posts">
          <div class="card-body">
            {{ post.caption }}
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<style scoped>
.scrollable {
  overflow-y: scroll;
  height: calc(100vh - 80px);
}

.scrollable::-webkit-scrollbar {
  display: none;
}
</style>
