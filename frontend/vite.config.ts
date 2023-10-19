import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  server: {
    // You may need to uncomment and set this value to run this on a non-standard port as I did
    //port: 9000
  }
})
