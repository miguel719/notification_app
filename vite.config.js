import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import { resolve } from "path";

export default defineConfig({
    plugins: [react()],
    build: {
        outDir: "public/build",
        manifest: "manifest.json",
        rollupOptions: {
            input: resolve(__dirname, "resources/js/app.jsx"),
        },
    },
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
