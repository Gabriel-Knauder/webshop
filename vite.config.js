// vite.config.ts
import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
<<<<<<< HEAD
    server: {
    proxy: {
      '/mail.php': 'http://localhost:8000'
    }
  }
})
=======
})
>>>>>>> 05510e1e12fa0641b48475bb6640409be8b831f7
