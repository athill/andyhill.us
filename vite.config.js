import path from 'path'
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react(), tailwindcss()],
  root: 'public',
  publicDir: '../public',
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src')
    }
  },
  sourcemap: true,
  build: {
    outDir: '../build', // CRA's default build output
    emptyOutDir: true,
  },
})
