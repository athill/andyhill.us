import { defineConfig } from 'vite'
import { dirname, resolve } from 'node:path'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  root: 'public',
  publicDir: '../public',
  build: {
    outDir: '../build', // CRA's default build output
  },
})
