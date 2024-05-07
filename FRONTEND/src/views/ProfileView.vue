<script setup>
import { useUser } from '@/stores/user'
import axios from 'axios'
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'

const user = useUser()
const route = useRoute()

let username = route.params.username
username = username ? username : user.name

const userProfile = ref({
  full_name: '',
  bio: '',
  username: '',
  is_private: '',
  posts: [],
  is_your_account: false,
  following_status: 'not-following',
  followers_count: 0,
  following_count: 0
})

let loadingView = ref(true)

const unfollow = async () => {
  await axios
    .post(
      `/users/${username}/unfollow`,
      {
        _method: 'DELETE'
      },
      {
        headers: {
          Authorization: 'Bearer ' + user.token
        }
      }
    )
    .then(() => {
      location.reload()
    })
}

const follow = async () => {
  await axios
    .post(`/users/${username}/follow`, null, {
      headers: {
        Authorization: 'Bearer ' + user.token
      }
    })
    .then(() => {
      location.reload()
    })
}

onMounted(async () => {
  await axios
    .get('/users/' + username, {
      headers: {
        Authorization: 'Bearer ' + user.token
      }
    })
    .then(({ data }) => {
      userProfile.value = data.user
    })

  loadingView.value = false
})
</script>
<template>
  <div class="container-fluid" v-if="!loadingView">
    <div class="d-flex gap-2">
      <h3>{{ userProfile.full_name }}</h3>
      <div v-if="!userProfile.is_your_account">
        <div class="d-flex gap-2 align-items-center">
          <button
            class="btn btn-primary btn-sm"
            @click="follow()"
            v-if="!userProfile.is_your_account && userProfile.following_status == 'not-following'"
          >
            Follow
          </button>
          <p v-else-if="userProfile.following_status == 'requested'">Requested</p>
          <p v-else-if="userProfile.following_status == 'following'">Followed</p>

          <button
            v-if="
              userProfile.following_status == 'following' ||
              userProfile.following_status == 'requested'
            "
            class="btn btn-danger btn-sm"
            @click="unfollow()"
          >
            Unfollow
          </button>
        </div>
        <p v-if="userProfile.is_private">this account is private</p>
      </div>
    </div>
    <p>{{ userProfile.bio }}</p>
    <div class="d-flex gap-3">
      <span>{{ userProfile.followers_count }} Folowers</span>
      <span>{{ userProfile.following_count }} Folowing</span>
    </div>
    <div class="container-fluid">
      <div class="row">
        <!-- <div class="col-6"></div>
        <div class="col-6"></div> -->
      </div>
    </div>
    <div class="d-flex flex-wrap gap-3 mt-3">
      <div class="card" v-for="post in userProfile.posts">
        <div class="card-body">
          <p>{{ post.caption }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.card {
  width: 150px;
  height: 200px;
}
</style>
