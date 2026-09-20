import { defineConfig } from 'vite'
import react, { reactCompilerPreset } from '@vitejs/plugin-react'
import babel from '@rolldown/plugin-babel'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react(), babel({ presets: [reactCompilerPreset()] })],
  server: {
    host: '0.0.0.0',
    port: 5174,
    strictPort: false,
    proxy: {
      '/api': 'http://127.0.0.1:8000',
      '/login': {
        target: 'http://127.0.0.1:8000',
        bypass: (request) => (request.method === 'GET' ? '/index.html' : undefined),
      },
      '/logout': {
        target: 'http://127.0.0.1:8000',
        bypass: (request) => (request.method === 'GET' ? '/index.html' : undefined),
      },
      '/applicant/register': {
        target: 'http://127.0.0.1:8000',
        bypass: (request) => (request.method === 'GET' ? '/index.html' : undefined),
      },
      '/admin/reports/print': 'http://127.0.0.1:8000',
      '/admin/reports/preview': 'http://127.0.0.1:8000',
      '/admin/reports/pdf': 'http://127.0.0.1:8000',
    },
  },
  preview: {
    host: '0.0.0.0',
    port: 4173,
  },
})
