import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import { resolve } from "path";

export default defineConfig({
    plugins: [react()],
    build: {
        outDir: "public/build", // Directory where built files will go
        manifest: "manifest.json", // Generate a manifest.json in outDir
        rollupOptions: {
            input: resolve(__dirname, "resources/js/app.jsx"),
        },
    },
    publicDir: "resources/static", // Directory for static assets, you can customize this
    server: {
        host: "0.0.0.0", // Listen on all network interfaces
        port: 5173, // Ensure this matches your exposed port
        watch: {
            usePolling: true, // This helps with file changes being detected correctly in Docker
        },
    },
    resolve: {
        alias: {
            "@": resolve(__dirname, "resources/js"),
        },
    },
});
