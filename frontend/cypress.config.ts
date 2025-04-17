import { defineConfig } from 'cypress'

export default defineConfig({
    projectId: 'yyt6mi',
    defaultCommandTimeout: 8000,
    fixturesFolder: false,
    screenshotsFolder: false,
    video: false,

    e2e: {
        baseUrl: 'http://localhost:3000',
        experimentalSessionAndOrigin: true,
    },

    component: {
        devServer: {
            framework: 'next',
            bundler: 'webpack',
        },
    },

    env: {
        API_URL: 'http://localhost:8000/api',
    },
})
