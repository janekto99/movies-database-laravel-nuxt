# Build stage
FROM node:22-alpine AS build

WORKDIR /var/www/nuxt

COPY package*.json ./
RUN npm install

COPY . .

# Run stage
FROM node:22-alpine

WORKDIR /var/www/nuxt

COPY --from=build /var/www/nuxt .

ENV HOST 0.0.0.0
EXPOSE 3000

CMD npm run dev
