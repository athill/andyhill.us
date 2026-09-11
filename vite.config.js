import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react(), tailwindcss()],
  root: 'public',
  publicDir: '../public',
  build: {
    outDir: '../build', // CRA's default build output
  },
})
