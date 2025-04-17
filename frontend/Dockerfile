FROM node:18-alpine as base

WORKDIR /app

RUN apk -U add --no-cache libc6-compat
RUN corepack enable \
    && corepack prepare pnpm@7.9.5 --activate

FROM base as deps

COPY package*.json pnpm*.yaml tsconfig*.json ./
RUN pnpm i --frozen-lockfile

FROM base AS build

COPY --from=deps /app/node_modules ./node_modules
COPY . .

RUN pnpm build

FROM node:18.8-alpine AS production

WORKDIR /app

ENV NODE_ENV production
ENV NEXT_TELEMETRY_DISABLED 1

COPY --from=build /app/public ./public
COPY --from=build /app/package.json ./package.json
COPY --from=build /app/next.config.js ./next.config.js

COPY --from=build --chown=node:node /app/.next/standalone ./
COPY --from=build --chown=node:node /app/.next/static ./.next/static

USER node
ARG PORT=80
EXPOSE $PORT
ENV PORT $PORT

CMD ["node", "server.js"]
