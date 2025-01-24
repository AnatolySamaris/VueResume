import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue(), vueDevTools()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  build: {
    outDir: '../backend/app/public/dist',
    emptyOutDir: true
  },
  server: {
    proxy: {
      '/vkapi': {
        target: 'https://api.vk.com',
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/vkapi/, '')
      },
      '/api': {
        target: 'http://127.0.0.1:8080',
        changeOrigin: true,
      }
    }
  }
})
