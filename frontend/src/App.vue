<script lang="ts">
import {useAuth0} from "@auth0/auth0-vue"
import axios from "axios"
import {ref} from "vue"
import Country from "./components/Country.vue"

export default {
  components: {
    Country
  },

  setup() {
    const auth0 = useAuth0()
    const countries = ref<Country[]>([])
    const hasError = ref<boolean>(false)

    return {
      isAuthenticated: auth0.isAuthenticated,
      isLoading: auth0.isLoading,
      user: auth0.user,
      countries,
      hasError,
      login() {
        auth0.loginWithRedirect()
      },
      logout() {
        auth0.logout({
          logoutParams: {
            returnTo: window.location.origin
          }
        })
      },
      async callApi() {
        const accessToken = await auth0.getAccessTokenSilently()
        try {
          hasError.value = false
          const response = await axios.get("http://localhost/api/countries", {
            headers: {
              Authorization: `Bearer ${accessToken}`,
            },
          })
          countries.value = response.data.data
        } catch (e: any) {
          hasError.value = true
        }
      }
    }
  }
}
</script>

<template>
  <div class="text-center">
    <h1 class="text-6xl">Raketech Challenge - Country directory</h1>
    <p class="mt-2">
      {{
        isAuthenticated
            ? 'Click the Get Countries button to get a list of all countries from the server'
            : 'Welcome! Start by logging in. You will then be able to perform an authenticated request to see a list of all countries.'
      }}
    </p>
  </div>

  <div class="flex flex-row justify-center mt-12">
    <div v-if="!isAuthenticated && !isLoading">
      <button @click="login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Log in</button>
    </div>
    <div v-if="isAuthenticated" class="flex space-x-3">
      <button @click="logout" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">Logout</button>
      <button
          @click="callApi"
          class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded disabled:bg-gray-200 disabled:cursor-not-allowed"
          :disabled="countries.length > 0"
      >
        Get Countries
      </button>
    </div>
  </div>

  <hr class="mt-2">

  <div class="text-center" v-if="hasError">
    <small>There was an error when requesting countries. Please <a href="#" @click.prevent="callApi" class="text-blue-600">try again</a>.</small>
  </div>
  <div v-if="countries.length > 0" class="grid grid-cols-12 gap-4">
    <Country class="hover:-mt-2" :country="country" v-for="(country, idx) in countries" :key="idx"/>
  </div>
</template>