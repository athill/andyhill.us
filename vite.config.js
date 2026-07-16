import { defineConfig } from 'vite'
import { dirname, resolve } from 'node:path'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  // entry: resolve(dirname(import.meta.url), 'src/index.js'),
  publicDir: 'build/public',
  build: {
    rollupOptions: {
      outDir: '../build',
      input: {
        main: resolve(import.meta.dirname, 'public/index.html'),
      },
    },
  },
  plugins: [
    react({
      babel: {
        plugins: [['babel-plugin-react-compiler']],
      },
    }),
  ],
})
