// @ts-check

/**
 * @type {import('next').NextConfig}
 */
const nextConfig = {
    reactStrictMode: process.env.NODE_ENV === 'development',
    swcMinify: true,
    compress: true,
    output: 'standalone',
    sassOptions: {
        includePaths: [require('path').join(__dirname, './shared/styles')],
        prependData:
            '@import "styles/variables"; \
            @import "styles/mixins"; \
            @import "styles/animations"; \
            @import "styles/medias";',
    },
    images: {
        domains: ['via.placeholder.com'],
    },
}

module.exports = nextConfig
